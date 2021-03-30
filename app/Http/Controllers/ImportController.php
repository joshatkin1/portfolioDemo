<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ImportController extends Controller
{
    private $storage_dir = '2Phtt93Ag66Q8f';
    public  $allowed_csv_ext_types = ["csv", "ods", "txt"];
    public $allowed_csv_mime_types = ["text/plain","text/csv","text/csv-schema","text/spreadsheet","text/x-comma-separated-values","text/x-csv", ];
    public  $allowed_xls_ext_types = ["xls", "xlsm", "xlsx", "xlsb","xlam"];
    public  $allowed_xls_mime_types = ["application/msexcel","text/xls","text/xlsx","application/vnd.ms-excel","application/vnd.ms-excel.addin.macroenabled.12","application/vnd.ms-excel.sheet.binary.macroenabled.12","application/vnd.ms-excel.sheet.macroenabled.12","application/vnd.ms-excel.template.macroenabled.12","application/vnd.oasis.opendocument.spreadsheet","application/vnd.oasis.opendocument.spreadsheet-flat-xml","application/vnd.oasis.opendocument.spreadsheet-template","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/vnd.openxmlformats-officedocument.spreadsheetml.template","application/x-applix-spreadsheet","application/x-msexcel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheetapplication/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
    protected $duplicate_row_array = [];
    public $import_type_headers = [];
    public $import_headers = [];
    public $column_matches = [];
    public $import_type = "";
    public $file_type = "";

    public function __construct(){
        parent::__construct();
    }

    public function completeCustomerImport(Request $request){
        //!!! NEED TO SET THIS TO BE AUTHORITY SETTING FOR CUSTOMER FILE UPLOADS
        if (session('job_level') < 3) {
            return response("invalid authorization" , 401)
                ->header('Content-Type', 'text/plain');
        }

        $this->import_type = "customers";
        $file = $request->file;
        $fields = json_decode($request->fields, true);
        $this->import_additional = $request->import_additional;

        $this->import_type_headers = $this->fetchImportTypeHeaders();//POSSIBLE FIELDS FOR IMPORT (ARRAY)

        if ($this->isValidCSV($file)){
            $this->file_type = "csv";
            $this->import_headers = $this->getCSVFileHeaders($file);//IMPORTED CSV COLUMN HEADERS (ARRAY)
        }else if($this->isValidXLS($file)){
            $this->file_type = "xls";
            $this->import_headers = $this->getXLSFileHeaders($file);//IMPORTED CSV COLUMN HEADERS (ARRAY)
        }else{
            return response('Unsupported File Type' , 406)
                ->header('Content-Type', 'text/plain');
        }

        foreach ($fields as $field) {
            if($field["value"] && in_array($field["value"], $this->import_headers)){
                if($field["key"] && in_array($field["key"], $this->import_type_headers)){
                    $this->column_matches += [$field["value"]  => $field["key"]];
                }
            }
        }

        $customers = ($this->file_type == "csv") ? $this->createCustomersFromCSV($file) : $this->createCustomersFromXLS($file);
        $validation_rules = $this->importTypeValidationRules($this->import_type);
        $validation_errors  = ($this->file_type === "csv") ?  $this->validateCSVValues($customers, $validation_rules) : $this->validateXLSValues($customers, $validation_rules);

        if(count($validation_errors) > 0){
            $invalid_rows = array_keys($validation_errors);
            $invalid_rows = $this->retreiveInvalidImportRows($file, $invalid_rows);
            $invalid_rows = json_encode($invalid_rows);
            return response($invalid_rows , 200)
                ->header('Content-Type', 'text/json');
        }

        try{
            return $this->importCustomerObject($customers);
        }catch(Exception $error){
            return 'error';
        }

        return response('Successfully Imported Customers' , 200)
            ->header('Content-Type', 'text/text');
    }

    public function createCustomersFromCSV($file){
        $file = fopen($file, 'r');
        $data = [];
        $customers = [];
        $headerLine = true;

        while($row = fgetcsv($file, 1000, ",")){
            $current_user = [];

            if($this->checkForDuplicate($row)){
                continue;
            }

            if($headerLine){ $headerLine = false;}
            else {
                $col_index = 0;
                $add_info = [];

                foreach ($row as $r) {

                    $column_name = $this->import_headers[$col_index];
                    $col_index++;

                    if(!array_key_exists($column_name, $this->column_matches)){
                        if($this->import_additional === "true"){
                            $add_info += [$column_name => $r];
                        }
                        continue;
                    }

                    $association = $this->column_matches[$column_name];


                    if ($association && $association !== "") {
                        $current_user += [$association => $r];
                    }
                }

                $current_user += ["additional_information" => $add_info];
                array_push($customers, $current_user);

            }
        }
        return $customers;
    }

    public function createCustomersFromXLS($file){
        return 'not scripted yet';
    }

    public function validateCSVValues($data_row, $rules){
        $validation_errors = [];
        $i = 0;

        foreach($data_row as $d){
            $i++;
            $validator = Validator::make($d, $rules);
            if ($validator->fails()) {
                $validation_errors += [$i => $validator->errors()];
            }
        }
        return $validation_errors;
    }

    public function getCSVColumnRows($file, $index){
        $file = fopen($file, 'r');
        $data = [];

        while($row = fgetcsv($file, 1000, ",")){
            array_push($data, $row[$index]);
        }
        return $data;
    }

    public function startImportFile(Request $request)
    {
        //!!! NEED TO SET THIS TO BE AUTHORITY SETTING FOR CUSTOMER FILE UPLOADS
        if (session('job_level') < 3) {
            return response("authorization failed" , 401)
                ->header('Content-Type', 'text/plain');
        }//MASTER ADMIN AUTH FAILED

        $file = $request->file;

        if ( $this->isValidCSV($file) ){

            $row_count = $this->countCSVRows($file);
            $import_headers = $this->getCSVFileHeaders($file);

        }else if( $this->isValidXLS($file)){
            $row_count = $this->countXLSRows($file);
            $import_headers = $this->getXLSFileHeaders($file);
        }else{
            return response("Unsupported File Type" , 422)
                ->header('Content-Type', 'text/plain');
        }

        if($row_count > 500){
            return response("File row count over 500 limit" , 400)
                ->header('Content-Type', 'text/plain');
        }

        $response = [
            "file_headers" => $import_headers,
        ];

        $response = json_encode($response);

        return response($response , 200)
            ->header('Content-Type', 'text/json');
    }

    public function getCSVFileHeaders($file){
        $file = fopen($file, 'r');
        $import_headers = [];

        while($row = fgetcsv($file)){
            foreach ($row as $r){
                if($r !== ""){
                    array_push($import_headers, $r);
                }
            }
            break;
        }

        return $import_headers;
    }

    public function getXLSFileHeaders($file){
        $file = fopen($file, 'r');
        $import_headers = [];

        while($row = fgetcsv($file)){
            foreach ($row as $r){
                if($r !== ""){
                    array_push($import_headers, $r);
                }
            }
            break;
        }

        return $import_headers;
    }

    public function countCSVRows($file){
        $file = fopen($file, 'r');
        $row_count = 0;

        while($row = fgetcsv($file)){
            $row_count++;
        }

        return $row_count;
    }

    public function checkForDuplicate($row){
        $dup_check = md5(json_encode($row));
        if(in_array($dup_check,$this->duplicate_row_array)){
            return true;
        }else{
            array_push($this->duplicate_row_array, $dup_check);
            return false;
        }
    }

    public function fetchImportTypeHeaders(){
        $model_fields = [];
        switch($this->import_type){
            case 'customers':
                $model_fields = ["account_email","account_telephone","account_number","account_type","account_name","balance","billing_address","shipping_address", "billing_name","billing_account_number","billing_sort_code","master_admin"];
                break;
            default: $model_fields = ["No Import Type Selected"];break;
        }

        return $model_fields;
    }

    public function isValidCSV($file){
        $file_extension = $file->guessExtension();
        $file_mime = $file->getMimeType();
        if(in_array($file_extension, $this->allowed_csv_ext_types) && in_array($file_mime, $this->allowed_csv_mime_types)){
            return true;
        }else{
            return false;
        }
    }

    public function isValidXLS($file){
        $file_extension = $file->guessExtension();
        $file_mime = $file->getMimeType();
        if(in_array($file_extension, $this->allowed_xls_ext_types) && in_array($file_mime, $this->allowed_xls_mime_types)){
            return true;
        }else{
            return false;
        }
    }

    public function importTypeValidationRules($import_type){
        switch($import_type){
            case "customers":
                $validation_rules = [
                    'account_type' => ["sometimes", Rule::in(["Individual", "Business"])],
                    'account_name' => ["required", "string", "max:255"],
                    'account_email' => ["sometimes", "email" , "max:255"],
                ];
                break;
            default: $validation_rules = []; break;
        }

        return $validation_rules;
    }

    public function retreiveInvalidImportRows($file, $invalid_rows){
        $file = fopen($file, 'r');
        $rows = [];
        $i = 0;

        while($row = fgetcsv($file, 1000, ",")){
            if(in_array($i,$invalid_rows)){
                array_unshift($row , $i);
                array_push($rows , $row);
            }

            $i++;
        }
        return $rows;
    }

    protected function importCustomerObject($customers){
        foreach($customers as $customer){

            $keys = array_keys($customer);

            if(!in_array("account_type", $keys)){
                $customer["account_type"] = "Individual";
            }
            if(!in_array("account_email",$keys)){
                $customer["account_email"] = "";
            }
            if(!in_array("account_telephone",$keys)){
                $customer["account_telephone"] = "";
            }
            if(!in_array("account_number",$keys)){
                $customer["account_number"] = "";
            }
            if(!in_array("account_active", $keys)){
                $customer["account_active"] = 1;
            }
            if(!in_array("account_locked", $keys)){
                $customer["account_locked"]= 0;
            }
            if(!in_array("account_privacy", $keys)){
                $customer["account_privacy"] = 0;
            }
            if(!in_array("billing_address", $keys) && ! in_array("shipping_address", $keys)){
                $customer["customer_addresses"] = json_decode('{"sameAddress": true, "billingAddress": {"city": "", "postcode": "", "fullAddress": ""}, "shippingAddress": {"city": "", "postcode": "", "fullAddress": ""}}');
            }else{
                if(!isset($customer["billing_address"]) || $customer["billing_address"] === ""){$customer["billing_address"] = "";}
                if(!isset($customer["shipping_address"]) || $customer["shipping_address"] === ""){$customer["shipping_address"] = "";}
                $customer["customer_addresses"] = json_decode('{"sameAddress": true, "billingAddress": {"city": "", "postcode": "", "fullAddress": "'.$customer["billing_address"].'"}, "shippingAddress": {"city": "", "postcode": "", "fullAddress": "'.$customer["shipping_address"].'"}}');
            }
            if(!in_array("account_master_user", $keys)){
                $customer["account_master_user"] = $customer["account_name"];
            }

            $customer["account_attachments"] = "[]";
            $customer["business_employees"] = "[]";
            $customer["customer_notes"] = "[]";
            $customer["customer_products"] = "[]";
            $customer["account_manager"] = "[]";
            $customer["billing_details"] = "[]";

            if(count( $customer["additional_information"]) > 0){
                $customer["customer_attributes"] = json_encode($customer["additional_information"]);
            }else{
                $customer["customer_attributes"] = "[]";
            }

            Customer::createNewCustomer($customer);

        }

    }
}

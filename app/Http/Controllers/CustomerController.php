<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Customer as Customer;
use App\Models\FileStorage as FileStorage;

class CustomerController extends Controller
{
    final public function updateExistingCompanyCustomer(Request $request){
        //!!! NEED TO SET THIS TO BE AUTHORITY SETTING FOR MANAGING/EDIT COMPANY CLIENTS
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED
        $customer = json_decode($request->customer, true);

        $validator = Validator::make($customer, [
            'customer_id' => ["required", "integer"],
            'account_type' => ["required", Rule::in(["Individual", "Business"])],
            'account_name' => ["required", "string", "max:255"],
            'account_email' => ["sometimes", "email" , "max:255"],
            'account_active' => ["required", "bool"],
            'account_locked' => ["required", "bool"],
            'account_privacy' => ["required", "bool"],
            'customer_addresses' => ["required"],
        ]);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors());
            return response($errors, 422)
                ->header('Content-Type', 'text/json');
        }

        $result = Customer::updateExistingCompanyCustomer($customer);

        $response = Customer::fetchSpecificCustomer($customer["id"]);

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function deleteCompanyCustomer(Request $request){
        //!!! NEED TO SET THIS TO BE AUTHORITY SETTING FOR MANAGING/EDIT COMPANY CLIENTS
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED

        $customer_id = $request->customer_id;

        $response = Customer::deleteCompanyCustomer($customer_id);

        return response($response, 200)
            ->header('Content-Type', 'text/plain');
    }

    final public function createNewCustomer(Request $request){
        //!!! NEED TO SET THIS TO BE AUTHORITY SETTING FOR CUSTOMER FILE UPLOADS
        if(session('job_level') < 1){return false;}//MASTER ADMIN AUTH FAILED

        $new_customer = json_decode( $request->customer , true);

        $validator = Validator::make($new_customer, [
            'account_type' => ["required", Rule::in(["Individual", "Business"])],
            'account_name' => ["required", "string", "max:255"],
            'account_email' => ["sometimes", "email" , "max:255"],
            'account_active' => ["required", "bool"],
            'account_locked' => ["required", "bool"],
            'account_privacy' => ["required", "bool"],
            'customer_addresses' => ["required"],
        ]);

        if ($validator->fails()) {
            $errors = json_encode($validator->errors());
            return response($errors, 422)
                ->header('Content-Type', 'text/json');
        }

        $customer_id = Customer::createNewCustomer($new_customer);

//        if(count($attachments) > 0){
////                FileStorage::convertTempCustomerFilesToPermanent( $attachments , $customer_id );
////       }

        if( $customer_id ){

            $response = Customer::fetchSpecificCustomer($customer_id);

            return response($response, 200)
                ->header('Content-Type', 'application/json');

        }

    }

    final public function fetchAllCustomersPaginated(Customer $customer){

        $customers = Customer::simplePaginate(50);

        $response = json_encode($customers);
        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }

    final public function fetchAllCustomers(){

        $response = Customer::fetchAllCustomers();

        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }

    final public function fetchCustomerSelectOptions($search,$page){
        $response = Customer::fetchCustomerSelectOptions($search, $page);
        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }

}

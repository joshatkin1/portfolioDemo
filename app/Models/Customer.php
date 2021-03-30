<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{

    protected $table;
    protected $primaryKey = 'customer_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_type',
        'account_number' ,
        'account_name' ,
        'account_email' ,
        'account_master_user',
        'customer_addresses',
        'customer_attributes',
        'customer_projects',
        'customer_sales',
        'customer_actions',
        'business_employees',
        'customer_subscriptions',
        'customer_notes',
        'customer_communications',
        'account_manager',
        'account_access_history',
        'customer_rapport',
        'customer_responses',
        'customer_requests',
        'account_privacy',
        'account_locked',
        'account_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
    ];

    public function __construct(){
        $this->table = session('database_prefix') . 'customers';
    }

    public function transaction()
    {
        return $this->hasMany('App\Transaction', 'customer_link');
    }

    final public static function fetchCustomerListByRecentPaginated($skipped_customer){
        $skipped_customer = intval($skipped_customer);
        if($skipped_customer === 0){
            $customers = DB::table($this->table)
                ->limit(50)
                ->latest()
                ->get();
        }else{
            $customers = DB::table($table)
                ->offset($skipped_customer)
                ->limit(50)
                ->latest()
                ->get();
        }

        $result = json_decode($customers);
        return $result;
    }

    final public static function fetchCustomerListAlphabeticallyPaginated($skipped_customer){
        $table = session('database_prefix') . 'customers';
        $skipped_customer = intval($skipped_customer);
        if($skipped_customer === 0){
            $result = DB::table($table)
                ->limit(50)
                ->orderByDesc('account_name')
                ->get();
        }else{
            $result = DB::table($table)
                ->offset($skipped_customer)
                ->limit(50)
                ->orderByDesc('account_name')
                ->get();
        }

        return $result;
    }

    final public static function updateExistingCompanyCustomer($customer){
        $table = session('database_prefix') . 'customers';
        $id = $customer["customer_id"];
        $attachments = $customer["account_attachments"];
        $upload_attachments = json_encode($attachments);
        $master_admin = ($customer["account_master_user"] !== "") ? $customer["account_master_user"] :  $customer["account_name"];
        $customer_addresses = json_encode($customer["customer_addresses"] );
        $customer_attributes = json_encode($customer["customer_attributes"]);
        $employees = json_encode($customer["business_employees"]);
        $customer_notes = json_encode($customer["customer_notes"]);
        $customer_products = json_encode($customer["customer_products"]);
        $account_manager = intval($customer["account_manager"]);
        $billing_details= json_encode($customer["billing_details"]);

        $result = DB::table($table)
            ->where('id', '=' , $id)
            ->update(
                [
                    'account_type' => $customer["account_type"],
                    'account_number' => $customer["account_number"],
                    'account_name' => $customer["account_name"],
                    'account_email' => $customer["account_email"],
                    'account_telephone' => $customer["account_telephone"],
                    'account_master_user' => $master_admin,
                    'customer_addresses' =>  $customer_addresses,
                    'customer_attributes' => $customer_attributes,
                    'business_employees' => $employees,
                    'account_attachments' => $upload_attachments,
                    'customer_products' => $customer_products,
                    'billing_details' => $billing_details,
                    'customer_notes' => $customer_notes,
                    'account_manager' => $account_manager,
                    'account_privacy' => $customer["account_privacy"],
                    'account_locked' => $customer["account_locked"],
                    'account_active' => $customer["account_active"],
                ]
            );

        return $result;
    }

    final public static function createNewCustomer($new_customer){
        $attachments = $new_customer["account_attachments"];
        $upload_attachments = json_encode($attachments);
        $master_admin = ($new_customer["account_master_user"] !== "") ? $new_customer["account_master_user"] :  $new_customer["account_name"];
        $customer_addresses = json_encode($new_customer["customer_addresses"] );
        $customer_attributes = json_encode($new_customer["customer_attributes"]);
        $employees = json_encode($new_customer["business_employees"]);
        $customer_notes = json_encode($new_customer["customer_notes"]);
        $customer_products = json_encode($new_customer["customer_products"]);
        $account_manager = intval($new_customer["account_manager"]);
        $billing_details= json_encode($new_customer["billing_details"]);

        $table = session('database_prefix') . 'customers';

        $customer_id = DB::table($table)->insertGetId(
            [
                'account_type' => $new_customer["account_type"],
                'account_number' => $new_customer["account_number"],
                'account_name' => $new_customer["account_name"],
                'account_email' => $new_customer["account_email"],
                'account_telephone' => $new_customer["account_telephone"],
                'account_master_user' => $master_admin,
                'customer_addresses' =>  $customer_addresses,
                'customer_attributes' => $customer_attributes,
                'business_employees' => $employees,
                'account_attachments' => $upload_attachments,
                'customer_products' => $customer_products,
                'billing_details' => $billing_details,
                'customer_notes' => $customer_notes,
                'account_manager' => $account_manager,
                'account_privacy' => $new_customer["account_privacy"],
                'account_locked' => $new_customer["account_locked"],
                'account_active' => $new_customer["account_active"],
            ]
        );

        return $customer_id;
    }

    final protected static function fetchAllCustomers(){
        $table = session('database_prefix') . 'customers';
        $result = DB::table($table)->get();
        $result = json_encode($result);
        return $result;
    }

    final protected static function fetchSpecificCustomer($customer_id){
        $table = session('database_prefix') . 'customers';

        $result = DB::table($table)
            ->where('customer_id' , '=' , $customer_id)
            ->first();

        return json_encode($result);
    }

    final protected static function deleteCompanyCustomer($customer_id){
        $table = session('database_prefix') . 'customers';
        DB::table($table)
            ->where('customer_id', '=', $customer_id)
            ->delete();
    }

    final protected static function fetchCustomerSelectOptions($search, $page){
        $table = session('database_prefix') . 'customers';
        $offset = ($page * 7) - 7;
        $string = '%' . $search . '%';

        $customers = DB::table($table)
            ->where("account_name", "like", $string)
            ->offset($offset)
            ->limit(7)
            ->get();

        $result = json_encode($customers);
        return $result;
    }
}

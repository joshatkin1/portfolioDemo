<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaction extends Model
{
    protected $table;
    protected $primaryKey = 'transaction_id';
    protected $dateFormat = 'Y-m-d';
    public $payable_transactions = ["Contract", "Invoice", "Sales Order"];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_no',
        'transaction_ref',
        'transaction_type',
        'transaction_owner',
        'transaction_owner_owner_list',
        'transaction_email',
        'customer_link',
        'project_id',
        'transaction_link',
        'subtotal',
        'tax',
        'total',
        'received',
        'due',
        'received_payment_amount',
        'cc_emails',
        'transaction_lines',
        'vatAccountingType',
        'transaction_created_date',
        'transaction_due_date',
        'transaction_paid_date',
        'contract_terms',
        'transaction_attachment_key',
        'transaction_open',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'subtotal' => 'float',
        'tax' => 'float',
        'total' => 'float',
        'received' => 'float',
        'due' => 'float',
        'received_payment_amount' => 'float',
        'transaction_owner_owner_list' => 'array',
    ];

    public function __construct(){
        $this->table = session('database_prefix') . 'transactions';
    }

    final public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_link', 'customer_id', 'customer');
    }

    final public function updateSpecificTransaction($id , $updates = []){
        try{
            DB::table($this->table)
                ->where('transaction_id' , '=' , $id)
                ->update($updates);
        }catch(\Exception $exception){
            return false;
        }

        return true;
    }

    final protected static function fetchSpecificTransactionByID($id){
        $table = session('database_prefix') . 'transactions';
        $transaction = DB::table($table)
            ->where('transaction_id' , '=' , $id)
            ->first();

        return $transaction;
    }

    final public function fetchOpenTransactionsPaginated(){
        $transaction_cus_link = $this->table . '.customer_link';
        $customer_table = session('database_prefix') . 'customers';
        $customer_link = $customer_table . '.customer_id';

        $transaction_proj_link = $this->table . '.project_id';
        $project_table = session('database_prefix') . 'projects';
        $project_link = $project_table . '.project_id';

        $transactions = DB::table($this->table)
            ->leftJoin($customer_table, $transaction_cus_link, '=', $customer_link)
            ->leftJoin($project_table, $transaction_proj_link, '=', $project_link)
            ->select('transaction_id','customer_link','account_name','project_name','transaction_no','transaction_type', 'transaction_created_date', 'transaction_due_date', 'total', 'due', 'received')
            ->whereIn("transaction_type" , ["Invoice", "Sales Order", "Contract"])
            ->where("transaction_open", "=" , 1)
            ->paginate(50);

        return $transactions;
    }

    final protected static function fetchTransactionTypeReferenceNumber($transaction_type){
        $table = session('database_prefix') . 'transactions';

        $transaction_type = ucwords(strtolower($transaction_type));

        $transaction_number = DB::table($table)
            ->select('transaction_no')
            ->where("transaction_type", "=" , $transaction_type)
            ->take(1)
            ->latest()
            ->get();

        if($transaction_number->count() < 1){
            $transaction_number =  "s#0";
        }else{
            $transaction_number = $transaction_number[0]->transaction_no;
        }

        $transaction_number = explode("#", $transaction_number);

        $transaction_number = intval($transaction_number[1]);

        $transaction_number = $transaction_number + 1;

        return $transaction_number;
    }

    final public function receivePaymentOnTransaction(){
        $transaction_id = $this->transaction_id;
        $transaction_link = $this->transaction_link;
        $paid_amount = $this->received_payment_amount;
        $paid_date = $this->transaction_paid_date;
        $created_date = date("Y-m-d");

        $transaction = \App\Transaction::fetchSpecificTransactionByID($transaction_link);

        $transaction_total = $transaction->total;
        $transaction_received = $transaction->received;
        $transaction_received = $transaction_received + $paid_amount;
        $transaction_due = $transaction_total - $transaction_received;
        if($transaction_due < 0){$transaction_due = 0;}

        $this->updateSpecificTransaction($transaction_link, [
            "received" => $transaction_received,
            'due' => $transaction_due
        ]);

        return true;
    }

    final public function createReceivedPaymentTransactionWithTransaction(){

        $num = Transaction::fetchTransactionTypeReferenceNumber("Received Payment");
        $num = "Received%20Payment_#" . $num;

        $owner_list = json_encode([[
            "employee" => session('id'),
            "start_ownership" => date("Y-m-d h:i:s a")
        ]]);

        $cc_email = "{\"cc_emails\": \"\", \"bcc_emails\": \"\"}";

        DB::table($this->table)->insert(
            [
                'transaction_no' => $num,
                'transaction_ref' => "",
                'transaction_type' => "Received Payment",
                'transaction_owner' => session('id'),
                'transaction_owner_owner_list' => $owner_list,
                'transaction_email' => "",
                'customer_link' => $this->customer_link,
                'project_id' => $this->project_id,
                'transaction_link' => $this->transaction_id,
                'subtotal' => "0.00",
                'tax' =>  "0.00",
                'total' =>  "0.00",
                'received' =>  "0.00",
                'due' =>  "0.00",
                'received_payment_amount' => $this->received,
                'cc_emails' => $cc_email,
                'vatAccountingType' => $this->vatAccountingType,
                'transaction_created_date' => date("Y-m-d"),
                'transaction_due_date' => NULL,
                'transaction_paid_date' => date("Y-m-d"),
                'transaction_open' => 0,
            ]
        );

        return true;
    }
}

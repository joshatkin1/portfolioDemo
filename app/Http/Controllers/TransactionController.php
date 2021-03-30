<?php

namespace App\Http\Controllers;

use App\Models\FileStorage;
use App\Models\Transaction as Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    final public function createNewTransaction(Request $request, Transaction $transaction){
        //!!! NEED TO SET THIS TO BE AUTHORITY SETTING FOR CREATING TRANSACTIONS
        if(session('job_level') < 3){return false;}//MASTER ADMIN AUTH FAILED

        $transaction_details = json_decode($request->transaction, true);
        $transaction->transaction_type = ucwords(strtolower($transaction_details["transaction_type"]));
        $file = $request->attachment;

        $validator = Validator::make($transaction_details, [
            'transaction_type' => ["required", Rule::in(["Sales Order", "Sales Receipt", "Received Payment", "Contract", "Invoice", "Refund", "Expense"])],
            'vatAccountingType' => ["required", Rule::in(["No VAT", "Exclusive", "Inclusive"])],
            'transaction_email' => ["sometimes", "email" , "max:255"],
        ]);

        if ($validator->fails()){
            $errors = json_encode($validator->errors());
            return response($errors, 422)
                ->header('Content-Type', 'text/json');
        }

        if($transaction->transaction_type === "Received Payment"){
            if(!isset($transaction_details["transaction_object"]["transaction_id"]) || $transaction_details["transaction_object"]["transaction_id"] === "" || $transaction_details["transaction_object"]["transaction_id"] === -1 ){
                return response("Received Payment Transactions require a linked transaction", 422)
                    ->header('Content-Type', 'text/plain');
            }
        }

        $file_key = "";
        if($file && $file !== ""){
            $customer_id =  ($transaction_details["customer_object"]["id"] !== "") ? $transaction_details["customer_object"]["id"] : -1;
            $project_id =  ($transaction_details["project_object"]["id"] !== "") ? $transaction_details["project_object"]["id"] : -1;
            $file_storage = new FileStorage();
            $file_key = $file_storage->storeTransactionFileAttachment($file, $customer_id, $project_id);
        }

        $transaction->transaction_attachment_key = $file_key;

        $transaction->transaction_no = (isset($transaction_details["transaction_no"])) ? $transaction_details["transaction_no"] : "" ;
        $transaction->transaction_owner = session('id');
        $transaction->transaction_owner_owner_list = json_encode([[
            "employee" => session('id'),
            "start_ownership" => date("Y-m-d h:i:s a")
        ]]);

        $transaction->customer_link = ($transaction_details["customer_object"]["customer_id"] !== "") ? $transaction_details["customer_object"]["customer_id"] : -1;
        $transaction->project_id = ($transaction_details["project_object"]["project_id"] !== "") ? $transaction_details["project_object"]["project_id"] : -1;
        $transaction->transaction_email = $transaction_details["transaction_email"];

        $transaction_subtotal = $transaction_details["transaction_totals"]["subtotal"];
        $transaction->subtotal = (isset($transaction_subtotal) && $transaction_subtotal !== "") ? floatval($transaction_subtotal) : 0;
        $transaction_tax = $transaction_details["transaction_totals"]["tax"];
        $transaction->tax = (isset($transaction_tax) && $transaction_tax !== "") ? floatval($transaction_tax) : 0;
        $transaction->total = (isset($transaction_details["transaction_totals"]["total"])) ? $transaction_details["transaction_totals"]["total"] : 0;
        $received_amount = $transaction_details["transaction_totals"]["received"];
        $transaction->received = (isset($received_amount) && $received_amount !== "") ? floatval($received_amount) : 0;
        $transaction->due = $transaction->total - $transaction->received;

        $transaction->vatAccountingType = $transaction_details["vatAccountingType"];

        $transaction->received_payment_amount = NULL;
        if($transaction->transaction_type === "Received Payment"){
            $transaction->transaction_link = ($transaction_details["transaction_object"]["transaction_id"] !== "") ? $transaction_details["transaction_object"]["transaction_id"] : -1;
            $transaction->received_payment_amount = $transaction_details["received_payment_amount"];
        }

        $transaction->transaction_open = ($transaction->due > 0) ? 1 : 0;

        $transaction->cc_emails = json_encode([
            "cc_emails" => $transaction_details["ccEmailValue"],
            "bcc_emails" => $transaction_details["bccEmailValue"],
        ]);

        $transaction->transaction_lines = json_encode($transaction_details["transaction_lines"]);
        $transaction->contract_terms = $transaction_details["contract_terms"];

        $transaction->transaction_created_date = (isset($transaction_details["dates"]["created"]) && $transaction_details["dates"]["created"] !== "") ? $transaction_details["dates"]["created"] : date("Y-m-d");
        $transaction->transaction_due_date = (isset($transaction_details["dates"]["due"])) ? $transaction_details["dates"]["due"] : date("Y-m-d");
        $transaction->transaction_paid_date = (isset($transaction_details["dates"]["paid"])) ? $transaction_details["dates"]["paid"] :  date("Y-m-d");

        if(in_array($transaction->transaction_type, $transaction->payable_transactions)){
            if($transaction->due < 0.01){
                $transaction->transaction_paid_date = date("Y-m-d");
            }else{
                $transaction->transaction_paid_date = "";
            }
        }

        $transaction->save();

        if(in_array($transaction->transaction_type, $transaction->payable_transactions)) {
            if ($transaction->received > 0) {
                $transaction->createReceivedPaymentTransactionWithTransaction();
            }
        }

        if($transaction->transaction_type === "Received Payment"){
            $transaction->receivePaymentOnTransaction();
        }

        if(isset($transaction->customer_link) && $transaction->customer_link !== -1){
            $transaction->load('customer');
        }else{
            $transaction->customer = null;
        }

        $response = json_encode($transaction);
        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }

    final public function fetchAllTransactionsPaginated(){
        $transactions = Transaction::with('customer')
            ->select('transaction_id','customer_link','transaction_no','transaction_type', 'transaction_created_date', 'transaction_due_date', 'total', 'due', 'received', 'received_payment_amount')
            ->latest()
            ->simplePaginate(50);

        $response = json_encode($transactions);
        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }

    final public function fetchOpenTransactionsPaginated(){

        $transactions = Transaction::with('customer')
            ->select('transaction_id','customer_link','transaction_no','transaction_type', 'transaction_created_date', 'transaction_due_date', 'total', 'due', 'received', 'received_payment_amount')
            ->whereIn("transaction_type" , ["Invoice", "Sales Order", "Contract"])
            ->where("transaction_open", "=" , 1)
            ->latest()
            ->simplePaginate(50);

        $response = json_encode($transactions);
        return response($response, 200)
            ->header('Content-Type', 'application/json');
    }

    final public function fetchTransactionTypeReferenceNumber(Request $request){
        $transaction_type = $request->transaction_type;

        $response = Transaction::fetchTransactionTypeReferenceNumber($transaction_type);

        return response($response, 200)
            ->header('Content-Type', 'plain/text');
    }
}

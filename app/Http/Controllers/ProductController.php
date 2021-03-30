<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    final public function searchProductPackages($search, $page){
        $response = Product::searchProductPackages($search, $page);
        return response($response , 200)
            ->header('Content-Type', 'text/json');
    }

    final public function fetchAllProductPackages(){

        $response = Product::fetchAllProductPackages();
        return response(json_encode($response), 200)
            ->header('Content-Type', 'text/json');
    }

    final public function createProductPackage(Request $request){
        if(session('job_level') < 3){return false;}//ADMIN AUTH FAILED
        $product = json_decode($request->product, true);

        $validator = Validator::make($product, [
            'product_type' => ["required", Rule::in(['Product' ,'Subscription', 'Service' , 'Consultation' , 'Sales' , 'Miscellaneous'])],
            'product_name' => ["required" , "max:255"],
        ]);

        if ($validator->fails()){
            $errors = json_encode($validator->errors());
            return response($errors, 422)
                ->header('Content-Type', 'text/json');
        }

        $allProducts = Product::fetchAllProductPackages();

        if(count($allProducts) > 0){
            foreach ($allProducts as $prod){
                if($prod->product_name === $product["product_name"]){
                    return response('duplicate product', 409)
                        ->header('Content-Type', 'text/plain');
                }
            }
        }

        $product_id = Product::createProductPackage($product);
        $product["id"] = $product_id;

        $response = json_encode($product);
        return response($response , 200)
            ->header('Content-Type', 'text/json');
    }
}

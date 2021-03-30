<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    final protected static function searchProductPackages($search , $page){
        $table = session('database_prefix') . 'products';
        $search_string = '%' . $search . '%';
        $offset = ($page * 7) - 7;
        $result = DB::table($table)
            ->where('product_name', 'like', $search_string)
            ->orWhere('product_number', 'like', $search_string)
            ->latest()
            ->offset($offset)
            ->limit(7)
            ->get();

        return $result;
    }

    final protected static function fetchAllProductPackages(){
        $table = session('database_prefix') . 'products';
        $result = DB::table($table)
            ->where('product_active', '=', 1)
            ->get();

        return $result;
    }

    final protected static function createProductPackage($product){
        $company_link = session('company_link');
        $database_prefix = 'companyRegister' . $company_link . '_';
        $table = $database_prefix . 'products';

        $default_vat = strval($product["default_vat"]);

        if(!isset($product["product_amount"]) || $product["product_amount"] === "" ){
            $product["product_amount"] = 0;
        }

        $result = DB::table($table)->insertGetId(
            ['product_creator' => session('id'),
                'product_type' => $product["product_type"],
                'product_name' => $product["product_name"],
                'product_number' => $product["product_number"],
                'product_description' => $product["product_description"],
                'product_cost' => $product["product_cost"],
                'stock_amount' => $product["stock_amount"],
                'default_vat' => $default_vat,
                'product_active' => 1
            ]
        );

        return $result;
    }
}

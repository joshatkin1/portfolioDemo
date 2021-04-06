<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');

        $randNum = random_int(1,10);
        if($randNum === 6){
            $this->middleware('userAgentCheck');
        }
    }
}

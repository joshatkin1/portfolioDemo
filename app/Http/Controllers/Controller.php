<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function landingPage(Request $request)
    {
        return view('home');
    }

}

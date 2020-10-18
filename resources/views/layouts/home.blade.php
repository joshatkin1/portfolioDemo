<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <!-- META DATA-->
    <meta charset="UTF-8" />
    <meta lang="en" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name='description' content='The all in one work manager platform' />
    <meta name='keywords' content='workflow,crm,time-managment,interal,messenger,task,jobs,career,work,works,staff,trade,occupation,wage,salary,freelance,industry,business,professional,manager,software' />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Cache-Control" content="no-store" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'workcloud') }}</title>

    <!-- JS Scripts -->
<!-- <script src="{{ asset('js/app.js') }}" defer></script>-->
    <script src="{{ asset('js/main.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" />

</head>

<body>
<header class="homeheader">
    <div class="innerheader">
        <nav class="navbar">
            <a href="{{ url('/') }}">
                <h1 class="headertxt" style="font-size:40px;font-weight: normal;color: #7B10DA;">∞</h1>
            </a>
            <div id="pagenavs">
                <a class="pagenavbtns">Pricing</a>
            </div>
        </nav>

        @guest
            <nav class="nw-cus-arvl-nav">
                <a class="hm-sgn-btns">Sign In</a>
            </nav>
        @else

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endguest
    </div>

</header>
<div class="pagecontentwrap">
    <div class="main-content-wrap">
        @yield('content')
    </div>
</div>
</body>
<style type="text/css">
    .hm-sgn-btns{
        border:solid 1px  #D0D3D3;
        background-color: transparent;
        font-family: "Open Sans", sans-serif;
        font-weight: lighter;
        padding:6px 10px;
        margin-left: 10px;
        border-radius:7px;
        color: gray;
        font-size:15px;
        letter-spacing:1px;
        cursor:pointer;
    }
    .hm-sgn-btns:hover{
        transition: all 1s;
        -webkit-transition: all 1s;
        -moz-transition: all 1s;
        -o-transition: all 1s;
        color:#7B10DA;
        border-color:#7B10DA;
    }
    .pagenavbtns{
        color:rgb(150,150,150);
        font-family: "Noto Sans","Product Sans", sans-serif;
        font-weight: normal;
        font-size:15px;
    }
    .pagenavbtns:hover{
        color:#7B10DA;
        cursor:pointer;
    }
    .nw-cus-arvl-nav{
        display:flex;
        flex-direction:row;
        justify-content: flex-end;
        align-items: start;
    }
</style>
</html>

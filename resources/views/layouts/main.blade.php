<!doctype html>
<html lang="en" dir="ltr">
<head>
    <!-- META DATA-->
    <meta charset="utf-8" />
    <meta lang="en" />
    <meta name="language" content="en"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name='description' content='The all in one work manager platform' />
    <meta name='keywords' content='workflow,crm,time-managment,interal,messenger,task,jobs,career,work,works,staff,trade,occupation,wage,salary,freelance,industry,business,professional,manager,software' />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta http-equiv="Cache-Control" content="max-age=7200, public" />
    <meta name="Cache-Control" content="max-age=7200, public"/>
    <meta name="X-Content-Type-Options" content="nosniff"/>
    <meta name="X-XSS-Protection" content="1; mode=block">

    <link rel="canonical" href="https://…"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'portfolioDemo') }}</title>

    <!-- JS Scripts -->
<!-- <script src="{{ asset('js/app.js') }}" defer></script>-->
{{--    <script src="{{ asset('js/main.js') }}" defer></script>--}}

    <!-- Styles -->
    <link href="{{ asset('css/global.css') }}" rel="stylesheet" />
</head>
<body>
<div class="pagecontentwrap">
    <div class="main-content-wrap">
        @yield('content')
    </div>
</div>
</body>
</html>


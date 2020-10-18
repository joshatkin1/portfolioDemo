<!DOCTYPE html>
<html lang="en”>
<head>

    <title>{{config('app.name')}}</title>

    <!-- META DATA-->
    <meta charset='UTF-8' />
    <meta lang='en' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0'"/>
    <meta name="description" content="The all in one s moftware managment platform" />
    <meta name="keywords" content="software" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv='Cache-Control' content='no-store' />
    <meta content='' />
    <meta charset='utf-8' />
    <meta dir='ltr'/>

    <!--STYLESHEETS-->
    <link href="{{ asset('css/global.css') }}" rel="stylesheet">

</head>
<body>
<div class="content-wrap">
    @yield('content')
</div>
</body>
</html>

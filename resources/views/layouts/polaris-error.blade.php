<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Emperor - @yield('title')</title>

    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/2.7.2/polaris.min.css" />
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
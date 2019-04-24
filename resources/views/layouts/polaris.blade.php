<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($shop))<meta name="shop" content="{{ $shop }}">@endif
    @if(isset($token))<meta name="api-token" content="{{ $token }}">@endif

    <title>Emperor - @yield('title')</title>

    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/2.7.2/polaris.min.css" />
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <script>(function(d,a){function c(){var b=d.createElement("script");b.async=!0;b.type="text/javascript";b.src=a._settings.messengerUrl;b.crossOrigin="anonymous";var c=d.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}window.kayako=a;a.readyQueue=[];a.newEmbedCode=!0;a.ready=function(b){a.readyQueue.push(b)};a._settings={apiUrl:"https://kyte.kayako.com/api/v1",messengerUrl:"https://kyte.kayakocdn.com/messenger",realtimeUrl:"wss://kre.kayako.net/socket"};window.attachEvent?window.attachEvent("onload",c):window.addEventListener("load",c,!1)})(document,window.kayako||{});</script></body>
</html>
<html lang="{{ app()->getLocale() }}">
<head>
    <script type="text/javascript">
        (function() {
            window.__insp = window.__insp || [];
            __insp.push(['wid', 1384222195]);
            var ldinsp = function(){
                if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js?wid=1384222195&r=' + Math.floor(new Date().getTime()/3600000); var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };
            setTimeout(ldinsp, 0);
        })();
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if(isset($shop))<meta name="shop" content="{{ $shop }}">@endif
    @if(isset($token))<meta name="api-token" content="{{ $token }}">@endif

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/3.15.0/polaris.min.css" />
    <script src="https://wchat.freshchat.com/js/widget.js"></script>

    <style>body { background-color: #f4f6f8; }</style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    <script>
        window.fcWidget.init({
            token: "7f4eb6b4-b637-4fa9-b7f1-135d4707065d",
            host: "https://wchat.freshchat.com"
        });
    </script>
</body>
</html>
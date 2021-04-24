<html lang="{{ app()->getLocale() }}">
<head>
    {{--<script type="text/javascript">--}}
        {{--(function() {--}}
            {{--window.__insp = window.__insp || [];--}}
            {{--__insp.push(['wid', 1384222195]);--}}
            {{--var ldinsp = function(){--}}
                {{--if(typeof window.__inspld != "undefined") return; window.__inspld = 1; var insp = document.createElement('script'); insp.type = 'text/javascript'; insp.async = true; insp.id = "inspsync"; insp.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://cdn.inspectlet.com/inspectlet.js?wid=1384222195&r=' + Math.floor(new Date().getTime()/3600000); var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(insp, x); };--}}
            {{--setTimeout(ldinsp, 0);--}}
        {{--})();--}}
    {{--</script>--}}

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://sdks.shopifycdn.com/polaris/3.15.0/polaris.min.css" />

    <style>body { background-color: #f4f6f8; }</style>
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
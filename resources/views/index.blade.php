@extends('layouts.polaris')

@section('title', config('app.title'))

@section('content')

    @if(Session::has('message'))
        <div class="Polaris-Banner Polaris-Banner--statusSuccess Polaris-Banner--withinPage" tabindex="0" role="status" aria-live="polite" aria-labelledby="Banner3Heading" aria-describedby="Banner3Content">
            <div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorGreenDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><g fill-rule="evenodd"><circle fill="currentColor" cx="10" cy="10" r="9"></circle><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m2.293-10.707L9 10.586 7.707 9.293a1 1 0 1 0-1.414 1.414l2 2a.997.997 0 0 0 1.414 0l4-4a1 1 0 1 0-1.414-1.414"></path></g></svg></span></div>
            <div>
                <div class="Polaris-Banner__Heading" id="Banner3Heading">
                    <p class="Polaris-Heading">{{ Session::get('message') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div id="app"></div>

    <script type="text/javascript" src="js/app.js"></script>

    <script>
        if(AppLoader !== undefined) {
            AppLoader.bind({
                'shop': '{{ $shopName }}',
                'token': '{{ $token }}',
                'signature': '{{ csrf_token() }}',
                'apiBase': '{{ config('services.simple.api_base') }}'
            }, 'app');
        }
    </script>
@endsection
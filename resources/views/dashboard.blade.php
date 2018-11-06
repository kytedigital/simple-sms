@extends('layouts.polaris')

@section('title', 'Shopify SMS')

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

    <h1>Fancy Single Page App Here</h1>

    <div id="app">
        <!-- For security, please remove these from the page once loaded into the app -->
        <div id="remove_me" style="display: none">
            <csrf-token>{{ csrf_token() }}</csrf-token>
            <api-token>{{ $token }}</api-token>
        </div>
        <!-- -->
    </div>

    <div class="Polaris-FooterHelp">
        <div class="Polaris-FooterHelp__Content">
            <div class="Polaris-FooterHelp__Icon">
                <span class="Polaris-Icon Polaris-Icon--colorTeal Polaris-Icon--isColored Polaris-Icon--hasBackdrop">
                    <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
                        <circle cx="10" cy="10" r="9" fill="currentColor"></circle>
                        <path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8m0-4a1 1 0 1 0 0 2 1 1 0 1 0 0-2m0-10C8.346 4 7 5.346 7 7a1 1 0 1 0 2 0 1.001 1.001 0 1 1 1.591.808C9.58 8.548 9 9.616 9 10.737V11a1 1 0 1 0 2 0v-.263c0-.653.484-1.105.773-1.317A3.013 3.013 0 0 0 13 7c0-1.654-1.346-3-3-3"></path>
                    </svg>
                </span>
            </div>
            <div class="Polaris-FooterHelp__Text">
                You're currently on our {{ $subscription->name }} plan.
                <a class="Polaris-Link"
                   href="{{ route('subscription') }}"
                   data-polaris-unstyled="true">
                    Click here to change.
                </a>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/app.js"></script>
@endsection

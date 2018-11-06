@extends('layouts.polaris')

@section('title', 'Shopify SMS')

@section('content')
    <h1>Shopify SMS</h1>
    <div id="example">

    </div>

    <script type="text/javascript" src="js/app.js"></script>

    <a href="{{route('subscription.make', ['code' => 'beacon-sm'])}}">
        Trail
    </a>

    <a href="{{route('subscription.make', ['code' => 'beacon-md'])}}">
        Create Small Subscription
    </a>

    <a href="{{route('subscription.make', ['code' => 'beacon-lg'])}}">
        Create Small Subscription
    </a>

    <a href="{{route('subscription.make', ['code' => 'beacon-xl'])}}">
        Create Small Subscription
    </a>


    <token>{{ csrf_token() }}</token>
    <url>{{ config('app.url') }}</url>

@endsection
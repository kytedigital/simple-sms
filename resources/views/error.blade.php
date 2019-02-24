@extends('layouts.polaris-error')

@section('title', 'App Error')

@section('content')
    <div class="Polaris-Page">
        <div class="Polaris-Page__Header">
            <div class="Polaris-Page__Title">
                <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">An Error Has Occurred</h1><br/>
            </div>
        </div>
        <br>
        <div id="myFieldIDError" class="Polaris-InlineError">
            <div class="Polaris-InlineError__Icon">
                <span class="Polaris-Icon">
                    <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
                        <path d="M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16zm-1-8h2V6H9v4zm0 4h2v-2H9v2z" fill-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
            {{ $message }}
        </div>
    </div>
@endsection
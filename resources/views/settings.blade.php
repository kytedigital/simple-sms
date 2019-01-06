@extends('layouts.polaris')

@section('title', 'Discounts Report')

@section('content')
    <div class="Polaris-Page">
        <div class="Polaris-Page__Header">
            <div class="Polaris-Page__Title">
                <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Shopify SMS Settings</h1><br/>
            </div>
            <div class="Polaris-Page__Actions"></div>
        </div>
        <br>
        <fieldset class="Polaris-ChoiceList" id="ChoiceList1" aria-invalid="false" aria-describedby="ChoiceList1Error">
            <legend class="Polaris-ChoiceList__Title">SMS Service Provider:</legend>
            <br>
            <ul class="Polaris-ChoiceList__Choices">
                <li>
                    <label class="Polaris-Choice" for="RadioButton1">
                        <span class="Polaris-Choice__Control">
                            <span class="Polaris-RadioButton">
                                <input id="RadioButton1"
                                       name="ChoiceList1"
                                       type="radio"
                                       class="Polaris-RadioButton__Input"
                                       value="hidden"
                                       checked=""
                                       disabled
                                >
                                <span class="Polaris-RadioButton__Backdrop">

                                </span>
                                <span class="Polaris-RadioButton__Icon">

                                </span>
                            </span>
                        </span>
                        <span class="Polaris-Choice__Label">Burst SMS (We temporarily only support Burst SMS)</span>
                    </label>
                </li>
            </ul>
        </fieldset>
        <br>
        <p>Burst SMS ApiService Credentials are available on your Burst SMS
            <a href="https://burst.transmitsms.com/profile">account profile page</a></p>
        <br>
        <div class="">
            <div class="Polaris-Labelled__LabelWrapper">
                <div class="Polaris-Label">
                    <label id="TextField5Label" for="TextField5" class="Polaris-Label__Text">Provider ApiService Key</label>
                </div>
            </div>
            <div class="Polaris-TextField">
                <input id="TextField5" class="Polaris-TextField__Input" aria-label="Store name" aria-labelledby="TextField5Label" aria-invalid="false" value="">
                <div class="Polaris-TextField__Backdrop"></div>
            </div>
        </div>
        <br>
        <div class="">
            <div class="Polaris-Labelled__LabelWrapper">
                <div class="Polaris-Label">
                    <label id="TextField5Label" for="TextField5" class="Polaris-Label__Text">Provider ApiService Secret</label>
                </div>
            </div>
            <div class="Polaris-TextField">
                <input id="TextField5" class="Polaris-TextField__Input" aria-label="Store name" aria-labelledby="TextField5Label" aria-invalid="false" value="">
                <div class="Polaris-TextField__Backdrop"></div>
            </div>
        </div>
        <br>
        <div class="">
            <div class="Polaris-Labelled__LabelWrapper">
                <div class="Polaris-Label">
                    <label id="TextField5Label" for="TextField5" class="Polaris-Label__Text">Your Virtual Number (Optional)</label>
                </div>
            </div>
            <div class="Polaris-TextField">
                <input id="TextField5" class="Polaris-TextField__Input" aria-label="Store name" aria-labelledby="TextField5Label" aria-invalid="false" value="">
                <div class="Polaris-TextField__Backdrop"></div>
            </div>
        </div>
        <br>
        <button type="button" class="Polaris-Button Polaris-Button--primary">
            <span class="Polaris-Button__Content">
                <span>Save SMS Settings</span>
            </span>
        </button>
    </div>
@endsection
@extends('layouts.polaris')

@section('title', 'Shopify SMS')

@section('content')
    <style>
        .panel {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px 25px;
            position: relative;
            width: 100%;
            z-index: 10;
        }

        .pricing-table {
            box-shadow: 0 10px 13px -6px rgba(0, 0, 0, 0.08), 0 20px 31px 3px rgba(0, 0, 0, 0.09), 0 8px 20px 7px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 900px) {
            .pricing-table {
                flex-direction: row;
            }
        }

        .pricing-table * {
            text-align: center;
        }

        .subscription-text {
            margin-top: 25px;
            color: rgb(0, 116, 163);
        }

        .pricing-plan {
            border-bottom: 1px solid #e1f1ff;
            padding: 25px;
        }

        .pricing-plan:last-child {
            border-bottom: none;
        }

        @media (min-width: 900px) {
            .pricing-plan {
                border-bottom: none;
                border-right: 1px solid #e1f1ff;
                flex-basis: 100%;
                padding: 25px 50px;
            }

            .pricing-plan:last-child {
                border-right: none;
            }
        }

        .pricing-img {
            margin-bottom: 25px;
            max-width: 100%;
        }

        .pricing-header {
            color: rgb(0, 116, 163);
            font-weight: 600;
            letter-spacing: 1px;
            font-size: 1.5em;
        }

        .pricing-features {
            color: rgb(0, 116, 163);;
            font-weight: 600;
            letter-spacing: 1px;
            margin: 50px 0 35px;
            list-style: none;
            padding: 0;
        }

        .pricing-features-item {
            border-top: 1px solid rgb(0, 116, 163);
            font-size: 12px;
            line-height: 1.5;
            padding: 15px 0;
        }

        .pricing-features-item:last-child {
            border-bottom: 1px solid rgb(0, 116, 163);
        }

        .pricing-price {
            color: rgb(0, 116, 163);
            display: block;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .pricing-button {
            border: 1px solid rgb(0, 116, 163);
            border-radius: 10px;
            color: rgb(0, 116, 163);
            display: inline-block;
            margin: 25px 0;
            padding: 15px 35px;
            text-decoration: none;
            transition: all 150ms ease-in-out;
        }

        .pricing-button:hover,
        .pricing-button:focus {
            background-color: #e1f1ff;
        }

        .pricing-button.is-featured {
            background-color: rgb(0, 116, 163);;
            color: #fff;
        }

        .pricing-button.is-featured:hover,
        .pricing-button.is-featured:active {
            background-color: #269aff;
        }
    </style>
    <div class="Polaris-Page">
        <div class="Polaris-Page__Header Polaris-Page__Header--hasSeparator Polaris-Page__Header--hasBreadcrumbs Polaris-Page__Header--hasRollup Polaris-Page__Header--hasSecondaryActions">
            <div class="Polaris-Page__Navigation">
                <nav role="navigation">
                    <a class="Polaris-Breadcrumbs__Breadcrumb"
                       href="{{ route('dashboard') }}"
                       data-polaris-unstyled="true">
                        <span class="Polaris-Breadcrumbs__Icon">
                            <span class="Polaris-Icon">
                                <svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true">
                                    <path d="M12 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 0 1 0-1.414l5-5a.999.999 0 1 1 1.414 1.414L8.414 10l4.293 4.293A.999.999 0 0 1 12 16" fill-rule="evenodd"></path>
                                </svg>
                            </span>
                        </span>
                        <span class="Polaris-Breadcrumbs__Content">Back to messaging</span>
                    </a>
                </nav>
            </div>
            <div class="Polaris-Page__Title">
                <div>
                    <h1 class="Polaris-DisplayText Polaris-DisplayText--sizeLarge">Manage Subscription</h1>
                </div>
                <div>

                </div>
            </div>
            <br>
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
        </div>
        <div class="Polaris-Page__Content">
            <div class="Polaris-Layout">
                <div class="background">
                    <div class="container">
                        <div class="panel pricing-table">
                            <div class="pricing-plan">
                                <h2 class="pricing-header">Intro</h2>
                                <ul class="pricing-features">
                                    <li class="pricing-features-item">7 Day One-time Trial</li>
                                    <li class="pricing-features-item">100 Messages / month</li>
                                    <li class="pricing-features-item">Easy to use, integrated SMS system</li>
                                    <li class="pricing-features-item">Easily update individual customers via SMS</li>
                                    <li class="pricing-features-item">Bulk promote to all known customers</li>
                                    <li class="pricing-features-item">In-app support and guides access</li>
                                </ul>
                                <span class="pricing-price">$25/month</span>
                                @if(isset($usedMessages) && $usedMessages >= 100)
                                    <p class="subscription-text">
                                        Can't downgrade to this plan until the end of the
                                        period because {{$usedMessages}} messages have been used.
                                    </p>
                                @elseif(!$subscription || $subscription->name !== 'Simple SMS Lite - Intro')
                                    <a href="{{route('subscription.make', ['code' => 'Simple SMS Lite - Intro', 'shop' => $shop])}}"
                                      class="pricing-button">TRY</a>
                                @else
                                    <p class="subscription-text">You are on this plan</p>
                                @endif
                            </div>
                            <div class="pricing-plan">
                                <h2 class="pricing-header">Occasional</h2>
                                <ul class="pricing-features">
                                    <li class="pricing-features-item">500 messages / month</li>
                                    <li class="pricing-features-item">Easy to use, integrated SMS system</li>
                                    <li class="pricing-features-item">Easily update individual customers via SMS</li>
                                    <li class="pricing-features-item">Bulk promote to all known customers</li>
                                    <li class="pricing-features-item">In-app support and guides access</li>
                                </ul>
                                <span class="pricing-price">$50/month</span>
                                @if($usedMessages) && $usedMessages >= 500)
                                    <p class="subscription-text">
                                        Can't downgrade to this plan until the end of the
                                        period because {{$usedMessages}} messages have been used.
                                    </p>
                                @elseif(!$subscription || $subscription->name !== 'Simple SMS Lite - Moderate')
                                    <a href="{{route('subscription.make', ['code' => 'Simple SMS Lite - Moderate', 'shop' => $shop])}}"
                                       class="pricing-button">Start Plan</a>
                                @else
                                    <p class="subscription-text">You are on this plan</p>
                                @endif
                            </div>
                            <div class="pricing-plan">
                                {{--<img src="https://s21.postimg.cc/tpm0cge4n/space-ship.png" alt="" class="pricing-img">--}}
                                <h2 class="pricing-header">Moderate</h2>
                                <ul class="pricing-features">
                                    <li class="pricing-features-item">1000 messages / month</li>
                                    <li class="pricing-features-item">Easy to use, integrated SMS system</li>
                                    <li class="pricing-features-item">Easily update individual customers via SMS</li>
                                    <li class="pricing-features-item">Bulk promote to all known customers</li>
                                    <li class="pricing-features-item">In-app support and guides access</li>
                                </ul>
                                <span class="pricing-price">$100/month</span>
                                @if(!$subscription ||  $subscription->name !== 'Simple SMS Lite - Regular')
                                    <a href="{{route('subscription.make', ['code' => 'Simple SMS Lite - Regular', 'shop' => $shop])}}"
                                       class="pricing-button">Start Plan</a>
                                @else
                                    <p class="subscription-text">You are on this plan</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                    Please contact us via support if you need any help with your subscription.
                </div>
            </div>
        </div>
    </div>
@endsection

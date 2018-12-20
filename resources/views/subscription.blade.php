@extends('layouts.polaris')

@section('title', 'Shopify SMS')

@section('content')
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
                        <span class="Polaris-Breadcrumbs__Content">Dashboard</span>
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
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-CalloutCard">
                            <div class="Polaris-CalloutCard__Content">
                                <div class="Polaris-CalloutCard__Title">
                                    <h2 class="Polaris-Heading">Small Tier - $15</h2>
                                </div>
                                <div class="Polaris-TextContainer">
                                    <p>Up to 100 messages across all channels / month.</p>
                                </div>
                                @if(!$subscription || $subscription->name !== 'beacon-sm')
                                    <div class="Polaris-CalloutCard__Buttons">
                                        <a class="Polaris-Button"
                                           href="{{route('subscription.make', ['code' => 'beacon-sm', 'shop' => $shop])}}"
                                           data-polaris-unstyled="true">
                                            <span class="Polaris-Button__Content">
                                                <span>Choose This Tier</span>
                                            </span>
                                        </a>
                                    </div>
                                @else
                                    <div class="Polaris-Card__Section">
                                        <div class="Polaris-TextContainer">
                                            <div class="Polaris-Banner Polaris-Banner--hasDismiss Polaris-Banner--withinContentContainer Polaris-Banner--statusSuccess" tabindex="0" role="status" aria-live="polite" aria-describedby="Banner11Content">
                                                <div class="Polaris-Banner__Dismiss"><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path></svg></span></span></span></button></div>
                                                <div
                                                    class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><g fill-rule="evenodd"><path fill="currentColor" d="M2 3h11v4h6l-2 4 2 4H8v-4H3"></path><path d="M16.105 11.447L17.381 14H9v-2h4a1 1 0 0 0 1-1V8h3.38l-1.274 2.552a.993.993 0 0 0 0 .895zM2.69 4H12v6H4.027L2.692 4zm15.43 7l1.774-3.553A1 1 0 0 0 19 6h-5V3c0-.554-.447-1-1-1H2.248L1.976.782a1 1 0 1 0-1.953.434l4 18a1.006 1.006 0 0 0 1.193.76 1 1 0 0 0 .76-1.194L4.47 12H7v3a1 1 0 0 0 1 1h11c.346 0 .67-.18.85-.476a.993.993 0 0 0 .044-.972l-1.775-3.553z"></path></g></svg></span></div>
                                                <div>
                                                    <div class="Polaris-Banner__Content" id="Banner11Content">
                                                        <p>You are on this tier.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <img src="https://cdn.shopify.com/s/assets/admin/checkout/settings-customizecart-705f57c725ac05be5a34ec20c05b94298cb8afd10aac7bd9c7ad02030f48cfa0.svg"
                                 alt="" class="Polaris-CalloutCard__Image">
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-CalloutCard">
                            <div class="Polaris-CalloutCard__Content">
                                <div class="Polaris-CalloutCard__Title">
                                    <h2 class="Polaris-Heading">Medium Tier - $60</h2>
                                </div>
                                <div class="Polaris-TextContainer">
                                    <p>Up to 500 messages across all channels / month.</p>
                                </div>
                                @if(!$subscription ||  $subscription->name !== 'beacon-md')
                                    <div class="Polaris-CalloutCard__Buttons">
                                        <a class="Polaris-Button"
                                           href="{{route('subscription.make', ['code' => 'beacon-md', 'shop' => $shop])}}"
                                           data-polaris-unstyled="true">
                                                <span class="Polaris-Button__Content">
                                                    <span>Choose This Tier</span>
                                                </span>
                                        </a>
                                    </div>
                                @else
                                    <div class="Polaris-Card__Section">
                                        <div class="Polaris-TextContainer">
                                            <div class="Polaris-Banner Polaris-Banner--hasDismiss Polaris-Banner--withinContentContainer Polaris-Banner--statusSuccess" tabindex="0" role="status" aria-live="polite" aria-describedby="Banner11Content">
                                                <div class="Polaris-Banner__Dismiss"><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path></svg></span></span></span></button></div>
                                                <div
                                                    class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><g fill-rule="evenodd"><path fill="currentColor" d="M2 3h11v4h6l-2 4 2 4H8v-4H3"></path><path d="M16.105 11.447L17.381 14H9v-2h4a1 1 0 0 0 1-1V8h3.38l-1.274 2.552a.993.993 0 0 0 0 .895zM2.69 4H12v6H4.027L2.692 4zm15.43 7l1.774-3.553A1 1 0 0 0 19 6h-5V3c0-.554-.447-1-1-1H2.248L1.976.782a1 1 0 1 0-1.953.434l4 18a1.006 1.006 0 0 0 1.193.76 1 1 0 0 0 .76-1.194L4.47 12H7v3a1 1 0 0 0 1 1h11c.346 0 .67-.18.85-.476a.993.993 0 0 0 .044-.972l-1.775-3.553z"></path></g></svg></span></div>
                                                <div>
                                                    <div class="Polaris-Banner__Content" id="Banner11Content">
                                                        <p>You are on this tier.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <img src="https://cdn.shopify.com/s/assets/admin/checkout/settings-customizecart-705f57c725ac05be5a34ec20c05b94298cb8afd10aac7bd9c7ad02030f48cfa0.svg"
                                 alt="" class="Polaris-CalloutCard__Image">
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-CalloutCard">
                            <div class="Polaris-CalloutCard__Content">
                                <div class="Polaris-CalloutCard__Title">
                                    <h2 class="Polaris-Heading">Large Tier - $120</h2>
                                </div>
                                <div class="Polaris-TextContainer">
                                    <p>Up to 1000 messages across all channels / month.</p>
                                </div>
                                @if(!$subscription ||  $subscription->name !== 'beacon-lg')
                                    <div class="Polaris-CalloutCard__Buttons">
                                        <a class="Polaris-Button"
                                           href="{{route('subscription.make', ['code' => 'beacon-lg', 'shop' => $shop])}}"
                                           data-polaris-unstyled="true">
                                                <span class="Polaris-Button__Content">
                                                    <span>Choose This Tier</span>
                                                </span>
                                        </a>
                                    </div>
                                @else
                                    <div class="Polaris-Card__Section">
                                        <div class="Polaris-TextContainer">
                                            <div class="Polaris-Banner Polaris-Banner--hasDismiss Polaris-Banner--withinContentContainer Polaris-Banner--statusSuccess" tabindex="0" role="status" aria-live="polite" aria-describedby="Banner11Content">
                                                <div class="Polaris-Banner__Dismiss"><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path></svg></span></span></span></button></div>
                                                <div
                                                    class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><g fill-rule="evenodd"><path fill="currentColor" d="M2 3h11v4h6l-2 4 2 4H8v-4H3"></path><path d="M16.105 11.447L17.381 14H9v-2h4a1 1 0 0 0 1-1V8h3.38l-1.274 2.552a.993.993 0 0 0 0 .895zM2.69 4H12v6H4.027L2.692 4zm15.43 7l1.774-3.553A1 1 0 0 0 19 6h-5V3c0-.554-.447-1-1-1H2.248L1.976.782a1 1 0 1 0-1.953.434l4 18a1.006 1.006 0 0 0 1.193.76 1 1 0 0 0 .76-1.194L4.47 12H7v3a1 1 0 0 0 1 1h11c.346 0 .67-.18.85-.476a.993.993 0 0 0 .044-.972l-1.775-3.553z"></path></g></svg></span></div>
                                                <div>
                                                    <div class="Polaris-Banner__Content" id="Banner11Content">
                                                        <p>You are on this tier.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <img src="https://cdn.shopify.com/s/assets/admin/checkout/settings-customizecart-705f57c725ac05be5a34ec20c05b94298cb8afd10aac7bd9c7ad02030f48cfa0.svg"
                                 alt="" class="Polaris-CalloutCard__Image">
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-CalloutCard">
                            <div class="Polaris-CalloutCard__Content">
                                <div class="Polaris-CalloutCard__Title">
                                    <h2 class="Polaris-Heading">Extra Large Tier - $550</h2>
                                </div>
                                <div class="Polaris-TextContainer">
                                    <p>Up to 5000 messages across all channels / month.</p>
                                </div>
                                @if(!$subscription || $subscription->name !== 'beacon-xl')
                                    <div class="Polaris-CalloutCard__Buttons">
                                        <a class="Polaris-Button"
                                           href="{{route('subscription.make', ['code' => 'beacon-xl', 'shop' => $shop])}}"
                                           data-polaris-unstyled="true">
                                                <span class="Polaris-Button__Content">
                                                    <span>Choose This Tier</span>
                                                </span>
                                        </a>
                                    </div>
                                @else
                                    <div class="Polaris-Card__Section">
                                        <div class="Polaris-TextContainer">
                                            <div class="Polaris-Banner Polaris-Banner--hasDismiss Polaris-Banner--withinContentContainer Polaris-Banner--statusSuccess" tabindex="0" role="status" aria-live="polite" aria-describedby="Banner11Content">
                                                <div class="Polaris-Banner__Dismiss"><button type="button" class="Polaris-Button Polaris-Button--plain Polaris-Button--iconOnly" aria-label="Dismiss notification"><span class="Polaris-Button__Content"><span class="Polaris-Button__Icon"><span class="Polaris-Icon"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><path d="M11.414 10l4.293-4.293a.999.999 0 1 0-1.414-1.414L10 8.586 5.707 4.293a.999.999 0 1 0-1.414 1.414L8.586 10l-4.293 4.293a.999.999 0 1 0 1.414 1.414L10 11.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L11.414 10z" fill-rule="evenodd"></path></svg></span></span></span></button></div>
                                                <div
                                                    class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorInkLighter Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><g fill-rule="evenodd"><path fill="currentColor" d="M2 3h11v4h6l-2 4 2 4H8v-4H3"></path><path d="M16.105 11.447L17.381 14H9v-2h4a1 1 0 0 0 1-1V8h3.38l-1.274 2.552a.993.993 0 0 0 0 .895zM2.69 4H12v6H4.027L2.692 4zm15.43 7l1.774-3.553A1 1 0 0 0 19 6h-5V3c0-.554-.447-1-1-1H2.248L1.976.782a1 1 0 1 0-1.953.434l4 18a1.006 1.006 0 0 0 1.193.76 1 1 0 0 0 .76-1.194L4.47 12H7v3a1 1 0 0 0 1 1h11c.346 0 .67-.18.85-.476a.993.993 0 0 0 .044-.972l-1.775-3.553z"></path></g></svg></span></div>
                                                <div>
                                                    <div class="Polaris-Banner__Content" id="Banner11Content">
                                                        <p>You are on this tier.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <img src="https://cdn.shopify.com/s/assets/admin/checkout/settings-customizecart-705f57c725ac05be5a34ec20c05b94298cb8afd10aac7bd9c7ad02030f48cfa0.svg"
                                 alt="" class="Polaris-CalloutCard__Image">
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-CalloutCard">
                            <div class="Polaris-CalloutCard__Content">
                                <div class="Polaris-CalloutCard__Title">
                                    <h2 class="Polaris-Heading">Custom Plan</h2>
                                </div>
                                <div class="Polaris-TextContainer">
                                    <p>If you need us to add a custom plan to suit your requirements, please send us a request.</p>
                                </div>
                                <div class="Polaris-CalloutCard__Buttons">
                                    <a class="Polaris-Button"
                                       href="{{route('contact')}}"
                                       data-polaris-unstyled="true">
                                            <span class="Polaris-Button__Content">
                                                <span>Request another plan</span>
                                            </span>
                                    </a>
                                </div>
                            </div>
                            <img src="https://cdn.shopify.com/s/assets/admin/checkout/settings-customizecart-705f57c725ac05be5a34ec20c05b94298cb8afd10aac7bd9c7ad02030f48cfa0.svg"
                                 alt="" class="Polaris-CalloutCard__Image">
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Header">
                        <h2 class="Polaris-Heading">What are the charges for?</h2>
                    </div>
                    <div class="Polaris-Card__Section">
                        <p>20% of our app charges go to Shopify transaction fees.</p>

                        <p>The rest covers all third party message sending fees (around 70%), plus our infrastructure fees and a
                            percentage to invest back into developing our apps.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

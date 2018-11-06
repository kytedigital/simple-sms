@extends('layouts.polaris')

@section('title', 'Ut Oh')

@section('content')
<div class="Polaris-Banner Polaris-Banner--statusWarning Polaris-Banner--withinPage" tabindex="0" role="alert" aria-live="polite" aria-labelledby="Banner4Heading" aria-describedby="Banner4Content"><div class="Polaris-Banner__Ribbon"><span class="Polaris-Icon Polaris-Icon--colorYellowDark Polaris-Icon--isColored Polaris-Icon--hasBackdrop"><svg class="Polaris-Icon__Svg" viewBox="0 0 20 20" focusable="false" aria-hidden="true"><g fill-rule="evenodd"><circle fill="currentColor" cx="10" cy="10" r="9"></circle><path d="M10 0C4.486 0 0 4.486 0 10s4.486 10 10 10 10-4.486 10-10S15.514 0 10 0m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8m0-13a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1m0 8a1 1 0 1 0 0 2 1 1 0 0 0 0-2"></path></g></svg></span></div>
    <div>
        <div class="Polaris-Banner__Heading" id="Banner3Heading">
            <p class="Polaris-Heading">Please Reopen The App</p>
        </div>
        <div class="Polaris-Banner__Content" id="Banner3Content">

            <p>
                It looks like the app has doesn't have access to store details anymore
                and needs to be re-opened to get some information from
                Shopify. Sometimes this happens when navigating around services outside the app
                (such as billing and subscriptions).<br><br>

            <p class="Polaris-Heading">Please navigate back to Apps and then open this app again in your Shopify admin.</p>

                <em>(we cannot refresh the page from with in this frame)</em>
            </p>

        </div>
    </div>
</div>
<div class="Polaris-SkeletonPage__Page" role="status" aria-label="Page loading">
    <div class="Polaris-SkeletonPage__Header Polaris-SkeletonPage__Header--hasSecondaryActions">
        <div>
            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeLarge"></div>
        </div>
        <div class="Polaris-SkeletonPage__Actions">
            <div class="Polaris-SkeletonPage__Action" style="width: 74px;">
                <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                    <div class="Polaris-SkeletonBodyText"></div>
                </div>
            </div>
            <div class="Polaris-SkeletonPage__Action" style="width: 67px;">
                <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                    <div class="Polaris-SkeletonBodyText"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="Polaris-SkeletonPage__Content">
        <div class="Polaris-Layout">
            <div class="Polaris-Layout__Section">
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                            <div class="Polaris-SkeletonBodyText"></div>
                            <div class="Polaris-SkeletonBodyText"></div>
                            <div class="Polaris-SkeletonBodyText"></div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-TextContainer">
                            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeSmall"></div>
                            <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-TextContainer">
                            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeSmall"></div>
                            <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="Polaris-Layout__Section Polaris-Layout__Section--secondary">
                <div class="Polaris-Card">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-TextContainer">
                            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeSmall"></div>
                            <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                            </div>
                        </div>
                    </div>
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                            <div class="Polaris-SkeletonBodyText"></div>
                        </div>
                    </div>
                </div>
                <div class="Polaris-Card Polaris-Card--subdued">
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-TextContainer">
                            <div class="Polaris-SkeletonDisplayText__DisplayText Polaris-SkeletonDisplayText--sizeSmall"></div>
                            <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                                <div class="Polaris-SkeletonBodyText"></div>
                                <div class="Polaris-SkeletonBodyText"></div>
                            </div>
                        </div>
                    </div>
                    <div class="Polaris-Card__Section">
                        <div class="Polaris-SkeletonBodyText__SkeletonBodyTextContainer">
                            <div class="Polaris-SkeletonBodyText"></div>
                            <div class="Polaris-SkeletonBodyText"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
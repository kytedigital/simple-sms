import { Store } from '../store'
import SimpleSDK from '../services/SimpleSDK';

export const STORE_SUBSCRIPTION = 'STORE_SUBSCRIPTION';
export const FETCH_SUBSCRIPTION_START   = 'FETCH_SUBSCRIPTION_START';
export const FETCH_SUBSCRIPTION_FAILURE = 'FETCH_SUBSCRIPTION_FAILURE';

export const fetchSubscriptionStart = () => ({
    type: FETCH_SUBSCRIPTION_START
});

export const storeSubscription = subscription => ({
    type: STORE_SUBSCRIPTION,
    payload: subscription
});

export const fetchSubscriptionFailure = error => ({
    type: FETCH_SUBSCRIPTION_FAILURE,
    payload: { error }
});

export function fetchSubscription() {
    console.log('Running Fetch');

    Store.dispatch(fetchSubscriptionStart());

    SimpleSDK.subscription(
        (resource) => Store.dispatch(storeSubscription(resource)),
        (error) => Store.dispatch(fetchSubscriptionFailure(error))
    );
}
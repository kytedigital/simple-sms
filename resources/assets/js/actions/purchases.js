import { Store } from '../store'
import SimpleSDK from '../services/SimpleSDK';

export const STORE_PURCHASES = 'STORE_PURCHASES';
export const FETCH_PURCHASES_START   = 'FETCH_PLANS_START';
export const FETCH_PURCHASES_FAILURE = 'FETCH_PURCHASES_FAILURE';

export const fetchPurchasesStart = () => ({
    type: FETCH_PURCHASES_START
});

export const storePurchases = purchases => ({
    type: STORE_PURCHASES,
    payload: purchases
});

export const fetchPurchasesFailure = error => ({
    type: FETCH_PURCHASES_FAILURE,
    payload: { error }
});

export function fetchPurchases() {
    Store.dispatch(fetchPurchasesStart());

    SimpleSDK.purchases(
        (resources) => Store.dispatch(storePurchases(resources)),
        (error) => Store.dispatch(fetchPurchasesFailure(error))
    );
}
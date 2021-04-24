import { Store } from '../store'
import SimpleSDK from '../services/SimpleSDK';

export const STORE_PLANS = 'STORE_PLANS';
export const FETCH_PLANS_START   = 'FETCH_PLANS_START';
export const FETCH_PLANS_FAILURE = 'FETCH_PLANS_FAILURE';

export const fetchPlansStart = () => ({
    type: FETCH_PLANS_START
});

export const storePlans = plans => ({
    type: STORE_PLANS,
    payload: plans
});

export const fetchPlansFailure = error => ({
    type: FETCH_PLANS_FAILURE,
    payload: { error }
});

export function fetchPlans() {
    Store.dispatch(fetchPlansStart());

    SimpleSDK.plans(
        (resource) => Store.dispatch(storePlans(resource)),
        (error) => Store.dispatch(fetchPlansFailure(error))
    );
}
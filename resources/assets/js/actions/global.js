import { Store } from '../store'

export const IS_LOADING = 'IS_LOADING';

export function isLoading() {
    Store.dispatch({
        type: IS_LOADING,
        payload: true
    });
}

export function isNotLoading() {
    Store.dispatch({
        type: IS_LOADING,
        payload: false
    });
}

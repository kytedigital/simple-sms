import { Store } from '../store'

export const IS_LOADING = 'IS_LOADING';

export function isLoading() {
    console.log('App Loading');

    Store.dispatch({
        type: IS_LOADING,
        payload: false
    });
}

export function isNotLoading() {
    console.log('App Loading');

    Store.dispatch({
        type: IS_LOADING,
        payload: true
    });
}

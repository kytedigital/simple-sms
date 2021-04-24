export const CHANGE_PREVIOUS_LOCATION = 'CHANGE_PREVIOUS_LOCATION';

export const changePreviousLocation = route => ({
    type: CHANGE_PREVIOUS_LOCATION,
    payload: route
});

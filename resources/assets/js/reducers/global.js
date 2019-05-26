const global = (state = { 'loading': true }, action) => {
    switch (action.type) {
        case 'IS_LOADING':
            return Object.assign({}, state, {
                loading: action.payload
            });
        default:
            return state
    }
};

export default global;

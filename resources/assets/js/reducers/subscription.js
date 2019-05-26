const subscription = (state = [], action) => {
    switch (action.type) {
        case 'STORE_SUBSCRIPTION':
            return action.payload;
        default:
            return state
    }
};

export default subscription;

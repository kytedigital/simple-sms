const purchases = (state = [], action) => {
    switch (action.type) {
        case 'STORE_PURCHASES':
            return action.payload;
        default:
            return state
    }
};

export default purchases;

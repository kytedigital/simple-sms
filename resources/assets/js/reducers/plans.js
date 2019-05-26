const plans = (state = [], action) => {
    switch (action.type) {
        case 'STORE_PLANS':
            return action.payload;
        default:
            return state
    }
};

export default plans;

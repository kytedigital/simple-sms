const subscription = (state = [], action) => {
    switch (action.type) {
        case 'ADD_NOTICE':
            return action.payload;
        case 'CLEAR_NOTICES':
            return action.payload;
        default:
            return state
    }
};

export default subscription;

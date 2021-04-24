const customers = (state = [], action) => {
    switch (action.type) {
        case 'ADD_CUSTOMER':
            return [
                ...state,
                {
                    id: action.id,
                    text: action.text,
                    completed: false
                }
            ];
        case 'ADD_CUSTOMERS':
            return [
                ...state,
                action.customers
            ];
        default:
            return state
    }
};

export default customers
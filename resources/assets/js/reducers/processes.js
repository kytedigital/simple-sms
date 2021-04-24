const initialState = [];

const processes = (state = initialState, action) => {
    switch (action.type) {
        case 'ADD_PROCESS':
            return [
                ...state,
                {
                    id: action.id,
                    text: action.text,
                    completed: false
                }
            ];
        default:
            return state
    }
};

export default processes;
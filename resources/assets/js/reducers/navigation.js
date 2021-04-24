const navigation = (state = {previousLocation: {}}, action) => {
    switch (action.type) {
        case 'CHANGE_PREVIOUS_LOCATION':
            return {
                ...state,
                previousLocation: {
                    path: action.payload.path,
                    title: action.payload.title,
                }
            };
        default:
            return state
    }
};

export default navigation;
import { combineReducers } from 'redux'
import subscription from './subscription'
import global from './global'
import plans from './plans'

export default combineReducers({
    global,
    subscription,
    plans,
});

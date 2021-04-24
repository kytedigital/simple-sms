import { combineReducers } from 'redux'
import { connectRouter } from 'connected-react-router'
import subscription from './subscription'
import global from './global'
import plans from './plans'
import purchases from './purchases'
import navigation from './navigation'
import routerLocations from './routerLocations'

export default (history) => combineReducers({
    router: connectRouter(history),
    global,
    subscription,
    plans,
    purchases,
    navigation,
    routerLocations
});

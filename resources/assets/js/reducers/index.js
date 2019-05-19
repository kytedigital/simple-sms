import { combineReducers } from 'redux'
import recipients from './recipients'
import processes from './processes'
import messages from './messages'

export default combineReducers({
    recipients,
    processes,
    messages
});

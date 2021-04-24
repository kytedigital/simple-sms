import { combineReducers } from 'redux';
import recipients from './recipients';
import processes from './processes';

export default combineReducers({
    recipients,
    processes,
});

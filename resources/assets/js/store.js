import { createBrowserHistory } from 'history'
import {applyMiddleware, compose, createStore} from "redux";
import reducers from "./reducers";
import { routerMiddleware } from 'connected-react-router'

export const history = createBrowserHistory();

export const Store = createStore(
    reducers(history),
    compose(
        applyMiddleware(
            routerMiddleware(history),
        ),
        window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
    ),
);

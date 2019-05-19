import React, { Component } from 'react';
import { BrowserRouter as Router, Route } from "react-router-dom";
import { Provider } from 'react-redux'
import { createStore } from 'redux'
import { AppProvider } from '@shopify/polaris';
import reducers from './reducers/index'
import Index from "./containers/Pages/Index";
import Plans from "./containers/Pages/Plans";

const store = createStore(reducers);

export default class SimpleApp extends Component {
    render() {
        return (
            <Provider store={store}>
                <div style={{ backgroundColor: '#f4f6f8' }}>
                    <AppProvider>
                        <Router>
                            <Route exact path="/" component={Index} />
                            <Route path="/log" component={Plans} />
                        </Router>
                    </AppProvider>
                </div>
            </Provider>
        );
    }
}

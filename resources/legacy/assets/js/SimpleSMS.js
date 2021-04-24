import React, { Component } from 'react';
import { BrowserRouter as Router, Route } from "react-router-dom";
import { Provider } from 'react-redux'
import { AppProvider } from '@shopify/polaris';
import store from './store/index'
import Dashboard from "./containers/Pages/Dashboard";
import ProcessLog from "./containers/Pages/ProcessLog";

const defaultState = {

};

 class SimpleSMS extends Component {
    constructor(props) {
        super(props);

        this.state = defaultState;
    }

    reset() {
        this.setState(defaultState);
    }

    render() {
        return (
            <Provider store={store}>
                <div style={{ backgroundColor: '#f4f6f8' }}>
                    <AppProvider>
                        <Router>
                            <Route exact path="/" component={Dashboard} />
                            <Route path="/log" component={ProcessLog} />
                        </Router>
                    </AppProvider>
                </div>
            </Provider>
        );
    }
}

export default SimpleSMS;

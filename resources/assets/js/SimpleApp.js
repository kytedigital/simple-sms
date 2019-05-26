import React, { Component } from 'react';
import { BrowserRouter as Router, Route } from "react-router-dom";
import { Context } from './context';
import { Provider } from 'react-redux';
import { AppProvider } from '@shopify/polaris';
import { Store } from './store'
import Index from "./containers/Pages/Index";
import Plans from "./containers/Pages/Plans";
    // import bridge from './AppBridge';
import * as ReactDOM from "react-dom";
import { fetchSubscription } from './actions/subscription';
import { fetchPlans } from './actions/plans';
import * as GlobalActions from './actions/global';

console.log('App Context', AppContext);

export default class SimpleApp extends Component {
    componentDidMount() {
        GlobalActions.isLoading();
        fetchSubscription();
        fetchPlans(); // TODO : Move to plans page.
        GlobalActions.isNotLoading();
    }

    render() {
        return (
            <Context.Provider value={{...AppContext}}>
                <Provider store={Store}>
                    <div style={{ backgroundColor: '#f4f6f8' }}>
                        <AppProvider>
                            <Router>
                                <Route exact path="/" component={Index} />
                                <Route path="/log" component={Plans} />
                            </Router>
                        </AppProvider>
                    </div>
                </Provider>
            </Context.Provider>
        );
    }
}

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById('App')) {
        ReactDOM.render(
            <SimpleApp />,
            document.getElementById('App'));
    }
});

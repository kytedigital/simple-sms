import React, { Component } from 'react';
import { HashRouter, Route } from "react-router-dom";
import { ConnectedRouter } from 'connected-react-router'
import { Context } from './context';
import { Provider } from 'react-redux';
import * as ReactDOM from "react-dom";
import { Store, history } from './store'
import { AppProvider } from '@shopify/polaris';
import Automation from "./containers/Pages/Automation";
import Messenger from "./containers/Pages/Messenger";
import History from "./containers/Pages/History";
import Balance from "./containers/Pages/Balance";
import Plans from "./containers/Pages/Plans";
import { fetchSubscription } from './actions/subscription';
import { fetchPlans } from './actions/plans';
import { fetchPurchases } from './actions/purchases';
import * as GlobalActions from './actions/global'

console.log('App Context', AppContext);

export default class SimpleApp extends Component {
    componentDidMount() {
        this.mountData();
    }

    async mountData() {
        GlobalActions.isLoading();
        await this.populate();
        GlobalActions.isNotLoading();
    }

    async populate() {
        fetchSubscription();
        fetchPlans(); // TODO : Move to plans page.
        fetchPurchases(); // TODO : Move to plans page.
    }

    render() {
        return (
            <Context.Provider value={{...AppContext}}>
                <Provider store={Store}>
                    <ConnectedRouter history={history}>
                        <div style={{backgroundColor: '#f4f6f8' }}>
                            <AppProvider>
                                <HashRouter>
                                    <Route exact path="/" component={Automation} />
                                    <Route exact path="/messenger" component={Messenger} />
                                    <Route exact path="/balance" component={Balance} />
                                    <Route exact path="/history" component={History} />
                                    <Route exact path="/plans" component={Plans} />
                                </HashRouter>
                            </AppProvider>
                        </div>
                    </ConnectedRouter>
                </Provider>
            </Context.Provider>
        );
    }
}

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById('App')) {
        ReactDOM.render(<SimpleApp />, document.getElementById('App'));
    }
});

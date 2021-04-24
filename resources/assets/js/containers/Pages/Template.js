import React, { Component } from 'react';
import { Context } from '../../context';
import { Layout, PageActions } from '@shopify/polaris';
import LoadingPage from "../../components/Loaders/LoadingPage";
import PageWrapper from "../../components/PageWrapper/PageWrapper";

class Balance extends Component {
    constructor(props) {
        super(props);

        this.state = {};
    }

    componentWillMount() {
        this.fetchData();
    }

    fetchData() {
        this.setState({ loading: true });
    }

    readyToExecute() {
        return true;
    }

    execute() {
        // Do primary action.
    }

    getPrimaryAction() {
        return {
            content: 'Save Automations',
            onAction: this.execute,
            disabled: !this.readyToExecute(),
        }
    }

    render() {
        const pageMarkup = this.state.loading ? (
            <Layout>
                <Layout.Section oneHalf>

                </Layout.Section>
                <Layout.Section oneHalf>

                </Layout.Section>
            </Layout>
        ) : <LoadingPage />;

        return <PageWrapper primaryAction={this.getPrimaryAction()}>
            {pageMarkup}
            <PageActions primaryAction={this.getPrimaryAction()} />
        </PageWrapper>;
    }
}

Balance.contextType = Context;

export default props => (
    <Context.Consumer>
        {state => <Balance {...props} context={state} />}
    </Context.Consumer>
);
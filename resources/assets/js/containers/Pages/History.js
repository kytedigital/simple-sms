import React, { Component } from 'react';
import { Context } from '../../context';
import { Layout, PageActions } from '@shopify/polaris';
import LoadingPage from "../../components/Loaders/LoadingPage";
import PageWrapper from "../../components/PageWrapper/PageWrapper";

class History extends Component {
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

    render() {
        const pageMarkup = this.state.loading ? (
            <Layout>
                <Layout.Section oneHalf>

                </Layout.Section>
                <Layout.Section oneHalf>

                </Layout.Section>
            </Layout>
        ) : <LoadingPage />;

        return <PageWrapper title="History">
            {pageMarkup}
        </PageWrapper>;
    }
}

History.contextType = Context;

export default props => (
    <Context.Consumer>
        {state => <History {...props} context={state} />}
    </Context.Consumer>
);
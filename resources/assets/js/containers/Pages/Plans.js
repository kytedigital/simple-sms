import React, { Component } from 'react';
import { Context } from '../../context';
import { Layout, PageActions } from '@shopify/polaris';
import LoadingPage from "../../components/Loaders/LoadingPage";
import PageWrapper from "../../components/PageWrapper/PageWrapper";

class Plan extends Component {
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
            content: 'Change Plan',
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

        return <PageWrapper primaryAction={this.getPrimaryAction()} title="Plans">
            {pageMarkup}
            <PageActions primaryAction={this.getPrimaryAction()} />
        </PageWrapper>;
    }
}

Plan.contextType = Context;

export default props => (
    <Context.Consumer>
        {state => <Plan {...props} context={state} />}
    </Context.Consumer>
);
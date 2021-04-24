import React, { Component } from 'react';
import { Context } from '../../context';
import { Layout, PageActions } from '@shopify/polaris';
import BannerNotice from "../../components/Notices/BannerNotice";
import LoadingPage from "../../components/Loaders/LoadingPage";
import PageWrapper from "../../components/PageWrapper/PageWrapper";

const defaultState = {
    loading: true,
    processes: [],
    fieldErrors: [],
    showConfirmation: false
};

class Automation extends Component {
    constructor(props) {
        super(props);

        this.state = defaultState;
    }

    reset() {
        this.setState(defaultState);
    }

    componentWillMount() {
        this.fetchData();
    }

    fetchData() {
        this.setState({ loading: false });

        // Get any page specific Data.
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
        const {
            notice
        } = this.state;

        if (this.state.loading) { return <LoadingPage /> }

        const bannerNotice = notice ? (
            <Layout.Section fullWidth>
                <BannerNotice
                    title={this.state.noticeTitle}
                    notice={this.state.notice}
                    onDismiss={this.clearNotices.bind(this)}
                    status={this.state.bannerStatus}
                />
            </Layout.Section>
        ) : null;

        const pageMarkup = this.state.loading ? (
                <Layout>
                    {bannerNotice}
                    <Layout.Section oneHalf>

                    </Layout.Section>
                    <Layout.Section oneHalf>

                    </Layout.Section>
                </Layout>
        ) : <LoadingPage />;

        return <PageWrapper primaryAction={this.getPrimaryAction()} title="Automation">
                    {pageMarkup}
                    <PageActions primaryAction={this.getPrimaryAction()} />
                </PageWrapper>;
    }
}

Automation.contextType = Context;

export default props => (
    <Context.Consumer>
        {state => <Automation {...props} context={state} />}
    </Context.Consumer>
);
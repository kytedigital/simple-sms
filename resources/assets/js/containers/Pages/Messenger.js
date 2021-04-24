import React, { Component } from 'react';
import { Context } from '../../context';
import {Card, Layout, PageActions} from '@shopify/polaris';
import ConfirmationModel from "../../components/Modals/ConfirmationModal";
import BannerNotice from "../../components/Notices/BannerNotice";
import LoadingPage from "../../components/Loaders/LoadingPage";
import PageWrapper from "../../components/PageWrapper/PageWrapper";
import CustomerSearch from "../../containers/search/customerSearch";

const defaultState = {
    loading: true,
    processes: [],
    fieldErrors: [],
    showConfirmation: false
};

class Messenger extends Component {
    constructor(props) {
        super(props);

        this.state = defaultState;
    }

    reset() {
        this.setState(defaultState);
    }

    componentWillMount() {
        this.fetchData();
        this.setUpEchos();
    }

    setUpEchos()
    {
        this.props.context.channel.listen('MessageDispatchStarted', (details) => {this.processStartedEcho(details);});
        this.props.context.channel.listen('MessageDispatchCompleted', (details) => {this.processCompleteEcho(details);})
    }

    fetchData() {
        this.setState({ loading: false });

        // Get any page specific Data.
    }

    processStartedEcho(details) {
        this.setState(state => {
            processes: state.processes.push(details)
        });

        this.setState({
            "noticeTitle": "Processing",
            "notice": details.notice,
            'bannerStatus': "info"
        });
    }

    processCompleteEcho(details) {
        this.setState(state => {
            processed: state.processed.push(details)
        });

        let message = details.response.message;
        if(typeof message === 'object') { message = message.reason }

        const newDetails = {
            'recipient': details.message.recipient.id,
            'message': message,
            'status': details.response.status
        };

        this.setState({ dispatchDetails: [...this.state.dispatchDetails, newDetails] });

        // Wait 2 seconds
        setTimeout(() => {
            if(this.state.processes.length < 5) return;

            this.setState(state => {
                const cleanedProcessList = state.processes.filter((item) => {
                    return item.message.recipient.id !== details.message.recipient.id;
                });

                return { processes: cleanedProcessList };
            });
        }, 4000);
    }

    clearNotices() {
        this.setState({
            "notice": '',
            "noticeTitle": "",
            "fieldErrors": [],
            "bannerStatus": "info"
        });
    }

    clearFieldError(field) {
        const errors = this.state.fieldErrors.filter((error) => {
            return error.field !== field;
        });

        this.setState({"fieldErrors": errors});
    }

    getFieldErrors(field) {
        const errors = this.state.fieldErrors.filter((error) => {
            return error.field === field;
        });

        return errors.length ? errors[0].error : null;
    }

    sendMessage() {
        this.setState({"showSendConfirmation": false});

        if(!this.validateFields() || !this.validateCredit()) {
            return false;
        }

        window.scrollTo(0, 0);

        this.channel.whisper('updates', {
            title: "Sending messages..."
        });

        this.setState({
            "status": 1,
            "statusMessage": "Queueing...",
            "noticeTitle": 'Sending...',
            "notice": 'Sending your message, the status will be updated here when it completes.',
            'bannerStatus': "success"
        });

        SimpleSDK.sendMessage(this.state.message, this.selectedRecipients(), (response) => {
            this.setState({"status": 1, "statusMessage": "Queued"});
        });
    };


    validateFields() {
        this.clearNotices();

        let error = false; // Because set state is slow

        if(!this.state.message) {
            error = true;
            this.setState({
                "fieldErrors": [
                    {
                        "field": "message",
                        "error": "Please provide a message to send to your customers."
                    }],
                "noticeTitle": 'Missing Details',
                "notice": 'Please provide a message to send to your customers.',
                'bannerStatus': "warning"
            });
        }

        return !error;
    }

    readyToExecute() {
        return this.state.message && this.state.selectedRecipientIds.length;
    }

    execute() {
        // Do primary action.
    }

    showConfirmation() {
        window.scrollTo(0, 0);

        if(!this.validateFields()) {
            window.scrollTo(0, 0);
            return false;
        }

        this.setState({"showConfirmation": true});
    }

    getPrimaryAction() {
        return this.state.status ?
            {
                content: 'Start Again',
                onAction: () => this.showResetOptions(),
                disabled: !this.readyToSend()
            } :
            {
                content: 'Preview and Send',
                onAction: () => this.showSendConfirmation(),
                disabled: !this.readyToExecute(),
            };
    }

    render() {
        const {
            showSendConfirmation,
            notice
        } = this.state;

        if (this.state.loading) { return <LoadingPage /> }

        const confirmationModel = showSendConfirmation ? (
            <ConfirmationModel
                onSend={() => this.execute()}
                onClose={() => this.setState({"showSendConfirmation": false})}
            />
        ) : null;

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
                    <Card>
                        <CustomerSearch />
                    </Card>
                </Layout.Section>
                <Layout.Section oneHalf>

                </Layout.Section>
            </Layout>
        ) : <LoadingPage />;

        return <PageWrapper primaryAction={this.getPrimaryAction()} title="Messenger">
            {pageMarkup}
            {confirmationModel}
            <PageActions primaryAction={this.getPrimaryAction()} />
        </PageWrapper>;
    }
}

Messenger.contextType = Context;

export default props => (
    <Context.Consumer>
        {state => <Messenger {...props} context={state} />}
    </Context.Consumer>
);
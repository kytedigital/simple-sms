import React, { Component } from 'react';
import { Page, Layout, Card, TextStyle, PageActions } from '@shopify/polaris';

const defaultState = {
    loading: true,
    processes: [],
    fieldErrors: [],
    showConfirmation: false
};

export default class Plans extends Component {
    constructor(props) {
        super(props);

        this.state = defaultState;
    }

    componentWillMount() {
        this.setEcho();
        this.listenToEchos();
        this.fetchData();
    }

    fetchData() {
        this.setState({ loading: true });
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

        SImpleSDK.sendMessage(this.state.message, this.selectedRecipients(), (response) => {
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
                disabled: !this.readyToSend(),
            };
    }

    render() {
        const {
            showResetOptions,
            showSendConfirmation
        } = this.state;

        if (this.state.loading) { return <LoadingPage /> }

        const resetOptionsModal = showResetOptions ? (
            <ResetOptionsModal
                onReset={() => this.reset()}
            />
        ) : null;

        const requiredCredits = this.calculateRequiredCredits();

        const sendConfirmationModel = showSendConfirmation ? (
            <SendConfirmationModal
                message={this.state.message}
                recipientsCount={this.state.selectedRecipientIds.length}
                onSend={() => this.sendMessage()}
                onClose={() => this.setState({"showSendConfirmation": false})}
                requiredCredits={requiredCredits}
            />
        ) : null;

        const leftBar = this.state.status ? (
            <ProcessingList
                channel={this.channel}
                recipients={this.selectedRecipientsWithStatuses()}
                sending={this.state.status}
                processes={this.state.processes}
                processed={this.state.processed}
            />
        ) : (
            <CustomerList
                onChange={this.changeCustomers.bind(this)}
                selectAllCustomers={this.selectAllCustomers.bind(this)}
                unSelectAllCustomers={this.unSelectAllCustomers.bind(this)}
                selected={this.state.selectedRecipientIds}
                customers={this.acceptableCustomers()}
                resultsPerPage={10}
                loadingData={this.state.loadingData}
                toggleItemSelection={this.toggleItemSelection.bind(this)}
            />
        );

        const bannerNotice = this.state.notice ? (
            <Layout.Section fullWidth>
                <BannerNotice
                    title={this.state.noticeTitle}
                    notice={this.state.notice}
                    onDismiss={this.clearNotices.bind(this)}
                    status={this.state.bannerStatus}
                />
            </Layout.Section>
        ) : null;

        const pageActions = <PageActions
            primaryAction={this.getPrimaryAction()}
        />;

        const actualPageMarkup =
            <Layout>
                {bannerNotice}
                <Layout.Section oneHalf>
                    {leftBar}
                </Layout.Section>
                <Layout.Section oneHalf>
                    <Card
                        title={`Step 2 - Write a Message`}>
                        <Message
                            message={this.state.message}
                            onChange={this.changeMessage.bind(this)}
                            error={this.getFieldErrors("message")}
                            disabled={this.state.status}
                            maxSingleLengthStandard={singleMessageLength}
                            maxSingleLengthUnicode={unicodeSingleMessageLength}
                            hasUnicode={this.messageHasUnicode()}
                            requiredCredits={requiredCredits}
                        />
                        <AvailablePlaceholders />
                        <Card.Section>
                            <TextStyle variation="subdued">
                                {this.state.selectedRecipientIds.length} recipients selected - {requiredCredits} credits required to send
                            </TextStyle>
                        </Card.Section>
                    </Card>
                </Layout.Section>
            </Layout>;

        const pageMarkup = this.isLoading() ? <LoadingPage /> : actualPageMarkup;

        return <Page title="Simple SMS"
                     fullWidth
                     primaryAction={this.getPrimaryAction()}
            // secondaryActions={[{
            //     content: 'Open Message Logs',
            //     onAction: () => this.props.history.push('/log')
            // }]}
        >
            {pageMarkup}
            {resetOptionsModal}
            {sendConfirmationModel}
            {pageActions}
        </Page>;
    }
}

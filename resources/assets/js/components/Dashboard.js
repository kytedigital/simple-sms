import React, { Component } from 'react';
import {AppProvider, Page, Layout, Card, Toast} from '@shopify/polaris';
import SendifySdk from '../services/SendifySdk';
import Message from "./Message";
import LoadingPage from './LoadingPage';
import BannerNotice from "./BannerNotice";
import CustomerList from "./CustomerList";
import CreditSummary from "./CreditSummary";
import ProcessingList from "./ProcessingList";
import ResetOptionsModal from "./ResetOptionsModal";
import AvailablePlaceholders from './AvailablePlaceholders';
import SendConfirmationModal from "./SendConfirmationModal";

const singleMessageLength = 160;
const unicodeSingleMessageLength = 70;

const defaultState = {
    status: 0,
    notice: "",
    message: "",
    customers: [],
    toastText: '',
    noticeTitle: "",
    fieldErrors: [],
    showToast: false,
    dispatchDetails: [],
    processingResults: [],
    showResetOptions: false,
    subscriptionDetails: null,
    statusMessage: "Pending",
    selectedRecipientIds: [],
    showSendConfirmation: false,
};

export default class Dashboard extends Component {
    constructor(props) {
        super(props);

        this.state = defaultState;
    }

    reset() {
        this.setState(defaultState);
        this.fetchShopData();
    }

    componentWillMount() {
        this.setEcho();
        this.listenToEchos();
        this.fetchShopData();
    }

    fetchShopData() {
        SendifySdk.getCustomers((customers) => {this.setState({"customers": customers})});
        SendifySdk.getSubscriptionDetails((details) => {this.setState({"subscriptionDetails": details})});
    }

    messageHasUnicode() {
        try {
            // Try to convert to utf-8
            decodeURIComponent(escape(this.state.message)); // If the conversion succeeds, text is not utf-8
        }catch(e) {
            return true;
        }

        return false; // returned text is always utf-8
    }

    isLoading() {
        return !this.state.customers.length;
    }

    setEcho() {
        this.channel = window.Echo.private('shop.'+this.props.shop);
    }

    getMaxSingleCharacterLength() {
        return this.messageHasUnicode() ? unicodeSingleMessageLength : singleMessageLength;
    }

    getMaxCharacterLength() {
        return this.getMaxSingleCharacterLength() * 4;
    }

    calculateMessageLength() {
        return Math.ceil(this.state.message.length / this.getMaxSingleCharacterLength());
    }

    calculateRequiredCredits() {
        console.log(this.calculateMessageLength());
        return this.calculateMessageLength() * this.state.selectedRecipientIds.length;
    }

    listenToEchos() {
        console.debug('Subscribing to private-shop.'+this.props.shop);
        this.channel.listen('MessageDispatchCompleted', (details) => {this.messageCompleteEcho(details);})
        this.channel.listen('MessageDispatchStarted', (details) => {this.messageStartedEcho(details);})
        this.channel.listenForWhisper('updates', (details) => { console.debug(details); });
    }

    messageStartedEcho(details) {
        this.setState({
            "noticeTitle": "Progress...",
            "notice": details.notice
        });
    }

    messageCompleteEcho(details) {
        console.debug('Incoming Completed Dispatch Details', details);

        let message = details.response.message;
        if(typeof message === 'object') { message = message.reason }

        const newDetails = {
            'recipient': details.message.recipient.id,
            'message': message,
            'status': details.response.status
        };

        this.setState({ dispatchDetails: [...this.state.dispatchDetails, newDetails] });

        console.debug('Augmented Dispatch Details', this.state.dispatchDetails);
    }

    acceptableCustomers() {
        return this.state.customers.filter((customer) => {
            return customer.phone && customer.accepts_marketing;
        });
    }

    selectAllCustomers() {
        this.setState({'lastSelectionState': 'all', 'selectedRecipientIds': this.acceptableCustomers().map(function (customer) { return customer.id; })});
    }

    unSelectAllCustomers() {
        this.setState({'lastSelectionState': 'none', 'selectedRecipientIds': []});
    }

    selectedRecipients() {
        return this.state.customers.filter((customer) => {
            return this.state.selectedRecipientIds.indexOf(customer.id) !== -1;
        });
    }

    selectedRecipientsWithStatuses() {
        let recipients = this.selectedRecipients();
        return recipients.map((customer) => {
            const dispatchDetails = this.getRecipientDispatchDetails(customer.id);

            customer.dispatchStatus = dispatchDetails.length ? dispatchDetails[0].status : this.state.status;
            customer.dispatchMessage = dispatchDetails.length ? dispatchDetails[0].message : this.state.statusMessage;

            return customer;
        })
    }

    getRecipientDispatchDetails(recipientId) {
        return this.state.dispatchDetails.filter((object) => {
            return object.recipient === recipientId;
        });
    }

    clearNotices() {
        this.setState({"notice": '', "noticeTitle": "", "fieldErrors": []});
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

    changeCustomers(updated) {
        this.setState({selectedRecipientIds: updated});
    }

    sendMessage() {
        this.channel.whisper('updates', {
            title: "Sending messages..."
        });

        this.clearNotices();

        let error = false; // Because set state is slow

        if(!this.state.message) {
            error = true;
            this.setState({
                "fieldErrors": [{"field": "message", "error": "Please provide a message to send to your customers."}],
            });
        }

        if(!this.state.selectedRecipientIds.length) {
            error = true;
            this.setState(prevState => ({
                "fieldErrors": [...prevState.fieldErrors, {"field": "recipients", "error": "Please select recipients to send to."}],
            }));
        }

        if(error) return;

        this.setState({"showSendConfirmation": false});

        this.setState({
            "status": 1,
            "statusMessage": "Queueing...",
            "noticeTitle": 'Sending...',
            "notice": 'Sending your message, the status will be updated here when it completes.'
        });

        SendifySdk.sendMessage(this.state.message, this.selectedRecipients(), (response) => {
            this.setState({"showToast": true, "toastText": response.message, "status": 1, "statusMessage": "Queued"});
        });
    };

    showResetOptions() {
        this.setState({"showResetOptions": true});
    }

    showSendConfirmation() {
        this.setState({"showSendConfirmation": true});
    }

    changeMessage(value) {
        console.log(value);
        this.setState({"message": value}); this.clearFieldError("message");
    }

    getFooterAction() {
        return this.state.status ?
            {content: 'Send Another', onAction: () => this.showResetOptions()} :
            {content: 'Send', onAction: () => this.showSendConfirmation()};
    }

    render() {
        const {
            showToast,
            toastText,
            showResetOptions,
            showSendConfirmation
        } = this.state;

        if (!this.state.customers) { return <LoadingPage /> }

        const toastMarkup = showToast ? (
            <Toast
                onDismiss={() => this.setState({'showToast': false})}
                content={toastText}
            />
        ) : null;

        const resetOptionsModal = showResetOptions ? (
            <ResetOptionsModal
                onReset={() => this.reset()}
            />
        ) : null;

        const sendConfirmationModel = showSendConfirmation ? (
            <SendConfirmationModal
                message={this.state.message}
                recipientsCount={this.state.selectedRecipientIds.length}
                onSend={() => this.sendMessage()}
                onClose={() => this.setState({"showSendConfirmation": false})}

            />
        ) : null;

        console.log('REQUIRED', this.calculateRequiredCredits());

        const creditSummary = this.state.subscriptionDetails ? (
            <CreditSummary
                monthlyLmit={this.state.subscriptionDetails.message_limit}
                remaining={this.state.subscriptionDetails.usage.period_remaining}
                requiredCredits={this.calculateRequiredCredits()}
            />
        ) : null;


        const actualPageMarkup =
                <Layout>
                    <Layout.Section secondary>
                        <CustomerList
                            onChange={this.changeCustomers.bind(this)}
                            selectAllCustomers={this.selectAllCustomers.bind(this)}
                            unSelectAllCustomers={this.unSelectAllCustomers.bind(this)}
                            selected={this.state.selectedRecipientIds}
                            customers={this.acceptableCustomers()}
                            resultsPerPage={10}
                            disabled={this.state.status}
                        />
                    </Layout.Section>
                    <Layout.Section>
                        <BannerNotice
                            title={this.state.noticeTitle}
                            notice={this.state.notice}
                            onDismiss={this.clearNotices.bind(this)}
                        />
                        {creditSummary}
                        <Card primaryFooterAction={this.getFooterAction()}>
                            <Message message={this.state.message}
                                     onChange={this.changeMessage.bind(this)}
                                     error={this.getFieldErrors("message")}
                                     disabled={this.state.status}
                                     maxSingleLengthStandard={singleMessageLength}
                                     maxSingleLengthUnicode={unicodeSingleMessageLength}
                                     hasUnicode={this.messageHasUnicode()}
                            />
                            <AvailablePlaceholders />
                            <ProcessingList
                                channel={this.channel}
                                recipients={this.selectedRecipientsWithStatuses()}
                            />
                        </Card>
                    </Layout.Section>
                </Layout>;

        const pageMarkup = this.isLoading() ? <LoadingPage /> : actualPageMarkup;

        return (
                <AppProvider>
                    <Page>
                        {pageMarkup}
                        {resetOptionsModal}
                        {sendConfirmationModel}
                    </Page>
                </AppProvider>
            );
    }
}

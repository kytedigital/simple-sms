import React, { Component } from 'react';
import { Page, Layout, Card, TextStyle, PageActions } from '@shopify/polaris';
import SendifySdk from '../../services/SendifySdk';
import Message from "../../components/Message";
import LoadingPage from '../../components/LoadingPage';
import BannerNotice from "../../components/BannerNotice";
import CustomerList from "../CustomerList";
import ProcessingList from "../../components/ProcessingList";
import ResetOptionsModal from "../../components/ResetOptionsModal";
import AvailablePlaceholders from '../../components/AvailablePlaceholders';
import SendConfirmationModal from "../SendConfirmationModal";

const singleMessageLength = 160;
const unicodeSingleMessageLength = 70;

const defaultState = {
    status: 0,
    notice: "",
    message: "",
    customers: [],
    toastText: '',
    processed: [],
    processes: [],
    noticeTitle: "",
    fieldErrors: [],
    processNumber: 1,
    loadingData: true,
    dispatchDetails: [],
    bannerStatus: "info",
    processingResults: [],
    showResetOptions: false,
    statusMessage: "Pending",
    selectedRecipientIds: [],
    subscriptionDetails: null,
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
        this.setState({ loadingData: true });
        SendifySdk.getCustomers((customers) => {this.setState({"customers": customers})});
        SendifySdk.getSubscriptionDetails((details) => {this.setState({"subscriptionDetails": details, loadingData: false})});
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
        return this.state.loadingData
    }

    setEcho() {
        this.channel = window.Echo.private('shop.'+window.Sendify.shop);
    }

    getMaxSingleCharacterLength() {
        return this.messageHasUnicode() ? unicodeSingleMessageLength : singleMessageLength;
    }

    calculateMessageLength() {
        return Math.ceil(this.state.message.length / this.getMaxSingleCharacterLength());
    }

    calculateRequiredCredits() {
        return this.calculateMessageLength() * this.state.selectedRecipientIds.length;
    }

    listenToEchos() {
        this.channel.listen('MessageDispatchStarted', (details) => {this.messageStartedEcho(details);});
        this.channel.listen('MessageDispatchCompleted', (details) => {this.messageCompleteEcho(details);})
    }

    messageStartedEcho(details) {
        this.setState(state => {
            processes: state.processes.push(details)
        });

        this.setState({
            "noticeTitle": "Progress...",
            "notice": details.notice,
            'bannerStatus': "info"
        });
    }

    messageCompleteEcho(details) {
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

    acceptableCustomers() {
        // Get only valid customers
        let customers = this.state.customers.filter((customer) => {
            return customer.phone && customer.accepts_marketing;
        });

        // Add toggler function
        customers = customers.map((customer) => {
            customer.toggleSelection = () => this.toggleItemSelection(customer.id);
            return customer;
        });

        return customers;
    }

    toggleItemSelection(id) {
        let newList = this.state.selectedRecipientIds;
        this.state.selectedRecipientIds.indexOf(id) !== -1 ? delete newList[id] : newList.push(id);
        this.setState({ selectedRecipientIds: newList });
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

    changeCustomers(updated) {
        this.setState({selectedRecipientIds: updated});
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

        SendifySdk.sendMessage(this.state.message, this.selectedRecipients(), (response) => {
            this.setState({"status": 1, "statusMessage": "Queued"});
        });
    };

    validateCredit() {
        const requiredCredits = this.calculateRequiredCredits();
        if(!this.state.subscriptionDetails.usage.period_remaining > requiredCredits) {
            this.setState({
                "noticeTitle": 'Not enough credits',
                "notice": 'Sorry you need to have .' + requiredCredits + ' credits to send this message. ' +
                    'You can upgrade your plan or wait until the next billing period. If you think' +
                    'this is incorrect, please contact our support.',
                'bannerStatus': "critical"
            });

            return false;
        }

        return true;
    }

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

        if(!this.state.selectedRecipientIds.length) {
            error = true;
            this.setState(prevState => ({
                "fieldErrors": [...prevState.fieldErrors, {"field": "recipients", "error": "Please select recipients to send to."}],
                "noticeTitle": 'Missing Details',
                "notice": 'Please add recipients to send to.',
                'bannerStatus': "warning"
            }));
        }

        return !error;
    }

    readyToSend() {
        return this.state.message && this.state.selectedRecipientIds.length;
    }

    showResetOptions() {
        this.setState({"showResetOptions": true});
    }

    showSendConfirmation() {
        if(!this.validateFields() || !this.validateCredit()) {
            window.scrollTo(0, 0);
            return false;
        }

        this.setState({"showSendConfirmation": true});
    }

    changeMessage(value) {
        this.setState({"message": value}); this.clearFieldError("message");
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

        if (this.state.loadingData) { return <LoadingPage /> }

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
                     secondaryActions={[{
                         content: 'Open Message Logs',
                         onAction: () => this.props.history.push('/log')
                     }]}
                >
                    {pageMarkup}
                    {resetOptionsModal}
                    {sendConfirmationModel}
                    {pageActions}
                </Page>;
    }
}

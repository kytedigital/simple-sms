import React, { Component } from 'react';
import {AppProvider, Page, Layout, Card, Banner, Pagination} from '@shopify/polaris';
import SendifySdk from '../services/SendifySdk';
import AvailablePlaceholders from './AvailablePlaceholders';
import RecipientsList from "./RecipientsList";
import BannerNotice from "./BannerNotice";
import CustomerList from "./CustomerList";
import LoadingPage from './LoadingPage';
import Message from "./Message";
import ProcessingList from "./ProcessingList";

export default class Dashboard extends Component {
    constructor(props) {
        super(props);

        this.state = {
            customers: [],
            selectedRecipientIds: [],
            message: "",
            phoneNumber: "",
            noticeTitle: "",
            notice: "",
            dispatchDetails: [],
            status: 0,
            statusMessage: "Pending",
            fieldErrors: [],
            showTestingBanner: true,
            showMissingPeopleBanner: true
        };

        this.setEcho();
        this.listenToEchos()
    }

    setEcho() {
        this.channel = window.Echo.private('shop.'+this.props.shop);
    }

    listenToEchos() {
        console.debug('Subscribing to private-shop.'+this.props.shop);
        this.channel.listen('MessageDispatchCompleted', (details) => {this.messageCompleteEcho(details);})
        this.channel.listen('MessageDispatchStarted', (details) => {this.messageStartedEcho(details);})
        this.channel.listenForWhisper('updates', (details) => { console.debug(details); });
    }

    messageStartedEcho(details) {
        console.debug('Incoming Starting Dispatch Details', details);

        this.setState({
            "noticeTitle": "Progress...",
            "notice": details.notice
        });

        console.debug('Augmented Dispatch Details', this.state.dispatchDetails);
    }

    messageCompleteEcho(details) {
        console.debug('Incoming Completed Dispatch Details', details);

        const newDetails = {
                'recipient': details.message.recipient.id,
                'message': details.response.message,
                'status': details.response.status
            };

        this.setState({
            dispatchDetails: [...this.state.dispatchDetails, newDetails]
        });

        console.debug('Augmented Dispatch Details', this.state.dispatchDetails);
    }

    acceptableCustomers() {
        console.log('Dashboard customers', this.state.customers);
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

    componentWillMount() {
        SendifySdk.getCustomers((customers) => {this.setState({"customers": customers})});
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

        this.setState({
            "status": 1,
            "statusMessage": "Queueing...",
            "noticeTitle": 'Sending...',
            "notice": 'Sending your message, the status will be updated here when it completes.'
        });

        SendifySdk.sendMessage(this.state.message, this.selectedRecipients(), (response) => {
            let title = response.status === 200 ? 'Success' : 'Oops, a problem occurred.';
            this.setState({"noticeTitle": title, "notice": response.message, "status": 1, "statusMessage": "Queued"});
        });
    };

    changeMessage(value) {
        this.setState({"message": value}); this.clearFieldError("message");
    }

    getFooterAction() {
        console.log('w=stats', this.state.status )
        return this.state.status ? null : {content: 'Send', onAction: () => this.sendMessage()};
    }

    render() {
        if (!this.state.customers) { return <LoadingPage /> }

        return <AppProvider>
                <Page>
                    <Layout>
                        <Layout.Section secondary >
                            <CustomerList
                                onChange={this.changeCustomers.bind(this)}
                                selectAllCustomers={this.selectAllCustomers.bind(this)}
                                unSelectAllCustomers={this.unSelectAllCustomers.bind(this)}
                                selected={this.state.selectedRecipientIds}
                                customers={this.acceptableCustomers()}
                                resultsPerPage={10}
                                disabled={this.state.status}
                            />
                            {(this.state.showMissingPeopleBanner) &&
                                <div>
                                   <br />
                                    <Banner
                                        title="Someone missing?"
                                        status="informational"
                                        action={{content: 'Ok, got it!', onAction: () => this.setState({'showMissingPeopleBanner': false}) }}
                                        onDismiss={() => this.setState({'showMissingPeopleBanner': false})}
                                    >
                                        <div>
                                            <p>The customer list will only include customers who have opted to accept
                                                marketing and who have a phone number set in their Shopify profile.</p>
                                        </div>
                                    </Banner>
                                 </div>
                            }
                        </Layout.Section>
                        <Layout.Section>
                            <BannerNotice
                                title={this.state.noticeTitle}
                                notice={this.state.notice}
                                onDismiss={this.clearNotices.bind(this)}
                            />
                            <Card primaryFooterAction={this.getFooterAction()}>
                                <Message message={this.state.message}
                                         onChange={this.changeMessage.bind(this)}
                                         error={this.getFieldErrors("message")}
                                         disabled={this.state.status}
                                />
                                <AvailablePlaceholders />
                                <ProcessingList channel={this.channel} recipients={this.selectedRecipientsWithStatuses()} />
                                {/*<RecipientsList recipients={this.selectedRecipientsWithStatuses()} />*/}
                            </Card>
                            {(this.state.showTestingBanner) &&
                                <div>
                                <br />
                                    <Banner
                                        title="How to test your message"
                                        status="informational"
                                        action={{content: 'Add yourself as a customer', onAction: () => console.log('/admin/customers/new')}}
                                        onDismiss={() => this.setState({'showTestingBanner': false})}
                                    >
                                        <div>
                                             <p>It is important to test your message with you own phone before you send it to others.
                                            The best way to achieve this is to add yourself as a customer, reload the app and then send it
                                                 to the customer you added.</p>
                                            <p>Once you are happy with how your message looks, add the rest of your customers and press send.</p>
                                        </div>
                                    </Banner>
                                </div>
                            }

                        </Layout.Section>
                    </Layout>
                </Page>
            </AppProvider>;
    }
}

import React, { Component } from 'react';
import { AppProvider, Page, Layout, TextField, Card, TextStyle } from '@shopify/polaris';
import SendifySdk from '../services/SendifySdk';
import AvailablePlaceholders from './AvailablePlaceholders';
import LoadingPage from './LoadingPage';
import RecipientsList from "./RecipientsList";
import BannerNotice from "./BannerNotice";
import CustomerList from "./CustomerList";
import TestNumber from "./TestNumber";

export default class Dashboard extends Component {
    constructor(props) {
        super(props);

        this.state = {
            "customers": [],
            "selectedRecipientIds": [],
            "message": "",
            "phoneNumber": "",
            "noticeTitle": "",
            "notice": "",
            "dispatchDetails": [],
            "status": 0,
            "statusMessage": "Pending"
        };

        this.listenToEchos()
    }

    listenToEchos() {
        window.Echo.private('shop.'+window.Sendify.shop)
                    .listen('MessageDispatchCompleted', (details) => {this.messageCompleteEcho(details);});
    }

    messageCompleteEcho(details) {
        const newDetails = {
                'recipient': details.message.recipient.id,
                'message': details.message.responseMessage,
                'status': details.message.status
            };

        this.setState({
            dispatchDetails: [...this.state.dispatchDetails, newDetails]
        });
    }

    customersAsOptions() {
        let customers = this.state.customers.filter((customer) => {
            return customer.phone && customer.accepts_marketing;
        });

        return customers.map((customer) => {
            return {'value': customer.id, 'label': `${customer.first_name} ${customer.last_name} (${customer.phone})`};
        });
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

            console.log(customer);

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
        this.setState({'notice': '', 'noticeTitle': ''});
    }

    changeCustomers(updated) {
        this.setState({selectedRecipientIds: updated});
    }

    sendMessage(testMode = false) {
        if(!this.state.message) {
            this.setState({"noticeTitle": 'Missing Details', "notice": 'Please add a message to send'});
            return;
        }

        if(testMode && !this.state.phoneNumber) {
            this.setState({"noticeTitle": 'Missing Details', "notice": 'Please add a test number to target..'});
            return;
        }

        if(!testMode && !this.state.selectedRecipientIds.length) {
            this.setState({"noticeTitle": 'Missing Details', "notice": 'Please add recipients to send to.'});
            return;
        }

        this.setState({
            "status": 1,
            "noticeTitle": 'Sending...',
            "notice": 'Sending your message, the status will be updated here when it completes.'
        });

        let recipients = [];
        if(!testMode) {
            recipients = this.selectedRecipients();
        } else {
            recipients = [{"first_name": "Testy", "last_name": "Testerson", "phone": this.state.phoneNumber}];
        }

        SendifySdk.sendMessage(this.state.message, recipients, (response) => {
            let title = response.status === 200 ? 'Success' : 'Oops, a problem occurred.';
            this.setState({"noticeTitle": title, "notice": response.message, "status": response.status});
        });
    };

    changeTestNumber(number) {
        this.setState({"phoneNumber": number})
    }

    render() {
        if (!this.state.customers) {
            return <LoadingPage />
        }

        return <AppProvider>
                <Page
                    breadcrumbs={[{content: 'Apps', url: '/admin'}]}
                    title="SMS Service"
                >
                    <Layout>
                        <Layout.Section secondary>
                            <TestNumber number={this.state.phoneNumber} onChange={this.changeTestNumber.bind(this)} />
                            <Card title={`Available Customers (${this.state.customers.length})`} actions={[{content: 'Select All'}]}>
                                <Card.Section>
                                    <CustomerList
                                        onChange={this.changeCustomers.bind(this)}
                                        options={this.customersAsOptions()}
                                        selected={this.state.selectedRecipientIds}
                                        customers={this.state.customers}
                                    />
                                </Card.Section>
                            </Card>
                        </Layout.Section>
                        <Layout.Section>
                            <BannerNotice
                                title={this.state.noticeTitle}
                                notice={this.state.notice}
                                onDismiss={this.clearNotices.bind(this)}
                            />
                            <Card secondaryFooterAction={{content: 'Send Test', onAction: () => this.sendMessage(true)}}
                                  primaryFooterAction={{content: 'Send', onAction: () => this.sendMessage()}}
                            >
                                <Card.Section>
                                    <TextField name={'message'}
                                               label={"Your message to customers:"}
                                               multiline
                                               placeholder="e.g. Hi {first_name}, just to let you know, {store} are
                                                            having a massive 20% off sale this weekend.
                                                            Use code WEEKENDSAVINGS to claim your discount."
                                               value={this.state.message}
                                               onChange={(value) => this.setState({message: value})}
                                    />
                                </Card.Section>
                                <AvailablePlaceholders />
                                <RecipientsList recipients={this.selectedRecipientsWithStatuses()} />
                            </Card>
                        </Layout.Section>
                    </Layout>
                </Page>
            </AppProvider>;
    }
}

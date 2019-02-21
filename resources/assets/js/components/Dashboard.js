import React, { Component } from 'react';
import { AppProvider, Page, Layout, TextField, Button, Card, ResourceList, OptionList, Avatar, TextStyle, Banner } from '@shopify/polaris';
import SendifySdk from '../services/SendifySdk';
import LoadingPage from './LoadingPage';

export default class Dashboard extends Component {
    constructor(props) {
        super(props);

        this.state = {
            "customers": [],
            "selectedRecipientIds": [],
            "message": "",
            "phoneNumber": "",
            "noticeTitle": "",
            "notice": ""
        };
    }

    customersAsOptions() {
        return this.state.customers.map((customer) => {
            return {'value': customer.id, 'label': `${customer.first_name} ${customer.last_name} (${customer.phone})`};
        });
    }

    selectedRecipients() {
        return this.state.customers.filter((customer) => {
            return this.state.selectedRecipientIds.indexOf(customer.id) !== -1;
        });
    }

    componentWillMount() {
        SendifySdk.getCustomers((customers) => {this.setState({"customers": customers})});
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

        this.setState({"noticeTitle": 'Sending...', "notice": 'Sending your message, the status will be updated here when it completes.'});

        let recipients = [];
        if(!testMode) {
            recipients = this.selectedRecipients();
        } else {
            recipients = [{"first_name": "Testy", "last_name": "Testerson", "phone": this.state.phoneNumber}];
        }

        SendifySdk.sendMessage(this.state.message, recipients, (response) => {
            let title = response.status === 200 ? 'Sent!' : 'Oops, a problem occurred.';
            console.log(response);
            this.setState({"noticeTitle": title, "notice": response.message});
        });
    };

    render() {
        if (!this.state.customers) {
            return <LoadingPage />
        }

        let notice = '';
        if(this.state.notice) {
            notice = (<Banner title={this.state.noticeTitle} onDismiss={() => {this.setState({'notice': ''})}}>
                {this.state.notice}
            </Banner>);
        }

        let customers = '';
        if(this.state.customers.length) {
            customers = <OptionList
                onChange={(updated) => {this.setState({selectedRecipientIds: updated});}}
                options={this.customersAsOptions()}
                selected={this.state.selectedRecipientIds}
                allowMultiple
            />
        } else {
            customers = "Loading..."
        }

        return <AppProvider>
                <Page
                    breadcrumbs={[{content: 'Apps', url: '/admin'}]}
                    title="SMS Service"
                >
                    <Layout>
                        <Layout.Section secondary>
                            <Card title={`Test Number`}>
                                <Card.Section>
                                    <TextField
                                        label="Phone"
                                        type="phone"
                                        helpText={
                                            <span>Phone number for message tests.</span>
                                        }
                                        value={this.state.phoneNumber}
                                        onChange={(value) => this.setState({phoneNumber: value})}
                                    />
                                </Card.Section>
                            </Card>
                            <Card title={`Available Customers (${this.state.customers.length})`} actions={[{content: 'Select All'}]}>
                                <Card.Section>
                                    {customers}
                                </Card.Section>
                            </Card>
                        </Layout.Section>
                        <Layout.Section>
                            {notice}
                            <Card title="Prepare to send..."
                                  secondaryFooterAction={{content: 'Send Test', onAction: () => this.sendMessage(true) }}
                                  primaryFooterAction={{content: 'Send', onAction: () => this.sendMessage() }}
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
                                <Card.Section>
                                    <TextStyle variation="subdued">Available placeholders: </TextStyle>
                                </Card.Section>
                                <Card.Section>
                                    <TextStyle variation="subdued">{this.state.selectedRecipientIds.length} recipients selected</TextStyle>
                                </Card.Section>
                                <Card.Section title="Recipients">
                                    <ResourceList
                                        resourceName={{singular: 'customer', plural: 'customers'}}
                                        items={this.selectedRecipients()}
                                        renderItem={(item) => {
                                            const {id, first_name, last_name, phone} = item;
                                            const media = <Avatar customer size="medium" name={`${first_name} ${last_name}`} />;
                                            return (
                                                <ResourceList.Item
                                                    id={id}
                                                    url={`/admin/customers/` + id}
                                                    media={media}
                                                    accessibilityLabel={`View details for ${first_name} ${last_name}`}
                                                >
                                                    <h3>
                                                        <TextStyle variation="strong">{first_name} {last_name}</TextStyle>
                                                    </h3>
                                                    <div>{phone}</div>
                                                </ResourceList.Item>
                                            );
                                        }}
                                    />
                                </Card.Section>
                            </Card>
                        </Layout.Section>
                    </Layout>
                </Page>
            </AppProvider>;
    }
}

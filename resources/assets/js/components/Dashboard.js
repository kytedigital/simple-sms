import React, { Component } from 'react';
import { AppProvider, Page, Layout, TextField, Button, Card, ResourceList, Avatar, TextStyle, Banner } from '@shopify/polaris';
import SendifySdk from '../services/SendifySdk';
import LoadingPage from './LoadingPage';

export default class Dashboard extends Component {

    constructor(props) {
        super(props);

        this.state = {
            "customers": [],
            "recipients": [],
            "message": "",
            "phoneNumber": "",
            "noticeTitle": "",
            "notice": ""
        };
    }

    componentWillMount() {
        SendifySdk.getCustomers((response) => { this.setState({ "customers": response }); });
    }

    sendMessage(field) {
        // TODO: Validation?
        let message = this.state.message;
        let phone = this.state.phoneNumber;
        let recipients = [{ "first_name": "Testy", "last_name": "Testerson", "phone": phone }];

        console.log(recipients);

        SendifySdk.sendMessage(message, recipients, (response) => {
            this.setState({ "noticeTitle": "Sent!", "notice": response });
        });

        console.log(message);
        console.log(field);
    };

    render() {

        console.log('customers', this.state);

        if (!this.state.customers.items) {
            return <LoadingPage />
        }

        let notice = '';
        if(this.state.notice) {
            notice = (<Banner title={this.state.noticeTitle} onDismiss={ () => {this.setState({'notice': ''})} }>
                        <p>{this.state.notice}</p>
                     </Banner>);
        }

        return <AppProvider>
                <Page
                    breadcrumbs={[{content: 'Apps', url: '/admin'}]}
                    title="SMS Service"
                >
                    <Layout>
                        <Layout.Section secondary>
                            <Card title="Available Customers" actions={[{content: 'choose'}]}>
                                <Card.Section>
                                    <TextStyle variation="subdued">{this.state.customers.items.length} customers available</TextStyle>
                                </Card.Section>
                                <Card.Section title="People">
                                    <ResourceList
                                        resourceName={{singular: 'customer', plural: 'customers'}}
                                        items={this.state.customers.items}
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
                        <Layout.Section>
                            <Card title="Prepare to send..." actions={[{content: 'choose'}]}>
                                {notice}
                                <Card.Section title="Your Message">
                                    <TextField name={'message'}
                                               label={"Message to send"}
                                               multiline
                                               placeholder="e.g. Hi {first_name}, just to let you know, {store} are
                                                            having a massive 20% off sale this weekend.
                                                            Use code WEEKENDSAVINGS to claim your discount."
                                               value={this.state.message}
                                               onChange={(value) => this.setState({ message: value })}
                                    />
                                </Card.Section>
                                <Card.Section>
                                    <TextStyle variation="subdued">Available placeholders: </TextStyle>
                                </Card.Section>
                                <Card.Section>
                                    <TextStyle variation="subdued">{ this.state.recipients.length } recipients selected</TextStyle>
                                </Card.Section>
                                <Card.Section title="Recipients">
                                    <ResourceList
                                        resourceName={{singular: 'customer', plural: 'customers'}}
                                        items={this.state.recipients}
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
                                <Card.Section>
                                    <TextStyle variation="subdued">Test and Send</TextStyle>
                                </Card.Section>
                                <Card.Section title="Recipients">
                                    <TextField
                                        label="Phone"
                                        type="phone"
                                        helpText={
                                            <span>Send a single message to this test number.</span>
                                        }
                                        value={this.state.phoneNumber}
                                        onChange={(value) => this.setState({ phoneNumber: value })}
                                    />
                                    <Button onClick={() => this.sendMessage()}>Send single test recipient.</Button><br/>
                                    <Button primary onClick={() => this.sendMessage()}>SEND TO CUSTOMERS</Button>
                                </Card.Section>
                            </Card>
                        </Layout.Section>
                    </Layout>
                </Page>
            </AppProvider>;
    }
}

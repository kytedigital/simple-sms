import React, { Component } from 'react';
import { AppProvider, Page, Button, TextField } from '@shopify/polaris';
import SendifySdk from '../services/SendifySdk';

export default class Dashboard extends Component {
    constructor(props) {
        super(props);

        this.state = {
            'results': []
        };
    }

    getCustomers() {
        SendifySdk.getCustomers((response) => {
            console.log(response);

            this.setState({
                'results': JSON.stringify()
            });
        });
    }

    sendMessage(field) {
        console.log(field); console.log(value);
    };

    render() {
        var { results } = this.state;
        var phone = '00000000';

        return <AppProvider>
                <Page
                    breadcrumbs={[{content: 'Apps', url: '/admin'}]}
                    title="Message Customers"
                >
                    <Button onClick={() => this.getCustomers()}>Get Customers</Button>

                    <div id="result">
                        { results }
                    </div>

                    <Button onClick={() => this.sendMessage()}>Send A Message</Button>

                    <TextField
                        value={phone}
                        label="Phone"
                        type="phone"
                        helpText={
                            <span>
                                Send a message to this phone number.
                            </span>
                        }
                    />

                </Page>
            </AppProvider>;
    }
}

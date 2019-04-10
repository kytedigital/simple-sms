import React, { Component } from 'react';
import {Card, TextField} from '@shopify/polaris';

export default class Message extends Component {
    render() {
        console.log('Message Disabled', this.props.disabled)
        return <Card.Section>
                <TextField name={'message'}
                           label={"Your message to customers:"}
                           multiline
                           placeholder="e.g. Hi {first_name}, just to let you know, {store} are
                                                            having a massive 20% off sale this weekend.
                                                            Use code WEEKENDSAVINGS to claim your discount."
                           value={this.props.message}
                           onChange={this.props.onChange}
                           error={this.props.error}
                           readOnly={this.props.disabled}
                           disabled={this.props.disabled}
            />
            </Card.Section>
    }
}

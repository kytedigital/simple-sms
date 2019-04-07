import React, { Component } from 'react';
import {Card, TextField} from '@shopify/polaris';

export default class TestNumber extends Component {
    render() {
        return <Card>
            <Card.Section>
                <TextField
                    label="Test Mobile Number"
                    type="phone"
                    helpText={
                        <span>(optional) phone number for test messages.</span>
                    }
                    value={this.props.number}
                    onChange={(value) => this.props.onChange(value)}
                    readOnly={false}
                    placeholder={"+61 4000 000 00"}
                    error={this.props.error}
                />
            </Card.Section>
        </Card>
    }
}

import React, { Component } from 'react';
import {Card, TextField} from '@shopify/polaris';

export default class TestNumber extends Component {
    render() {
        return <Card title={`Test Number`}>
            <Card.Section>
                <TextField
                    label="Phone"
                    type="phone"
                    helpText={
                        <span>Phone number for message tests.</span>
                    }
                    value={this.props.number}
                    onChange={(value) => this.props.onChange(value)}
                    readOnly={false}
                />
            </Card.Section>
        </Card>
    }
}

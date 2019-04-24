import React, { Component } from 'react';
import { Card, DataTable } from '@shopify/polaris';
import './message.css';

export default class CreditSummary extends Component {
    render() {
        const rows = [
            [this.props.monthlyLmit, this.props.remaining, this.props.requiredCredits],
        ];

        return <Card>
                    <DataTable
                        columnContentTypes={[
                            'text',
                            'text',
                            'text',
                        ]}
                        headings={[
                            'Monthly',
                            'Remaining',
                            'Required',
                        ]}
                        rows={rows}
                    />
                </Card>
    }
}

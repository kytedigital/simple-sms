import React, { Component } from 'react';
import { Card, DataTable } from '@shopify/polaris';
import '../components/message.css';

export default class ProcessingStats extends Component {
    getFailedProcesses() {
        if(!this.props.processed.length) return 0;
        return this.props.processed.filter(item => (item.response.status === 500 && item.response.message.reason !== "Number has opted-out"));
    }
    getOptOutProcesses() {
        if(!this.props.processed.length) return 0;
        return this.props.processed.filter(item => {
            return item.response.status === 500 && item.response.message.reason === "Number has opted-out"
        });
    }
    render() {
        const rows = [
            [
                this.props.queuedItemsCount,
                this.props.processed.length,
                this.getOptOutProcesses().length,
                this.getFailedProcesses().length
            ],
        ];

        return <Card>
                <DataTable
                        columnContentTypes={[
                            'text',
                            'text',
                            'text',
                            'text',
                        ]}
                        headings={[
                            'Queued',
                            'Processed',
                            'Opt-outs',
                            'Failures',
                        ]}
                        rows={rows}
                    />
            </Card>
    }
}

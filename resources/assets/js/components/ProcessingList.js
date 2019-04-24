import React, { Component } from 'react';
import {Avatar, Card, ResourceList, TextStyle} from '@shopify/polaris';
import MessageStatusBadge from "./MessageStatusBadge";

export default class ProcessingList extends Component {
    constructor(props) {
        super(props);

        this.state = {
            processes: [],
        };

        this.listenToEchos()
    }

    listenToEchos() {
        this.props.channel.listen('MessageDispatchStarted', (details) => { this.startProcess(details) });
        this.props.channel.listen('MessageDispatchCompleted', (details) => { this.completeProcess(details); })
    }

    startProcess(details) {
        this.setState(state => {
            processes: state.processes.push(details)
        });
    }

    completeProcess(details) {
        // Wait 2 seconds
        setTimeout(() => {
           if(this.state.processes.length < 5) return;

            this.setState(state => {
                const cleanedProcessList = state.processes.filter((item) => {
                    return item.message.recipient.id !== details.message.recipient.id;
                });

                return { processes: cleanedProcessList };
            });
        }, 4000);
    }

    getProcessingRecipientIds() {
        return this.state.processes.map(process => process.message.recipient.id);
    }

    extractProcessingRecipientsFromStatusList() {
        const processingRecipientIds = this.getProcessingRecipientIds();
        return this.props.recipients.filter(recipient => processingRecipientIds.indexOf(recipient.id) !== -1);
    }

    render() {
        return <div>
            <Card.Section>
                <TextStyle variation="subdued">{this.props.recipients.length} recipients selected</TextStyle>
            </Card.Section>
            <Card.Section>
                <ResourceList
                    resourceName={{singular: 'customer', plural: 'customers'}}
                    items={this.extractProcessingRecipientsFromStatusList()}
                    renderItem={(item => {
                        const {id, first_name, last_name, phone, dispatchStatus, dispatchMessage} = item;
                        const media = <Avatar customer size="medium" name={`${first_name} ${last_name}`} />;
                        return (
                            <ResourceList.Item
                                id={id}
                                url={`/admin/customers/` + id}
                                media={media}
                                accessibilityLabel={`View details for ${first_name} ${last_name}`}
                                style={{transition: "0.5s", animation: "fadeOut 500ms"}}
                            >
                                <h3>
                                    <TextStyle variation="strong">{first_name} {last_name}</TextStyle>
                                </h3>
                                <div>{phone}</div>
                                <MessageStatusBadge status={dispatchStatus} message={dispatchMessage} />
                            </ResourceList.Item>
                        );
                    })}
                />
            </Card.Section>
        </div>
    }
}

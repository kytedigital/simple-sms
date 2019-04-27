import React, { Component } from 'react';
import {Avatar, Card, ResourceList, TextStyle} from '@shopify/polaris';
import MessageStatusBadge from "./MessageStatusBadge";
import ProcessingStats from "./ProcessingStats";

export default class ProcessingList extends Component {
    constructor(props) {
        super(props);

        this.state = {
            processes: [],
            processed: []
        };
    }

    componentWillMount() {
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

        this.setState(state => {
            processed: state.processed.push(details)
        });

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
        const processSummary = this.props.sending ? (
            <ProcessingStats
                queuedItemsCount={this.props.recipients.length}
                processed={this.state.processed}
            />
        ) : null;

        const processingItems = this.extractProcessingRecipientsFromStatusList();

        return <div>
                {processSummary}
                <Card>
                    <Card.Section style={{paddingTop: 0}}>
                        <ResourceList
                            resourceName={{singular: 'process', plural: 'processes'}}
                            items={processingItems}
                            loading={this.props.sending && !processingItems.length}
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
                                        <h3><TextStyle variation="strong">{first_name} {last_name}</TextStyle></h3>
                                        <div>{phone}</div>
                                        {/*<div>{"+614XXXXXXXX"}</div>*/}
                                        <MessageStatusBadge status={dispatchStatus} message={dispatchMessage} />
                                    </ResourceList.Item>
                                );
                            })}
                        />
                    </Card.Section>
                </Card>
        </div>
    }
}

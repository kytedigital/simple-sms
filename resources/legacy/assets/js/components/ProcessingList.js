import React, { Component } from 'react';
import {Avatar, Card, ResourceList, TextStyle} from '@shopify/polaris';
import MessageStatusBadge from "./MessageStatusBadge";
import ProcessingStats from "../containers/ProcessingStats";

export default class ProcessingList extends Component {
    getProcessingRecipientIds() {
        return this.props.processes.map(process => process.message.recipient.id);
    }

    extractProcessingRecipientsFromStatusList() {
        const processingRecipientIds = this.getProcessingRecipientIds();
        return this.props.recipients.filter(recipient => processingRecipientIds.indexOf(recipient.id) !== -1);
    }

    render() {
        const processSummary = this.props.sending ? (
            <ProcessingStats
                queuedItemsCount={this.props.recipients.length}
                processed={this.props.processed}
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

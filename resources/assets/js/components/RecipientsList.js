import React, { Component } from 'react';
import {Avatar, Card, ResourceList, TextStyle} from '@shopify/polaris';
import MessageStatusBadge from "./MessageStatusBadge";

export default class RecipientsList extends Component {
    render() {
        return <Card title={`Your Message`}>
                <Card.Section>
                    <TextStyle variation="subdued">{this.props.recipients.length} recipients selected</TextStyle>
                </Card.Section>
                <Card.Section>
                    <ResourceList
                        resourceName={{singular: 'customer', plural: 'customers'}}
                        items={this.props.recipients}
                        renderItem={(item => {
                            const {id, first_name, last_name, phone, dispatchStatus, dispatchMessage} = item;
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
                                    <MessageStatusBadge status={dispatchStatus} message={dispatchMessage} />
                                </ResourceList.Item>
                            );
                        })}
                    />
            </Card.Section>
        </Card>
    }
}

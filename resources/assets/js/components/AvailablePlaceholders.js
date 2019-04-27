import React, { Component } from 'react';
import { Card, TextStyle, Banner } from '@shopify/polaris';

export default class AvailablePlaceholders extends Component {
    render() {
        return <Card.Section>
                    <TextStyle variation="subdued">
                        <TextStyle variation="code">{`{first_name}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{last_name}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{phone}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.name}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.email}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.domain}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.province}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.country}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.address1}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.country}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.zip}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.city}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.phone}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{shop.currency}`}</TextStyle>&nbsp;
                    </TextStyle>
                    <TextStyle variation="subdued">
                        <br/>
                        <br/>
                        <Banner
                            status="info"
                        >
                            <p>Missing information in your store settings or customer data could result in
                                recipients receiving placeholders in their messages.</p>
                        </Banner>

                    </TextStyle>
                </Card.Section>
    }
}

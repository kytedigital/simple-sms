import React, { Component } from 'react';
import { Card, TextStyle, Banner } from '@shopify/polaris';

export default class AvailablePlaceholders extends Component {
    render() {
        return <Card.Section>
                    <TextStyle variation="subdued">
                        The following placeholders can be added to your message, and will be replaced with your customer's
                        information when available:<br/><br/>
                    </TextStyle>
                    <TextStyle variation="subdued">
                        <TextStyle variation="code">{`{first_name}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{last_name}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{phone}`}</TextStyle>&nbsp;
                        <TextStyle variation="code">{`{email}`}</TextStyle>&nbsp;
                    </TextStyle><br /><br />
                     Example Message: <br /><br />
                    <TextStyle variation="code">
                        Dear {`{first_name}`}, PetsCorner, Lonsdale Street here.
                        Just a quick message to let you know you can save 20% in-store this weekend on all pet food.
                        Just show this message.
                        For any further info you can contact us on example@petscorner.com.
                        To opt-out reply "STOP".
                    </TextStyle>
                    <TextStyle variation="subdued">
                        <br/>
                        <br/>
                        <Banner
                            status="info"
                        >
                            <p>
                                Be sure to identify your business and include instructions for opt out using "stop" keyword.
                                For example: <TextStyle variation="code">.. opt-out: reply "STOP".</TextStyle>
                            </p>
                        </Banner>
                    </TextStyle>
                </Card.Section>
    }
}

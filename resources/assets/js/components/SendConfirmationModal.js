import React, { Component } from 'react';
import {Modal, TextContainer, TextStyle, Heading } from '@shopify/polaris';
import MessagePreview from './MessagePreview.js';

export default class ResetOptionsModal extends React.Component {
    render() {
        return (
                <Modal
                    open={true}
                    onClose={this.props.onClose}
                    title="Send Message?"
                    primaryAction={{
                        content: 'Confirm and send.',
                        onAction: this.props.onSend,
                    }}
                    secondaryActions={[
                        {
                            content: 'Cancel',
                            onAction: this.props.onClose,
                        },
                    ]}
                >
                    <Modal.Section>
                        <TextContainer spacing="loose">
                            <Heading>Message Preview</Heading>

                            <br/>
                            <br/>

                            <MessagePreview message={this.props.message}/>

                            <br/>
                            <br/>

                            <TextStyle variation="strong">
                                You are about to send this message to {this.props.recipientsCount} recipients.<br/>
                                This will use {this.props.requiredCredits} of your message credits to send.
                            </TextStyle>

                            <br/>
                            <br/>

                            <TextStyle variation="subdued">
                                IMPORTANT: By clicking "Confirm and send." below, you confirm that you
                                have included the following in your message body, and covered any additional
                                requirements pursuant to all applicable SPAM laws in your region, and the region of the
                                recipients.

                                <ul>
                                    <li>Identification of your business (shop name / brand)</li>
                                    <li>Valid contact information</li>
                                    <li>Clear Out Instructions (E.g.
                                        <TextStyle variation="code">Opt-out: Reply "STOP"</TextStyle>
                                    </li>
                                </ul>
                            </TextStyle>
                        </TextContainer>
                    </Modal.Section>
                </Modal>
        );
    }

    handleClose() {
        this.setState(({active}) => ({
            active: !active,
        }));
    };
}
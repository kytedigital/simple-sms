import React, { Component } from 'react';
import {Modal, TextContainer } from '@shopify/polaris';

export default class ResetOptionsModal extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            active: true,
        };
    }

    render() {
        const {active} = this.state;

        return (
                <Modal
                    open={active}
                    onClose={this.handleClose}
                    title="Send Message?"
                    primaryAction={{
                        content: 'Continue',
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
                            <p>You are about to send:.</p>

                            <p>{this.props.message}</p>
                            <p>To {this.props.recipientsCount} recipients.</p>
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
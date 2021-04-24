import React, { Component } from 'react';
import {Modal} from '@shopify/polaris';

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
                    title="Send another message?"
                    primaryAction={{
                        content: 'Start again',
                        onAction: this.props.onReset,
                    }}
                    secondaryActions={[
                        {
                            content: 'Cancel',
                            onAction: this.handleClose,
                        },
                    ]}
                >
                    <Modal.Section>
                        <p>Would you like to reset everything and send a new message?
                            Your current message will keep on sending in the background.</p>
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
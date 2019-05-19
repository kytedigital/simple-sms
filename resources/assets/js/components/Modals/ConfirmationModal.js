import React, {Component} from 'react';
import {Modal, TextContainer, TextStyle, Heading } from '@shopify/polaris';

export default class ConfirmationModal extends Component {
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
                            <Heading>Confirmation</Heading>

                            <TextStyle variation="strong">
                                Information
                            </TextStyle>

                            <br/>
                            <br/>

                            <TextStyle variation="subdued">
                                By clicking "Confirm and send." below, you confirm that you have
                                ....
                                <ul>
                                    <li>...</li>
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
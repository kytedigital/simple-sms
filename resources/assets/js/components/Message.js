import React, { Component } from 'react';
import {Card, TextField} from '@shopify/polaris';
import './message.css';

export default class Message extends Component {
    getMaxSingleCharacterLength() {
        return this.props.hasUnicode ?
            this.props.maxSingleLengthUnicode :
            this.props.maxSingleLengthStandard;
    }
    getMaxCharacterLength() {
        return this.getMaxSingleCharacterLength() * 4;
    }
    getRemainingCharacters() {
        return this.getMaxCharacterLength() - this.props.message.length;
    }
    getMessageCount() {
        return Math.ceil(this.props.message.length / this.getMaxSingleCharacterLength());
    }
    updateMessageBox(value) {
        if(value.length <= this.getMaxCharacterLength()) {
            this.props.onChange(value);
        }
    }
    render() {
        const messageType = this.props.hasUnicode ? 'UTF-8 (emoji)' : 'Standard';
        return <Card.Section>
                <TextField name={'message'}
                           label={"Your message to customers:"}
                           lines={10}
                           multiline
                           placeholder='e.g. Hi {first_name}!, just to let you know, {shop.name} are
                                                            having a massive 20% off sale for existing customers this weekend.
                                                            Use code WEEKENDSAVINGS or show this message to claim your
                                                            discount.
                                                            Opt-out: reply "STOP".'
                           value={this.props.message}
                           onChange={this.updateMessageBox.bind(this)}
                           error={this.props.error}
                           readOnly={this.props.disabled}
                           disabled={this.props.disabled}
                           id={"messageInput"}
                           maxLength={this.getMaxCharacterLength()}
                           max={this.getMaxCharacterLength()}
                           helpText={
                               messageType + ' message type. ' +
                               this.getMaxSingleCharacterLength() + ' characters per message. ' +
                               this.getMessageCount() + '/4 messages used. '+
                               this.getRemainingCharacters() + '/' +this.getMaxCharacterLength()+
                               ' characters remaining.'
                           }
                />
            </Card.Section>
    }
}

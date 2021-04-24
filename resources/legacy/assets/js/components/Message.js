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
                           // label={"Your message to customers:"}
                           lines={10}
                           multiline
                           placeholder='Please enter your SMS message here...'
                           value={this.props.message}
                           onChange={this.updateMessageBox.bind(this)}
                           error={this.props.error}
                           readOnly={this.props.disabled}
                           disabled={this.props.disabled}
                           id={"messageInput"}
                           maxLength={this.getMaxCharacterLength()}
                           max={this.getMaxCharacterLength()}
                           helpText={
                               // this.getMaxSingleCharacterLength() + ' characters per message. ' +
                               // this.getMessageCount() + '/4 messages used. '+
                               this.getRemainingCharacters() + '/' +this.getMaxCharacterLength()+
                               ' characters available.'
                           }
                />
            </Card.Section>
    }
}

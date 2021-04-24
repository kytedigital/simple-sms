import React, { Component } from 'react';
import './MessagePreview.css';

export default class MessagePreview extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            active: true,
        };
    }

    exampleMessage() {
        return this.props.message
            .replace(/{first_name}/g, 'Jane')
            .replace(/{last_name}/g, 'Doe')
            .replace(/{email}/g, 'Jane@janedoe.com')
            .replace(/{phone}/g, '+44 0000 00000');
    }

    render() {
        return (
                <div id={'messagePreviewContainer'}>
                    <header>
                        <span className="left">Messages</span>
                        <h2>+61 ....</h2>
                    </header>
                    <div className="messages-wrapper">
                        <div className="message from">{this.exampleMessage()}</div>
                    </div>
                </div>
        );
    }

    handleClose() {
        this.setState(({active}) => ({
            active: !active,
        }));
    };
}

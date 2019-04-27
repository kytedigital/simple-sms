import React, { Component } from 'react';
import './MessagePreview.css';

export default class MessagePreview extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            active: true,
        };
    }

    render() {
        const { message } = this.props;

        return (
                <div id={'messagePreviewContainer'}>
                    <header>
                        <span className="left">Messages</span>
                        <h2>+61 ....</h2>
                    </header>
                    <div className="messages-wrapper">
                        <div className="message from">{message}</div>
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

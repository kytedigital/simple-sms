import React, { Component } from 'react';
import {Banner} from '@shopify/polaris';

export default class BannerNotice extends Component {
    render() {
        if(!this.props.notice) return '';
        // TODO: banner types (success)
        return <Banner title={this.props.title} onDismiss={() => this.props.onDismiss()}>
            {this.props.notice}
        </Banner>
    }
}

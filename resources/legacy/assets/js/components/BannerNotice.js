import React, { Component } from 'react';
import {Banner} from '@shopify/polaris';

export default class BannerNotice extends Component {
    render() {
        return <Banner
            title={this.props.title}
            onDismiss={() => this.props.onDismiss()}
            status={this.props.status}
        >
            {this.props.notice}
        </Banner>
    }
}

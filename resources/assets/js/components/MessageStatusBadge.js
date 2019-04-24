import React, { Component } from 'react';
import { Badge } from '@shopify/polaris';

export default class MessageStatusBadge extends Component {
    mapStatus(status) {
        if(status === 0) return 'default';
        if(status === 1) return 'default';
        if(status < 400) return 'success';
        if(status < 500) return 'attention';

        return 'warning'
    }

    mapProgress(status) {
        if(status === 0) return 'default';
        if(status === 1) return 'partiallyComplete';
        if(status > 1)   return 'complete';

        return 'default'
    }

    render() {
        let { message } = this.props; if(typeof message === 'object') { message = message.reason }
        return <Badge progress={this.mapProgress(this.props.status)} status={this.mapStatus(this.props.status)}>
            {message}
        </Badge>
    }
}

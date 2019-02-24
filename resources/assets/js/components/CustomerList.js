import React, { Component } from 'react';
import {Banner, OptionList} from '@shopify/polaris';

export default class CustomerList extends Component {
    render() {
        if(this.props.customers.length) {
            return <OptionList
                onChange={this.props.onChange}
                options={this.props.options}
                selected={this.props.selected}
                allowMultiple
            />
        } else {
            return "Loading..."
        }
    }
}

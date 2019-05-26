import React, { Component } from 'react';
import { Context } from '../../context';
import { Page, Layout, Card, TextStyle, PageActions } from '@shopify/polaris';

class Plans extends Component {
    constructor(props) {
        super(props);

        this.state = {};
    }

    componentWillMount() {
        this.fetchData();
    }

    fetchData() {
        this.setState({ loading: true });
    }

    render() {
        return (
          <h1>Plans</h1>
        );
    }
}

Plans.contextType = Context;

export default props => (
    <Context.Consumer>
        {state => <Plans context={state} />}
    </Context.Consumer>
);
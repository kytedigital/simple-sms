import React, { Component } from 'react';
import { connect } from 'react-redux'
import {Layout, Page} from '@shopify/polaris';
import SendifySdk from "../../services/SendifySdk";
import store from "../../store/index";
import * as actions from "../../actions/processes";
import ProcessList from "../ProcessList/ProcessList";

class ProcessLog extends Component {
    componentWillMount() {
        this.fetchMessageData();

        console.log(store.getState());
    }

    fetchMessageData() {
        SendifySdk.getMessageLog((process) => { 
            console.log('process', process);
            this.store.dispatch( this.props.addProcess(process) )
        });

        console.log(this.props.processes);

        console.log(store.getState());
    }

    render() {
        return <Page
            fullWidth
            title="Message Log"
            breadcrumbs={[{content: 'Message Composer', onAction: () => this.props.history.push('/') }]}
        >
            <Layout>
                <ProcessList />
            </Layout>
        </Page>
    }
}

const mapState = state => state.processes;

export default connect(mapState, actions)(ProcessLog)

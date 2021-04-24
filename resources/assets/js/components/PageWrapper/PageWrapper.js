import {connect} from 'react-redux'
import {Page} from "@shopify/polaris";
import React, {Component} from 'react';
import {withRouter} from 'react-router-dom';

class PageWrapper extends Component {
    breadcrumb() {
        // const {path, title} = this.props.navigation.previousLocation;
        // return [{
        //   content: title, url: '#'+path
        // }];
    }

    changePath(path) {
        // this.props.changePreviousLocation({
        //     path: this.props.router.hash,
        //     title: this.props.title
        // });

        this.props.history.push(path);
    }

    render() {
        console.log(this.props.location.pathname);
        return (
            <Page title={this.props.title}
                  fullWidth
                  breadcrumbs={this.breadcrumb()}
                  primaryAction={this.props.primaryAction}
                  secondaryActions={[
                      {
                          content: 'Automations',
                          onAction: () => this.changePath('/'),
                          disabled: this.props.location.pathname === '/'
                      },
                      {
                          content: 'Messenger',
                          onAction: () => this.changePath('messenger'),
                          disabled: this.props.location.pathname === '/messenger'
                      },
                      {
                          content: 'History',
                          onAction: () => this.changePath('history'),
                          disabled: this.props.location.pathname === '/history'
                      },
                      {
                          content: 'Balance',
                          onAction: () => this.changePath('balance'),
                          disabled: this.props.location.pathname === '/balance'
                      },
                      {
                          content: 'Plans',
                          onAction: () => this.changePath('plans'),
                          disabled: this.props.location.pathname === '/plans'
                      }
                  ]}
            >
                {this.props.children}
            </Page>
        );
    }
}

function mapStateToProps(state) {
    return { router: state.router }
}

export default connect(mapStateToProps)(withRouter(PageWrapper));

import React from 'react';
import {ResourceList, TextStyle, Pagination, Avatar, Card} from '@shopify/polaris';
import './customerList.css';

export default class CustomerList extends React.Component {
    constructor(props) {
        super(props);
        
        this.state = {
            order: 'ASC',
            currentPage: 1,
            searchValue: '',
            sortOn: 'last_name',
            lastSelectionState: "none",
            count: this.props.customers.length,
            maxPageNumber: Math.ceil(this.props.customers.length / this.props.resultsPerPage),
        };
    };

    /**
     * Because often the customers list is empty on first load and this component still needs to mount to show it's
     * pretty empty state.
     *
     * @param props
     * @param state
     */
    static getDerivedStateFromProps(props, state) {
        return {
            count: props.customers.length,
            maxPageNumber: Math.ceil(props.customers.length / props.resultsPerPage)
        };
    };

    getResults() {
        if(this.state.searchValue.length) {
            return this.filteredList();
        }

        return this.getPageResults();
    }

    getPageResults() {
        const base0 = this.state.currentPage - 1;
        const offset = base0 * this.props.resultsPerPage;
        return CustomerList.sortList(
            this.props.customers.slice(offset, offset + this.props.resultsPerPage)
        );
    };

    static sortList(input) {
         input.sort(function(a, b) {
            return a['last_name'] > b['last_name'];
        });
        return input;
    };

    handleSearchChange(searchValue) {
        this.setState({searchValue});
    };

    filteredList() {
        if(!this.state.searchValue.length) return this.props.customers;

        return this.props.customers.filter(customer =>
            Object.keys(customer).some(key => {
                 if(typeof customer[key] === "string") {
                     return customer[key].toLowerCase().indexOf(this.state.searchValue.toLowerCase()) > -1
                 }
                 else return customer[key] == this.state.searchValue
            })
        );
    };

    previousPage() {
        this.setState((state) => {
            const currentPage = (state.currentPage - 1) < 0 ? 0 : state.currentPage - 1;
            return { currentPage };
        });
    };

    nextPage() {
        let nextPage = this.state.currentPage + 1;

        nextPage = nextPage > this.state.maxPageNumber ? this.state.maxPageNumber : nextPage;

        this.setState({ currentPage: nextPage });
    };

    getSelectionAction() {
        return this.state.lastSelectionState === 'none' ?
            { content: 'Select all '+this.state.count+' customers in your store', onAction: () => this.selectAllCustomers() } :
            { content: 'Unselect '+this.props.selected.length+' customers', onAction: () => this.unSelectAllCustomers() }
    }

    selectAllCustomers() {
        this.setState({ lastSelectionState: 'all' });
        this.props.selectAllCustomers()
    }

    unSelectAllCustomers() {
        this.setState({ lastSelectionState: 'none' });
        this.props.unSelectAllCustomers()
    }

    paginationHasPrevious() {
        return this.state.currentPage > 1;
    }

    paginationHasNext() {
        return this.state.currentPage < this.state.maxPageNumber;
    }

    renderItem(item) {
        const {id, first_name, last_name, phone, email, toggleSelection} = item;
        
        const media = <Avatar customer size="medium" name={first_name + ' '+last_name} />;

        return (
            <ResourceList.Item
                id={id}
                accessibilityLabel={`Click to add ${first_name} ${last_name} to recipients list.`}
                persistActions
                onClick={toggleSelection}
                media={media}
            >
                <h3>
                    <TextStyle variation="strong">{first_name} {last_name}</TextStyle>
                </h3>
                <div>{phone}</div>
                <div>{email}</div>
            </ResourceList.Item>
        );
    };

    render() {
        const resourceName = {
            singular: 'customer',
            plural: 'customers',
        };

        const promotedBulkActions = [
            {
                content: '',
                onAction: () => console.log(''),
            },
        ];

        const bulkActions = [

        ];

        const filterControl = (
            <ResourceList.FilterControl
                context={"Search customers"}
                searchValue={this.state.searchValue}
                onSearchChange={(value) => this.handleSearchChange(value)}
            />
        );

        const results = this.getResults();

        const pagination = results.length ? (
            <div style={{display: 'flex', justifyContent: 'center', margin: '20px'}}>
                <Pagination hasPrevious={this.paginationHasPrevious()}
                            onPrevious={() => { this.previousPage(); }}
                            hasNext={this.paginationHasNext()}
                            onNext={() => { this.nextPage(); }}
                />
            </div>
        ) : null;

        return (
            <Card title={`Step 1 - Select Customers`} actions={[this.getSelectionAction()]}>
                <div style={{ borderBottom: '.1rem solid #dfe3e8' }}>
                    {/*<div style={{ paddingLeft: '20px' }}>*/}
                        {/*<TextStyle variation="subdued">*/}
                            {/*<br />*/}
                            {/*Select from individual customers below, or "Select all.." above.*/}
                        {/*</TextStyle>*/}
                    {/*</div>*/}
                    <ResourceList
                        resourceName={resourceName}
                        items={results}
                        renderItem={this.renderItem}
                        selectedItems={this.props.selected}
                        onSelectionChange={this.props.onChange}
                        promotedBulkActions={!this.props.disabled ? promotedBulkActions : null}
                        bulkActions={!this.props.disabled ? bulkActions : null}
                        loadingData={this.props.loadingData}
                        hasMoreItems={true}
                        showHeader={true}
                        filterControl={filterControl}
                        sortOptions={null}
                    />
                </div>
                {pagination}
            </Card>
        );
    }
}

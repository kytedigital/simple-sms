import React from 'react';
import {ResourceList, TextStyle, Pagination, Card} from '@shopify/polaris';

export default class CustomerList extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            sortOn: 'last_name',
            order: 'ASC',
            currentPage: 0,
            searchValue: '',
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

    getPageResults() {
        const offset = this.state.currentPage * this.props.resultsPerPage;
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
        console.log('On Previous');
        this.setState((state) => {
            const currentPage = (state.currentPage - 1) < 0 ? 0 : state.currentPage - 1;
            return { currentPage };
        });
    };

    nextPage() {
        console.log('On Next');
        this.setState((state) => {
            const currentPage = (state.currentPage + 1) > state.maxPageNumber ? state.maxPageNumber : state.currentPage + 1;
            return { currentPage };
        });
    };

    getSelectionAction() {
        return this.state.lastSelectionState === 'none' ?
            {  content: 'Select all '+this.state.count+' customers in your store', onAction: () => this.props.selectAllCustomers() } :
            {  content: 'Unselect '+this.props.selected.length+' customers', onAction: () => this.props.unSelectAllCustomers() }
    }

    renderItem(item) {
        const {id, first_name, last_name, phone} = item;

        return (
            <ResourceList.Item
                id={id}
                accessibilityLabel={`Add ${first_name} ${last_name} to recipients list.`}
                persistActions
            >
                <h3>
                    <TextStyle variation="strong">{first_name} {last_name}</TextStyle>
                </h3>
                <div><TextStyle variation="accent">{phone}</TextStyle></div>
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
                content: 'Add tags',
                onAction: () => console.log('Todo: implement bulk add tags'),
            },
        ];

        const bulkActions = [
            {
                content: 'Add tags',
                onAction: () => console.log('Todo: implement bulk add tags'),
            },
            {
                content: 'Remove tags',
                onAction: () => console.log('Todo: implement bulk remove tags'),
            },
            {
                content: 'Delete customers',
                onAction: () => console.log('Todo: implement bulk delete'),
            },
        ];

        const filterControl = (
            <ResourceList.FilterControl
                context={"Search customers"}
                searchValue={this.state.searchValue}
                onSearchChange={(value) => this.handleSearchChange(value)}
            />
        );

        return (
            <Card title={`Available Customers`} actions={[this.getSelectionAction()]}>
                <div style={{ borderBottom: '.1rem solid #dfe3e8' }}>
                    <ResourceList
                        resourceName={resourceName}
                        items={this.getPageResults()}
                        renderItem={this.renderItem}
                        selectedItems={this.props.selected}
                        onSelectionChange={this.props.onChange}
                        promotedBulkActions={promotedBulkActions}
                        bulkActions={bulkActions}
                        loading={!this.state.count}
                        hasMoreItems={true}
                        showHeader={true}
                        filterControl={filterControl}
                    />
                </div>
                <div style={{ display: 'flex', justifyContent: 'center', margin: '20px' }}>
                    <Pagination hasPrevious onPrevious={() => {
                            this.previousPage();
                        }}
                        hasNext onNext={() => {
                            this.nextPage();
                        }}
                    />
                </div>
            </Card>

        );
    }
}

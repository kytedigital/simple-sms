import React from 'react';
import {ResourceList, TextStyle, Pagination, Avatar, Card} from '@shopify/polaris';
import store from "../../store/index";
import connect from "react-redux/es/connect/connect";
import * as actions from "../../actions/processes";

class ProcessList extends React.Component {
    constructor(props) {
        
        console.log('PROPS', props);
        super(props);

        this.state = {
            order: 'ASC',
            currentPage: 1,
            searchValue: '',
            sortOn: 'last_name',
            lastSelectionState: "none",
            // count: this.props.processes.length,
            // maxPageNumber: Math.ceil(this.props.processes.length / 10),
        };
    };

    componentWillMount() {
        console.log(store.getState());

        console.log('PROCESSES', this.props.processes);

    }

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

    paginationHasPrevious() {
        return this.state.currentPage > 1;
    }

    paginationHasNext() {
        return this.state.currentPage < this.state.maxPageNumber;
    }

    // renderItem(item) {
    //     const {id, first_name, last_name, message, status} = item;
    //
    //     const media = <Avatar customer size="medium" name={first_name + ' '+last_name} />;
    //
    //     return (
    //         <ResourceList.Item
    //             id={id}
    //             accessibilityLabel={`Click to add ${first_name} ${last_name} to recipients list.`}
    //             persistActions
    //             onClick={toggleSelection}
    //             media={media}
    //         >
    //             <h3>
    //                 <TextStyle variation="strong">{first_name} {last_name}</TextStyle>
    //             </h3>
    //             <div>{message}</div>
    //             <div>{status}</div>
    //         </ResourceList.Item>
    //     );
    // };

    render() {
        const resourceName = {
            singular: 'process',
            plural: 'processes',
        };

        const promotedBulkActions = [
            {
                content: '',
                onAction: () => console.log(''),
            },
        ];

        const bulkActions = [

        ];

        // const filterControl = (
        //     <ResourceList.FilterControl
        //         context={"Search customers"}
        //         searchValue={this.state.searchValue}
        //         onSearchChange={(value) => this.handleSearchChange(value)}
        //     />
        // );
        //
        //
        // const pagination = results.length ? (
        //     <div style={{display: 'flex', justifyContent: 'center', margin: '20px'}}>
        //         <Pagination hasPrevious={this.paginationHasPrevious()}
        //                     onPrevious={() => { this.previousPage(); }}
        //                     hasNext={this.paginationHasNext()}
        //                     onNext={() => { this.nextPage(); }}
        //         />
        //     </div>
        // ) : null;

        return (
            <Card title={`Message Log`}>
                <div style={{ borderBottom: '.1rem solid #dfe3e8' }}>
                    TEST
                    {/*<ResourceList*/}
                        {/*resourceName={resourceName}*/}
                        {/*items={this.props.processes}*/}
                        {/*renderItem={this.renderItem}*/}
                        {/*selectedItems={this.props.selected}*/}
                        {/*onSelectionChange={this.props.onChange}*/}
                        {/*promotedBulkActions={!this.props.disabled ? promotedBulkActions : null}*/}
                        {/*bulkActions={!this.props.disabled ? bulkActions : null}*/}
                        {/*loadingData={this.props.loadingData}*/}
                        {/*hasMoreItems={true}*/}
                        {/*showHeader={true}*/}
                        {/*filterControl={filterControl}*/}
                        {/*sortOptions={null}*/}
                    {/*/>*/}
                </div>
                {/*{pagination}*/}
            </Card>
        );
    }
}

const mapState = state => state.processes;

export default connect(mapState, actions)(ProcessList)

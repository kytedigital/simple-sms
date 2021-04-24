import React, { Component } from 'react';
import { Context } from '../../context';
import { Autocomplete, Icon } from '@shopify/polaris';

export default class CustomerSearch extends Component {
    options = [
        {value: 'rustic', label: 'Rustic'},
        {value: 'antique', label: 'Antique'},
        {value: 'vinyl', label: 'Vinyl'},
        {value: 'vintage', label: 'Vintage'},
        {value: 'refurbished', label: 'Refurbished'},
    ];

    state = {
        selected: [],
        inputText: '',
        options: this.options,
        loading: false,
    };

    render() {
        const textField = (
            <Autocomplete.TextField
                onChange={this.updateText}
                label="Customers"
                value={this.state.inputText}
                // prefix={<Icon source={SearchMinor} color="inkLighter" />}
                placeholder="Search"
            />
        );
        return (
            <div style={{height: '225px'}}>
                <Autocomplete
                    options={this.state.options}
                    selected={this.state.selected}
                    onSelect={this.updateSelection}
                    loading={this.state.loading}
                    textField={textField}
                />
            </div>
        );
    }

    updateText = (newValue) => {
        this.setState({inputText: newValue});
        this.filterAndUpdateOptions(newValue);
    };

    filterAndUpdateOptions = (inputString) => {
        if (!this.state.loading) {
            this.setState({loading: true});
        }

        setTimeout(() => {
            if (inputString === '') {
                this.setState({
                    options: this.options,
                    loading: false,
                });
                return;
            }
            const filterRegex = new RegExp(inputString, 'i');
            const resultOptions = this.options.filter((option) =>
                option.label.match(filterRegex),
            );

            this.setState({
                options: resultOptions,
                loading: false,
            });
        }, 300);
    };

    updateSelection = (selected) => {
        const selectedText = selected.map((selectedItem) => {
            const matchedOption = this.options.find((option) => {
                return option.value.match(selectedItem);
            });
            return matchedOption && matchedOption.label;
        });
        this.setState({selected, inputText: selectedText});
    };
}

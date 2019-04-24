import * as axios from "axios";

export default class SendifySdk {
    static version () {
        return '0.1';
    }

    static sendMessage(message, recipients, callback) {
        let data = {
            'channels': [ 'sms' ],
            'message': message,
            'recipients': recipients
        };

        return this.call('dispatch', function(response) {
            return callback(response.data);
        }, 'POST', data);
    }

    static getCustomers(callback) {
        return this.call('customers?limit=250', function(response) {
            console.log('Customers Response', response.data.items);
            return callback(response.data.items);
        });
    }

    static getSubscriptionDetails(callback) {
        return this.call('subscription', function(response) {
            console.log('Subscription Data Response', response.data.item);
            return callback(response.data.item);
        });
    }

    static call(url, callback, method = 'GET', data = {}) {
        const options = {
            base: window.Sendify.apiBase,
            token: window.Sendify.token,
            method: method,
            url: url,
            data: data
        };

        // TODO set loading state
        try {
            return axios.create({
                    baseURL: options.base,
                    headers: { 'Authorization': 'Bearer ' + options.token },
                    data
                })
                .request(options)
                .then((response) => {
                    return callback(response);
                });
        } catch(e) {

            // Handle the promise rejection TODO: Didn't work
            console.log(e);
        }
    }
}

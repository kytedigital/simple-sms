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

        console.log(recipients.values());
        console.log(data);

        return this.call('dispatch', function(response) {
            return callback(response.data);
        }, 'POST', data);
    }

    static getCustomers(callback) {
        return this.call('customers', function(response) {
            console.log(response.data.items);
            return callback(response.data.items);
        });
    }

    static call(url, callback, method = 'GET', data = {}) {
        const options = {
           // base: 'https://emperor.appspot.com/api/',
            base: 'https://shopify-sms.test/api/',
            token: '9f852eb6ce5fdd8ecd2c31402ac1fea1b4769db783fe287c8a0117d35fa8325d',
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

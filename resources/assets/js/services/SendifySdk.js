import ApiService from './ApiService';

export default class SendifySdk {

    static version () {
        return '0.1';
    }

    static getCustomers() {
        this.fetch('customers', function(response) {
            return response.data;
        });
    }

    static fetch(url, callback) {

        const options = {
           // base: 'https://emperor.appspot.com/api/',
            base: 'https://shopify-sms.test/api/',
            token: '9f852eb6ce5fdd8ecd2c31402ac1fea1b4769db783fe287c8a0117d35fa8325d',
            method: 'GET',
            url: url
        };

        // TODO set loading state
        try {

            ApiService.send(options).then((response) => {
                return callback(response);
            });

        } catch(e) {

            // Handle the promise rejection TODO: Didn't work
            console.log(e);

        }
    }
}

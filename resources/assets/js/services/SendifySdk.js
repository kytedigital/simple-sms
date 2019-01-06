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
            base: 'https://emperor.appspot.com/api/',
            token: 'hcd3c510c0c076a23ef4b9b4507976f4ab9061feb46df17485347409776e955d',
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

import * as axios from "axios";

let maxBatches = 4;

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

    static async getCustomers(callback, batchNumber = 1, customers = []) {
        const customersPerCycle = 250;

        return this.call('customers?limit='+customersPerCycle+'&page='+batchNumber, function(response)
            {
                return response.data.items;
            }).then(function(batch) {
                customers.push(...batch);

                if(batchNumber >= maxBatches || batch.length < customersPerCycle) {
                    return callback(customers);
                }

                SendifySdk.getCustomers(callback, ++batchNumber, customers);
            }
        );

      //  return callback(customers);
    }

    static getSubscriptionDetails(callback) {
        return this.call('subscription', function(response) {
            return callback(response.data.item);
        });
    }

    static async call(url, callback, method = 'GET', data = {}) {
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
                    headers: {'Authorization': 'Bearer '+options.token},
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

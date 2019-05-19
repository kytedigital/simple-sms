import * as axios from "axios";

let maxBatches = 4;

export default class SimpleSDK {
    constructor(apiBase, apiToken) {
        this.apiBase = apiBase;
        this.apiToken = apiToken;
    }

    static version () {
        return '0.1';
    }

    /**
     * Get Shopify data up to a max batch limit.
     *
     * @param resource
     * @param callback
     * @param batchNumber
     * @param customers
     * @returns {Promise<any>}
     */
    static async getShopifyData(resource, callback, batchNumber = 1, customers = []) {
        const customersPerCycle = 250;

        return this.call(resource+'?limit='+customersPerCycle+'&page='+batchNumber, function(response)
            {
                return response.data.items;

            }).then(function(batch) {
                customers.push(...batch);

                if(batchNumber >= maxBatches || batch.length < customersPerCycle) {
                    return callback(customers);
                }

                SimpleSDK.getShopifyData(resource, callback, ++batchNumber, customers);
            }
        );
    }

    static subscription(callback) {
        return this.call('subscription', function(response) {
            return callback(response.data.item);
        });
    }

    static plans(callback) {
        return this.call('plans', function(response) {
            return callback(response.data.item);
        });
    }

    static async call(url, callback, method = 'GET', data = {}) {
        const options = {
            method: method,
            url: url,
            data: data
        };

        try {
            return axios.create({
                    baseURL: this.apiBase,
                    headers: {'Authorization': 'Bearer '+this.apiToken},
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

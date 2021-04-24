import * as axios from "axios";

let maxBatches = 4;

class SimpleSDK {
    constructor(apiBase, apiToken) {
        this.apiBase = apiBase;
        this.apiToken = apiToken;
    }

    subscription(callback, errorCallback) {
        return this.call('subscriptions/me',  function(response) {
            return callback(response.data);
        }, errorCallback);
    }

    plans(callback) {
        return this.call('plans', function(response) {
            return callback(response.data);
        });
    }

    purchases(callback) {
        return this.call('purchases', function(response) {
            return callback(response.data);
        });
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
    async getShopifyData(resource, callback, batchNumber = 1, customers = []) {
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

    async call(url, callback, errorCallBack = null, method = 'GET', data = {} ) {
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
        } catch(error) {
            errorCallBack();

            // Handle the promise rejection TODO: Didn't work
            console.log(error);

            throw Error(error.statusText);
        }
    }
}

export default SimpleSDK = new SimpleSDK(AppContext.apiBase, AppContext.token);
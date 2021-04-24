import * as axios from "axios";

class ApiService
{
    static send(options) {
        return axios.create({ baseURL: options.base, headers: { 'Authorization': 'Bearer ' + options.token }})
                    .request(options);
    }
}

export default ApiService;

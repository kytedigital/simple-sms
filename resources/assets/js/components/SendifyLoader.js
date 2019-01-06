import React  from 'react';
import * as ReactDOM from "react-dom";
import Dashboard from './Dashboard';

export class SendifyLoader {

    static version () {
        return '0.1';
    }

    /**
     * Store application config as a window variable and then bind the react app.
     *
     * @param options
     * @param elementId
     */
    static bind (options, elementId) {

        document.addEventListener("DOMContentLoaded", () => {

            console.log('Sendify Loader Version ' + SendifyLoader.version());

            window.Sendify = {
                "token": options.token,
                "shop": options.shop
            };

            if (document.getElementById(elementId)) {
                ReactDOM.render(<Dashboard />, document.getElementById(elementId));
            }
        });

    }
}

window.SendifyLoader = SendifyLoader;

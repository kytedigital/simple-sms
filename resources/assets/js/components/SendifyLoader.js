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
            window.Sendify = {
                "token": options.token,
                "shop": options.shop,
                "apiBase": options.apiBase
            };
            if (document.getElementById(elementId)) {
                ReactDOM.render(<Dashboard shop={options.shop} token={options.token} apiBase={options.apiBase} />, document.getElementById(elementId));
            }
        });
    }
}

window.SendifyLoader = SendifyLoader;

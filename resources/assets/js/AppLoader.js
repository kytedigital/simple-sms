import React  from 'react';
import * as ReactDOM from "react-dom";
import SimpleApp from "./SimpleApp";

export class AppLoader {
    static version () {
        return '0.2';
    }

    /**
     * Store application config as a window variable and then bind the react app.
     *
     * @param options
     * @param elementId
     */
    static bind (options, elementId) {
        document.addEventListener("DOMContentLoaded", () => {
            if (document.getElementById(elementId)) {
                ReactDOM.render(
                    <SimpleApp shop={options.shop} token={options.token} apiBase={options.apiBase}/>,
                    document.getElementById(elementId));
            }
        });
    }
}

window.AppLoader = AppLoader;

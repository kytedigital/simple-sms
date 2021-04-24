import React  from 'react';
import * as ReactDOM from "react-dom";
import SimpleSMS from "./SimpleSMS";

export class AppLoader {
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
            // TODO: Remove from Sendify SDK and pass through.
            window.Sendify = { "token": options.token, "shop": options.shop, "apiBase": options.apiBase };

            if (document.getElementById(elementId)) {
                ReactDOM.render(
                    <SimpleSMS shop={options.shop} token={options.token} apiBase={options.apiBase}/>,
                    document.getElementById(elementId));
            }
        });
    }
}

window.AppLoader = AppLoader;

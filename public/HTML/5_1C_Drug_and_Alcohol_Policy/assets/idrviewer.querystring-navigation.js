/* v1.1.0 */
(function() {
    "use strict";

    var getURLParamValue = function(param) {
        var url = document.URL;
        var jumIdx = url.toString().indexOf('?');
        var params = (jumIdx != -1) ? url.substr(jumIdx + 1).split("&") : "";
        for (var i = 0; i < params.length; i++) {
            params[i] = params[i].split('=');
            if (params[i][0] == param) {
                return params[i][1];
            }
        }
        return "";
    };

    var layout;
    var handlePageChange = function(data) {
        if (history.pushState) {
            if (layout === IDRViewer.LAYOUT_CONTINUOUS) {
                try {
                    history.replaceState({page: data.page}, null, '?page=' + data.page);
                } catch (ignore) { } // Chrome throws error on file:// protocol
            } else {
                try {
                    history.pushState({page: data.page}, null, '?page=' + data.page);
                } catch (ignore) { } // Chrome throws error on file:// protocol
            }
        }
    };

    var pg = parseInt(getURLParamValue('page'));
    if (isNaN(pg)) {
        pg = 1;
    }
    IDRViewer.goToPage(pg);

    if (history.pushState) {
        IDRViewer.on('ready', function (data) {
            layout = data.layout;

            history.replaceState({page: data.page}, null, '?page=' + data.page);

            window.onpopstate = function (event) {
                IDRViewer.off('pagechange', handlePageChange);
                IDRViewer.goToPage(event.state.page);
                IDRViewer.on('pagechange', handlePageChange);
            };

            IDRViewer.on('pagechange', handlePageChange);

            IDRViewer.on('layoutchange', function (data) {
                layout = data.layout;
            });
        });
    }

})();
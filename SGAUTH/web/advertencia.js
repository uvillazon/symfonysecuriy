/**
 * This file includes the required ext-all js and css files based upon "theme" and "direction"
 * url parameters.  It first searches for these parameters on the page url, and if they
 * are not found there, it looks for them on the script tag src query string.
 * For example, to include the neptune flavor of ext from an index page in a subdirectory
 * of extjs/examples/:
 * <script type="text/javascript" src="../../examples/shared/include-ext.js?theme=neptune"></script>
 */
(function () {
    var cantLS = localStorage.length;
    var pathLib = "http://elflwb03/sgauth/lib/socket";
    var scriptEls = document.getElementsByTagName('script');
    var path = scriptEls[scriptEls.length - 1].src;
    var codigoApp = getQueryParam('codigoApp');
    console.log(codigoApp);

    function getQueryParam(name) {
        var regex = RegExp('[?&]' + name + '=([^&]*)');
        var match = regex.exec(location.search) || regex.exec(path);
        return match && decodeURIComponent(match[1]);
    }

    document.write('<link rel="stylesheet" type="text/css" href="http://elflwb03/sgauth/Content/advertencia/autenticacion.css"/>');
    document.write('<script type="text/javascript" src="' + pathLib + '/autobahn.min.js"></script>');
    document.write('<script type="text/javascript" src="' + pathLib + '/gos_web_socket_client.js"></script>');
    document.write('<script type="text/javascript" src="' + pathLib + '/timeout.js?codigoApp=' + codigoApp + '"></script>');

})();
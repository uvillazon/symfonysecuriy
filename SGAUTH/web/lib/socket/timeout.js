(function () {
    var ALERT_TITLE = "ATENCION!";
    var ALERT_BUTTON_TEXT = "Aceptar";
    var SEGURIDAD_BUTTON_TEXT = "Reintentar";
    var URL_SOCKET = "ws://elflwb03:1339";
    var MSG = "AL INGRESAR A ESTE SISTEMA, USTED SE COMPROMETE A CUMPLIR CON LO ESTABLECIDO EN LA POLITICA DE  SEGURIDAD DE  INFORMACIÓN DE LA EMPRESA  Y CERTIFICA SER EL USUARIO DE INGRESO";
    var cantLS = localStorage.length;

    console.log("=========================================================");
    console.log(window.location.href);
    console.log("=========================================================");
    if (cantLS > 0) {
        if (esValidaElToken()) {
            console.log("procede a controlar los inicios de session");
            initSockect();
        } else {
            console.log("Procede a mostrar la pagina de mensaje de seguridad");
            crearVentanaSeguridad(MSG);
        }
    } else {
        crearVentanaSeguridad(MSG);
    }

    function createCustomAlert(txt) {
        d = document;
        if (d.getElementById("modal")) return;

        mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
        mObj.id = "modal";
        mObj.style.height = d.documentElement.scrollHeight + "px";

        alertObj = mObj.appendChild(d.createElement("div"));
        // alertObj = mHeaderObj.appendChild(d.createElement("div"));
        alertObj.id = "alertSessionBox";
        if (d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
        // console.log(d.documentElement.scrollWidth);
        // console.log(alertObj.offsetWidth);

        alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth) / 2 + "px";
        alertObj.style.visiblity = "visible";

        h1 = alertObj.appendChild(d.createElement("h1"));
        h1.appendChild(d.createTextNode(ALERT_TITLE));

        msg = alertObj.appendChild(d.createElement("p"));
        //msg.appendChild(d.createTextNode(txt));
        msg.innerHTML = txt;

        btn = alertObj.appendChild(d.createElement("a"));
        btn.id = "closeBtn";
        btn.appendChild(d.createTextNode(SEGURIDAD_BUTTON_TEXT));
        btn.href = "#";
        btn.focus();
        btn.onclick = function () {
            return window.location.reload();
            // removeCustomAlert();
            // return false;
        }

        alertObj.style.display = "block";

    }

    function initSockect() {
        var websocket = WS.connect(URL_SOCKET);

        websocket.on("socket/connect", function (session) {
            session.subscribe("websocket/autenticacion", function (uri, payload) {
                console.log(payload);
                console.log(session._session_id);
                console.log(payload.sessionId);
                if (session._session_id == payload.sessionId) {
                    console.log(payload.msg)
                    console.log(payload.success);
                    if (!payload.success) {
                        createCustomAlert(payload.msg);
                    }
                }
            });
            session.publish("websocket/autenticacion", {token: getToken(), codigoApp: getQueryParam('codigoApp')});
        });
    }

    function getToken() {
        var token = "";
        console.log("sessionStorage ===================================>");
        // console.log(sessionStorage);
        Object.keys(localStorage).forEach(function (key) {
            var keyValue = key.toUpperCase();
            console.log(keyValue);
            var href = "";
            if (getQueryParam('codigoApp') === 'SGCST') {
                href = window.location.origin + "/";
            } else {
                href = window.location.href.split('#')[0];
            }
            href = href.toUpperCase();
            console.log(href + "TOKEN");
            if (keyValue.search(href + "TOKEN") > -1 || keyValue.search(href + "JWT") > -1) {
                token = localStorage[key];
                return token;
            }
        });
        return token;
    }

    function esValidaElToken() {
        var token = getToken();
        if (isEmpty(token)) {
            console.log("no existe el campo Token");
            return false;
        } else {
            if (isTokenExpired(token)) {
                return false;
            } else {
                return true;
            }
        }
    }

    function isTokenExpired(token, offsetSeconds) {
        console.log("isTokenExpired");
        var d = getTokenExpirationDate(token);
        console.log(d);
        offsetSeconds = offsetSeconds || 0;
        if (d === null) {
            return false;
        }

        // Token expired?
        return !(d.valueOf() > (new Date().valueOf() + (offsetSeconds * 1000)));
    }

    function getTokenExpirationDate(token) {
        var decoded;
        decoded = decodeToken(token);

        if (typeof decoded.exp === "undefined") {
            return null;
        }

        var d = new Date(0); // The 0 here is the key, which sets the date to the epoch
        d.setUTCSeconds(decoded.exp);

        return d;
    }

    function decodeToken(token) {
        var parts = token.split('.');
        console.log(parts);

        if (parts.length !== 3) {
            throw new Error('JWT must have 3 parts');
        }

        var decoded = urlBase64Decode(parts[1]);
        if (!decoded) {
            throw new Error('Cannot decode the token');
        }

        return JSON.parse(decoded);
    }

    function urlBase64Decode(str) {
        var output = str.replace(/-/g, '+').replace(/_/g, '/');
        switch (output.length % 4) {
            case 0: {
                break;
            }
            case 2: {
                output += '==';
                break;
            }
            case 3: {
                output += '=';
                break;
            }
            default: {
                throw 'Illegal base64url string!';
            }
        }
        return decodeURIComponent(escape(window.atob(output))); //polifyll https://github.com/davidchambers/Base64.js
    }

    function isEmpty(val) {
        return (val === undefined || val == null || val.length <= 0) ? true : false;
    }

    function getQueryParam(name) {
        var scriptEls = document.getElementsByTagName('script');
        console.log(scriptEls);
        var path = scriptEls[scriptEls.length - 1].src;
        console.log(path);
        console.log("================================>");
        var regex = RegExp('[?&]' + name + '=([^&]*)');

        var match = regex.exec(location.search) || regex.exec(path);
        return match && decodeURIComponent(match[1]);
    }

    function crearVentanaSeguridad(txt) {
        d = document;


        if (d.getElementById("modalContainer")) return;

        mObj = d.getElementsByTagName("body")[0].appendChild(d.createElement("div"));
        mObj.id = "modalContainer";
        mObj.style.height = d.documentElement.scrollHeight + "px";

        mHeaderObj = mObj.appendChild(d.createElement("div"));
        mHeaderObj.id = "modalHeaderContainer";
        mHeaderObj.style.visiblity = "visible";

        logoObj = mHeaderObj.appendChild(d.createElement("div"));
        logoObj.id = "logo_advertencia";
        logoObj.style.visiblity = "visible";

        alertObj = mObj.appendChild(d.createElement("div"));
        // alertObj = mHeaderObj.appendChild(d.createElement("div"));
        alertObj.id = "alertBox";
        if (d.all && !window.opera) alertObj.style.top = document.documentElement.scrollTop + "px";
        // console.log(d.documentElement.scrollWidth);
        // console.log(alertObj.offsetWidth);

        alertObj.style.left = (d.documentElement.scrollWidth - alertObj.offsetWidth) / 2 + "px";
        alertObj.style.visiblity = "visible";

        h1 = alertObj.appendChild(d.createElement("h1"));
        h1.appendChild(d.createTextNode(ALERT_TITLE));

        msg = alertObj.appendChild(d.createElement("p"));
        //msg.appendChild(d.createTextNode(txt));
        msg.innerHTML = txt;

        btn = alertObj.appendChild(d.createElement("a"));
        btn.id = "closeBtn";
        btn.appendChild(d.createTextNode(ALERT_BUTTON_TEXT));
        btn.href = "#";
        btn.focus();
        btn.onclick = function () {
            removeCustomAlert();
            return false;
        }

        alertObj.style.display = "block";

    }

    function removeCustomAlert() {
        document.getElementsByTagName("body")[0].removeChild(document.getElementById("modalContainer"));
    }
})();
/* Desarrollado por Pablo Sergio Alvarado G. */

Ext.define('App.Config.JwtService', {
    alternateClassName: 'jwtService',
    singleton: true,
    constructor: function (config) {
        if (config == null) {
            config = {};
        }
        this.initConfig(config);
        return this.callParent(arguments);
    },

    urlBase64Decode: function (str) {
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
    },

    decodeToken: function (token) {
        var parts = token.split('.');

        if (parts.length !== 3) {
            throw new Error('JWT must have 3 parts');
        }

        var decoded = this.urlBase64Decode(parts[1]);
        if (!decoded) {
            throw new Error('Cannot decode the token');
        }

        return JSON.parse(decoded);
    },

    getTokenExpirationDate: function (token) {
        var decoded;
        decoded = this.decodeToken(token);

        if (typeof decoded.exp === "undefined") {
            return null;
        }

        var d = new Date(0); // The 0 here is the key, which sets the date to the epoch
        d.setUTCSeconds(decoded.exp);

        return d;
    },

    isTokenExpired: function (token, offsetSeconds) {
        var d = this.getTokenExpirationDate(token);
        offsetSeconds = offsetSeconds || 0;
        if (d === null) {
            return false;
        }

        // Token expired?
        return !(d.valueOf() > (new Date().valueOf() + (offsetSeconds * 1000)));
    },

}); 
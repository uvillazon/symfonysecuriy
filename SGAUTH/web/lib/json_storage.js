/* json_storage.js
 * @danott
 * 26 APR 2011
 *
 * Building on a thread from Stack Overflow, override localStorage and sessionStorage's
 * getter and setter functions to allow for storing objects and arrays.
 *
 * Original thread:
 * http://stackoverflow.com/questions/2010892/storing-objects-in-html5-localstorage
 */
Storage.prototype._setItem = Storage.prototype.setItem;
Storage.prototype.setItem = function (key, value) {
    key = window.location.href.split('#')[0] + "" + key;
    this._setItem(key, value);
}

Storage.prototype._getItem = Storage.prototype.getItem;
Storage.prototype.getItem = function (key) {
    key = window.location.href.split('#')[0] + "" + key;
    try {
        return this._getItem(key);
    }
    catch (e) {
        return this._getItem(key);
    }
}
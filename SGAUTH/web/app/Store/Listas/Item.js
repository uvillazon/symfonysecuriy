/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Listas.Item', {

    model: 'App.Model.Listas.Item',
    url: 'listas/items',
    extend: 'App.Config.Abstract.Store'
});

/**
 * @class App.Config.Abstract.Store
 * @extends Ext.data.Store
 * requires
 * @autor Ubaldo Villazon
 * @date 07/11/2013
 *
 * Description
 *
 *
 **/

Ext.define("App.Store.Listas.Item", {
    extend: "Ext.data.Store",
    remoteSort: true,
    autoLoad: false,
    pageSize: 100,
    type: 'rest',
    url: 'api/listas/items',
    model : 'App.Model.Listas.Item',
    constructor: function (config) {
        var me = this;
        var defaults = {
            autoload: false,
            proxy: {
                type: "rest",
                headers: {'Authorization': "Bearer " + Constantes.TOKEN},
                api: {
                    read: Constantes.obtenerHost() + "" + me.url,

                },
                reader: {
                    type: "json",
                    root: "rows",
                    totalProperty: "total",
                    successProperty: "success",
                    messageProperty: "msg"
                },
                writer: {
                    type: "json",
                    encode: true,
                    writeAllFields: true,
                    root: "data",
                    allowSingle: false
                },
                simpleSortMode: true
            }
        };
        this.callParent([Ext.Object.merge({}, defaults, config)]);
    }
});
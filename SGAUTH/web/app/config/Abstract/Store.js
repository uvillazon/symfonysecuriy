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

Ext.define("App.Config.Abstract.Store", {
    extend: "Ext.data.Store",
    remoteSort: true,
    autoLoad: false,
    sortProperty: '',
    sortDirection: 'DESC',
    pageSize: 25,
    type: 'rest',
    url : '',
    urlCreate: '',
    urlUpdate: '',
    urlDestroy : '',
    //model : '',
    constructor: function (config) {
        var me = this;
        var defaults = {
            sorters : [
                {
                    property: me.sortProperty,
                    direction: me.sortDirection
                }
            ],
            autoload: false,
            proxy: {
                type: "rest",
                headers: {'Authorization': "Bearer "+window.localStorage.token },
                api: {
                    read: Constantes.HOST + "" + me.url,
                    create: Constantes.HOST + "" + me.urlCreate,
                    update: Constantes.HOST + "" + me.urlUpdate,
                    destroy: Constantes.HOST + "" + me.urlDestroy,
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
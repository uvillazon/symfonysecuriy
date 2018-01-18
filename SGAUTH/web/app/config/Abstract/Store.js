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
    pageSize: 100,
    type: 'rest',

    url: '',
    urlCreate: '',
    urlUpdate: '',
    urlDestroy: '',
    // model : '',
    constructor: function (config) {
        var me = this;
        var defaults = {
            sorters: [
                {
                    property: me.sortProperty,
                    direction: me.sortDirection
                }
            ],
            autoload: false,
            proxy: {
                type: "rest",
                headers: {'Authorization': "Bearer " + Constantes.TOKEN},
                api: {
                    read: Constantes.getEndpoint(me.url),
                    create: Constantes.getEndpoint(me.urlCreate),
                    update: Constantes.getEndpoint(me.urlUpdate),
                    destroy: Constantes.getEndpoint(me.urlDestroy),
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
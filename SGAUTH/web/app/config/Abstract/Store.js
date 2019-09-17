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
    backendUrl : true,
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
                    read: me.backendUrl ?  Constantes.getEndpoint(me.url) : Constantes.obtenerHost()+""+me.url,
                    create: me.backendUrl ? Constantes.getEndpoint(me.urlCreate) : Constantes.obtenerHost()+""+me.url,
                    update:  me.backendUrl ?  Constantes.getEndpoint(me.urlUpdate) : Constantes.obtenerHost()+""+me.url,
                    destroy:  me.backendUrl ?  Constantes.getEndpoint(me.urlDestroy) : Constantes.obtenerHost()+""+me.url
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
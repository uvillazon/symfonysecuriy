/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Erp.Proveedores', {

    model: 'App.Model.Areas.AreasApp',
    url: 'erp/proveedores',
    backendUrl : false,
    sortProperty: 'idproveedor',
    extend: 'App.Config.Abstract.Store'
});
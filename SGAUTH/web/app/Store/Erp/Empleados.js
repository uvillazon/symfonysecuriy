/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Erp.Empleados', {

    model: 'App.Model.Erp.Empleados',
    url: 'erp/empleados',
    backendUrl : false,
    sortProperty: 'idempleado',
    extend: 'App.Config.Abstract.Store'
});
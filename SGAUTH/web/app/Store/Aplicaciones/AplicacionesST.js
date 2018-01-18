/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Aplicaciones.AplicacionesST', {

    model: 'App.Model.Aplicaciones.Aplicaciones',
    url: 'aplicacion-st',
    sortProperty: 'id_aplic',
    extend: 'App.Config.Abstract.Store'
});
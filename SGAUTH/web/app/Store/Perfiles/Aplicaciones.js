/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Perfiles.Aplicaciones', {

    model: 'App.Model.Perfiles.Aplicaciones',
    url: 'perfiles/aplicaciones',
    sortProperty: 'id_aplic',
    extend: 'App.Config.Abstract.Store'
});
/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Areas.AreasApp', {

    model: 'App.Model.Areas.AreasApp',
    url: 'areas_usuarios',
    sortProperty: 'id_area',
    extend: 'App.Config.Abstract.Store'
});
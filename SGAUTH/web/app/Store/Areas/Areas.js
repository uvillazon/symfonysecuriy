/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Areas.Areas', {

    model: 'App.Model.Areas.Areas',
    url: 'areas',
    sortProperty: 'id_area',
    extend: 'App.Config.Abstract.Store'
});
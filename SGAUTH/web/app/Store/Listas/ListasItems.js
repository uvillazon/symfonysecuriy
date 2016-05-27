/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Listas.ListasItems', {

    model: 'App.Model.Listas.ListasItems',
    url: 'listas/items',
    sortProperty: 'codigo',
    extend: 'App.Config.Abstract.Store'
});
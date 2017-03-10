/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Listas.ListasItemsRel', {

    model: 'App.Model.Listas.ListasItemsRel',
    url: 'listas/items_rel',
    sortProperty: 'id_hijo',
    extend: 'App.Config.Abstract.Store'
});
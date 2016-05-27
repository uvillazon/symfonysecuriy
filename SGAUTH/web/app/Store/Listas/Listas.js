/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Listas.Listas', {

    model: 'App.Model.Listas.Listas',
    url: 'listas/listas',
    sortProperty: 'id_lista',
    extend: 'App.Config.Abstract.Store'
});
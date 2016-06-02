/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Directorios.Grupos', {

    model: 'App.Model.Directorios.Grupos',
    url: 'directorios/grupos',
    sortProperty: 'id_grp',
    extend: 'App.Config.Abstract.Store'
});
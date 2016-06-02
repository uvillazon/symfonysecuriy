/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Directorios.GruposDest', {

    model: 'App.Model.Directorios.Destinatarios',
    url: 'directorios/destGrupos',
    sortProperty: 'id',
    extend: 'App.Config.Abstract.Store'
});
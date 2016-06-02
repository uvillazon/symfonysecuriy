/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Directorios.Destinatarios', {

    model: 'App.Model.Directorios.Destinatarios',
    url: 'directorios/destinatarios',
    sortProperty: 'id_dest',
    extend: 'App.Config.Abstract.Store'
});
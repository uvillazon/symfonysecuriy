/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Opciones.BotonesPerfil', {
    model: 'App.Model.Opciones.Botones',
    url: 'opciones/botonesperfiles',
    sortProperty: 'id_opc',
    extend: 'App.Config.Abstract.Store'
});
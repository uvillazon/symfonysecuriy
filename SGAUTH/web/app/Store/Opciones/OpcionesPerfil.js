/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Opciones.OpcionesPerfil', {
    model: 'App.Model.Opciones.Opciones',
    url: 'opciones/menusperfiles',
    sortProperty: 'id_opc',
    extend: 'App.Config.Abstract.Store'
});
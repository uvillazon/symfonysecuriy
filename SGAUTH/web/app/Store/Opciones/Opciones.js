/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Opciones.Opciones', {
    model: 'App.Model.Opciones.Opciones',
    url: 'opciones/menus',
    sortProperty: 'id_opc',
    extend: 'App.Config.Abstract.Store'
});
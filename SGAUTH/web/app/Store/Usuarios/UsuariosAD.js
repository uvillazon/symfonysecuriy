/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Usuarios.UsuariosAD', {

    model: 'App.Model.Usuarios.Usuarios',
    url: 'usuarios/usuariosAD',
    sortProperty: 'name',
    remoteSort: false,
    extend: 'App.Config.Abstract.Store'
});
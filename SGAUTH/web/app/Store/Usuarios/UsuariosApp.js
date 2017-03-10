/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Usuarios.UsuariosApp', {

    model: 'App.Model.Usuarios.AppUsr',
    url: 'usuarios/usuarios_app',
    sortProperty: 'id_usuario',
    extend: 'App.Config.Abstract.Store'
});
/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Usuarios.Usuarios', {

    model: 'App.Model.Usuarios.Usuarios',
    url: 'usuarios/usuarios',
    sortProperty: 'id_usuario',
    extend: 'App.Config.Abstract.Store'
});
//Ext.define('App.Store.Usuarios.Usuarios', {
//
//    extend: 'Ext.data.Store',
//    autoLoad: true,
//    remoteSort: true,
//    model: 'App.Model.Usuarios.Usuarios',
//    proxy: {
//        type: 'rest',
//        headers: {'Authorization': "Bearer "+window.localStorage.token },
//        url: 'backend/usuarios/usuarios',
//        reader: {
//            type: "json",
//            root: "rows",
//            successProperty: "success",
//            totalProperty: "total"
//        },
//        writer: {
//            type: 'json',
//            allowSingle: false
//        },
//        simpleSortMode: true
//    },
//    sorters : [{
//        property: 'ASC',
//        direction: 'id_usuario'
//    }]
//});
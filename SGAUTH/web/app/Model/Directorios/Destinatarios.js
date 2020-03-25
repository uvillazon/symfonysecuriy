/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Directorios.Destinatarios', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "id_dest"},
        {type: "int", name: "id_aplic"},
        {type: "string", name: "correo"},
        {type: "string", name: "nombre"},
        {type: "string", name: "apellido"},
        {type: "string", name: "estado"},
        {type: "string", name: "grupo"},
        {type: "string", name: "tipo_msg_dest"},
        {type: "string", name: "login_usr"},
        {type: "date", name: "fecha_reg"}
    ]  ,
    proxy: {
        type: 'rest',
        url : Constantes.HOST + 'directorios/destGrupos'   ,
        headers: {'Authorization': "Bearer "+Constantes.TOKEN },
    }
});


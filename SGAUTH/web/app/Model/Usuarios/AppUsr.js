/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Usuarios.AppUsr', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "int", name: "id_usuario" },
        { type: "string", name: "login" },
        { type: "string", name: "email" },
        { type: "date", name: "fch_alta"},
        { type: "date", name: "fch_baja" },
        { type: "string", name: "aplicacion" },
        { type: "int", name: "id_perfil" },
        { type: "string", name: "perfil" },
        {
            type: "string",
            name: 'nom_area',
            mapping: 'area.nom_area'
        },
        {
            type: "int",
            name: 'id_area',
            mapping: 'area.id_area'
        }


    ]
});
/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Perfiles.Perfiles', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "int", name: "id_perfil" },
        { type: "int", name: "id_aplic" },
        { type: "string", name: "codigo_app" },
        { type: "string", name: "aplicacion" },
        { type: "string", name: "nombre" },
        { type: "string", name: "descripcion" },
        { type: "string", name: "estado" },
    ]
});
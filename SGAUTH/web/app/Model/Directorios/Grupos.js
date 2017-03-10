/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Directorios.Grupos', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "int", name: "id_grp" },
        { type: "string", name: "nombre" },
        { type: "string", name: "estado" },
        { type: "int", name: "id_aplic" }
    ]
});


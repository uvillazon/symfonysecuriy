/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Opciones.Opciones', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "int", name: "id_opc" },
        { type: "int", name: "id_aplic" },
        { type: "string", name: "aplicacion" },
        { type: "string", name: "opcion" },
        { type: "string", name: "link" },
        { type: "string", name: "tooltip" },
        { type: "string", name: "icono" },
        { type: "string", name: "estilo" },
        { type: "int", name: "id_padre" },
        { type: "string", name: "padre" },
        { type: "int", name: "orden" },
        { type: "string", name: "estado" }
    ]
});
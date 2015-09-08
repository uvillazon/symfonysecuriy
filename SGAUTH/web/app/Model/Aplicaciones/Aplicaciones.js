/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Aplicaciones.Aplicaciones', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "int", name: "id_aplic" },
        { type: "string", name: "codigo" },
        { type: "string", name: "nombre" },
        { type: "string", name: "descripcion" },
        { type: "string", name: "estado" },
        { type: "date", name: "fch_alta"},
        { type: "string", name: "bd_princ" },
        { type: "string", name: "bd_port" },
        { type: "string", name: "bd_host" },
        { type: "string", name: "bd_drive" },
        { type: "string", name: "app_host" },
        { type: "string", name: "secret_key" }
    ]
});
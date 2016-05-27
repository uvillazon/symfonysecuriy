/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Listas.Listas', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "int", name: "id_lista" },
        { type: "string", name: "lista" },
        { type: "string", name: "descripcion" },
        { type: "int", name: "tam_limite" },
        { type: "string", name: "tipo_valor" },
        { type: "string", name: "mayus_minus" },
        { type: "string", name: "estado" },
        { type: "int", name: "id_aplic" },
        { type: "string", name: "bd_drive" },
        { type: "string", name: "app_host" },
        { type: "string", name: "secret_key" }
    ]
});


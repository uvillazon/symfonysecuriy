/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Historicos.HistoricosEdicion', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "string", name: "login_usr" },
        { type: "string", name: "motivo" },
        { type: "string", name: "tabla" },
        { type: "string", name: "valores_nuevos" },
        { type: "date", name: "fecha_reg"},
        { type: "string", name: "valores_antiguos" },
        { type: "string", name: "id_dato" }
    ]
});
/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Listas.ListasItemsRel', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "id_rel"},
        {type: "int", name: "id_padre"},
        {type: "int", name: "id_hijo"},
        {type: "string", name: "lista_padre", mapping: "padre.lista.lista"},
        {type: "string", name: "valor_padre", mapping: "padre.valor"},
        {type: "string", name: "lista_hijo", mapping: "hijo.lista.lista"},
        {type: "string", name: "valor_hijo", mapping: "hijo.valor"},
    ]
});
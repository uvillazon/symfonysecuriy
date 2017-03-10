/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Listas.ListasItems', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "id_lista"},
        {type: "int", name: "id_padre", mapping: 'id_item'},
        {type: "int", name: "id_item"},
        {type: "string", name: "codigo"},
        {type: "string", name: "lista_padre", mapping: "lista.lista"},
        {type: "string", name: "valor"},
        {type: "string", name: "estado"},
        {type: "string", name: "orden"},
    ]
});


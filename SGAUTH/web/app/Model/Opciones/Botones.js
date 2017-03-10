Ext.define('App.Model.Opciones.Botones', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "id_boton"},
        {type: "int", name: "id_opc"},
        {type: "string", name: "opcion"},
        {type: "string", name: "boton"},
        {type: "string", name: "tooltip"},
        {type: "string", name: "id_item"},
        {type: "string", name: "estilo"},
        {type: "string", name: "accion"},
        {type: "string", name: "icono"},
        {type: "string", name: "orden"},
        {type: "string", name: "estado"},
        {type: "int", name: "id_padre"},
        {type: "string", name: "padre"},
        {type: "boolean", name: "disabled"},
        {
            type: 'string', name: "disabled_s", mapping: function (raw) {
            return raw.disabled ? 'SI' : 'NO';
        }
        }
    ]
});
Ext.define('App.Model.Usuarios.Usuarios', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "int", name: "ID_USUARIO" },
        { type: "string", name: "LOGIN" },
        { type: "string", name: "NOMBRE" },
        { type: "string", name: "EMAIL" },
        { type: "date", name: "FCH_ALTA", dateFormat: "d/m/Y", convert: Funciones.Fecha },
        { type: "date", name: "FCH_BAJA", dateFormat: "d/m/Y", convert: Funciones.Fecha },
        { type: "int", name: "ID_PERFIL" },
        { type: "int", name: "ID_RESP" },
        { type: "string", name: "PERFIL" },
        { type: "string", name: "ESTADO" },
        { type: "string", name: "UNIDAD" },
        { name: 'CON_RESP', type: 'boolean' },
        { type: "string", name: "NOMBRECOMPLETO", convert: Funciones.CopiarRecordmodelo, defaultValue: "NOMBRE" },
        //NOMBRECOMPLETO
    ]
});
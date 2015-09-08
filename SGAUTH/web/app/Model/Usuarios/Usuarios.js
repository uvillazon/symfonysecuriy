Ext.define('App.Model.Usuarios.Usuarios', {
    extend: 'Ext.data.Model',
    fields: [
        { type: "int", name: "id_usuario" },
        { type: "string", name: "login" },
        { type: "string", name: "nombre" },
        { type: "string", name: "email" },
        { type: "date", name: "fch_alta"},
        { type: "date", name: "fch_baja" },
        { type: "string", name: "estado" }
    ]
});
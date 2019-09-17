Ext.define('App.Model.Erp.Proveedores', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "idproveedor"},
        {type: "string", name: "descripcion"},
        {type: "date", name: "fecha_alta"},
        {type: "string", name: "calle"},
        {type: "int", name: "nro_cuit"}
    ],
});

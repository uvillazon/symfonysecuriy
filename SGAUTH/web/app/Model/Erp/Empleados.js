Ext.define('App.Model.Erp.Empleados', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "idempleado"},
        {type: "string", name: "nombre"},
        {type: "string", name: "observaciones"},

    ]
});

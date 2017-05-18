Ext.define('App.Model.Usuarios.Usuarios', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "id_usuario"},
        {type: "string", name: "login"},
        {type: "string", name: "nombre"},
        {type: "string", name: "email"},
        {type: "date", name: "fch_alta"},
        {type: "date", name: "fch_baja"},
        {type: "string", name: "estado"},
        {type: "int", name: "id_area"},
        {
			type: "string",
            name: 'nom_area',
            mapping: 'area.nom_area'
        },
        {name: 'area'},

    ],
    // associations: [
    //     {
    //         type: 'BelongsTo', model: 'App.Model.Areas.Areas',
    //         name: 'nom_area'
    //     }],
    belongsTo: {
        model: 'App.Model.Areas.Areas',
        foreignKey: 'id_area',
        name: 'area'
    }
});
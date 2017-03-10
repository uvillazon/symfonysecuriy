/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Areas.Areas', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "id_area"},
        {type: "string", name: "login_usr"},
        {type: "date", name: "fecha_reg"},
        {type: "string", name: "estado"},
        {type: "int", name: "id_padre"},
        {type: "string", name: "nom_area"}
    ],
    // associations:[
    //     {type:'HasMany',    model:'App.Model.Usuarios.Usuarios', foreignKey:'id_usuario'}
    // ],
    hasMany: {
        model: 'App.Model.Usuarios.Usuarios',
        foreignKey: 'area',
        name: 'area'
    },
});

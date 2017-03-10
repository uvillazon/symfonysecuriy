/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Areas.AreasApp', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "id_area"},
        {type: "int", name: "id_usr_area"},

        {type: "string", name: "login_usr"},
        {type: "date", name: "fecha_reg"},
        {
            name: 'nom_area',
            mapping: 'area.nom_area'
        },
        {
            name: 'nombre',
            mapping: 'usuario.nombre'
        }
    ]
});

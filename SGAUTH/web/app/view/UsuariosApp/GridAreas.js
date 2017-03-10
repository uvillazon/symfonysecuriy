/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.UsuariosApp.GridAreas", {
    extend: "App.Config.Abstract.Grid",
    title: 'Areas  Por Usuario',
    imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    busqueda: true,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Areas.AreasApp");
        me.CargarComponentes();
        me.columns = [
            {xtype: "rownumberer", width: 30, sortable: false},
            {header: "Area", width: 150, sortable: true, dataIndex: "nom_area"},
            {
                header: "Fecha Reg",
                width: 90,
                sortable: true,
                dataIndex: "fecha_reg",
                renderer: Ext.util.Format.dateRenderer('d/m/Y')
            },
            {
                header: "Login Reg",
                width: 90,
                sortable: true,
                dataIndex: "login_usr"
            },


        ];

        this.callParent(arguments);

    }
});
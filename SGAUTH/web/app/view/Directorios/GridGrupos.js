/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Directorios.GridGrupos", {
    extend: "App.Config.Abstract.Grid",
    title: 'Administracion de Grupos',
    imprimir: true,
    criterios: true,
    busqueda : false,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Directorios.Grupos");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Nombre", width: 200, sortable: true, dataIndex: "nombre" },
            { header: "Estado", width: 90, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
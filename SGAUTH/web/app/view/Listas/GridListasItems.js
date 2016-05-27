/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Listas.GridListasItems", {
    extend: "App.Config.Abstract.Grid",
    title: 'Items Por Lista',
    imprimir: true,
    criterios: true,
    busqueda : true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Listas.ListasItems");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Codigo", width: 100, sortable: true, dataIndex: "codigo" },
            { header: "Valor", width: 200, sortable: true, dataIndex: "valor" },
            { header: "Estado", width: 90, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
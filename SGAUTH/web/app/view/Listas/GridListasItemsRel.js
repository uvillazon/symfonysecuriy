/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Listas.GridListasItemsRel", {
    extend: "App.Config.Abstract.Grid",
    title: 'Items Rel Por Item Lista',
    imprimir: true,
    criterios: true,
    busqueda : true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Listas.ListasItemsRel");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Lista Padre", width: 200, sortable: false, dataIndex: "lista_padre" },
            { header: "Lista Hijo", width: 200, sortable: false, dataIndex: "lista_hijo" },
            { header: "Valor", width: 200, sortable: false, dataIndex: "valor_hijo" }
        ];

        this.callParent(arguments);

    }
});
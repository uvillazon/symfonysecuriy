/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Listas.GridListas", {
    extend: "App.Config.Abstract.Grid",
    title: 'Adminsitracion de Listas',
    imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Listas.Listas");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Lista", width: 150, sortable: true, dataIndex: "lista" },
            { header: "Descripcion", width: 200, sortable: true, dataIndex: "descripcion" },
            { header: "Tamaño <br>Limite", width: 60, sortable: true, dataIndex: "tam_limite" },
            { header: "Tipo Valor", width: 80, sortable: true, dataIndex: "tipo_valor" },
            { header: "Mayus Minus", width: 80, sortable: true, dataIndex: "mayus_minus" },
            { header: "Ordener Por", width: 80, sortable: true, dataIndex: "ordenar_por" },
            { header: "Tipo Orden", width: 80, sortable: true, dataIndex: "tipo_orden" },
            { header: "estado", width: 100, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Historicos.GridHistoricosEdicion", {
    extend: "App.Config.Abstract.Grid",
    title: 'Historicos de Edicion de Datos',
    imprimir: false,
    criterios: true,
    busqueda : true,
    opcion: '',
    paramsStore: null,
    width :700,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Historicos.HistoricosEdicion");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Motivo", width: 100, sortable: true, dataIndex: "motivo" },
            { header: "Valores <br> Anteriores", width: 200, sortable: true, dataIndex: "valores_antiguos" },
            { header: "Valores <br> Nuevos", width: 200, sortable: true, dataIndex: "valores_nuevos" },
            { header: "Fecha", width: 90, sortable: true, dataIndex: "fecha_reg", renderer: Ext.util.Format.dateRenderer('d/m/Y') },
            { header: "Responsable <br>Cambio", width: 90, sortable: true, dataIndex: "login_usr" }
        ];

        this.callParent(arguments);

    }
});
/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Aplicaciones.GridAplicaciones", {
    extend: "App.Config.Abstract.Grid",
    title: 'Aplicaciones',
    imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Aplicaciones.Aplicaciones");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Codigo", width: 90, sortable: true, dataIndex: "codigo" },
            { header: "Aplciacion", width: 150, sortable: true, dataIndex: "nombre" },
            { header: "Descripcion", width: 150, sortable: true, dataIndex: "descripcion" },
            { header: "Fecha Alta", width: 90, sortable: true, dataIndex: "fch_alta", renderer: Ext.util.Format.dateRenderer('d/m/Y') },
            { header: "Base<br>Datos", width: 90, sortable: true, dataIndex: "bd_princ" },
            { header: "Puerto", width: 90, sortable: true, dataIndex: "bd_port" },
            { header: "BD<br>Host", width: 90, sortable: true, dataIndex: "bd_host" },
            { header: "Drive", width: 90, sortable: true, dataIndex: "bd_drive" },
            { header: "Host", width: 90, sortable: true, dataIndex: "app_host" },
            { header: "Secret Key", width: 90, sortable: true, dataIndex: "secret_key" },

            { header: "Estado", width: 90, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
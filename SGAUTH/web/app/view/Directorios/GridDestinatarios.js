/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Directorios.GridDestinatarios", {
    extend: "App.Config.Abstract.Grid",
    title: 'Adminsitracion de Destinatarios',
    imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Directorios.Destinatarios");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Nombre", width: 200, sortable: true, dataIndex: "nombre" },
            { header: "Apellido", width: 200, sortable: true, dataIndex: "apellido" },
            { header: "correo", width: 250, sortable: true, dataIndex: "correo" },
            { header: "Fecha", width: 90, sortable: true, dataIndex: "fecha_reg", renderer: Ext.util.Format.dateRenderer('d/m/Y') },
            { header: "estado", width: 100, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
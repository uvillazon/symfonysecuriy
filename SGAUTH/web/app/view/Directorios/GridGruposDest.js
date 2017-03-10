/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Directorios.GridGruposDest", {
    extend: "App.Config.Abstract.Grid",
    title: 'Destinatarios y Grupos',
    imprimir: true,
    criterios: true,
    busqueda : true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Directorios.GruposDest");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Nombre", width: 100, sortable: true, dataIndex: "nombre" },
            { header: "Apellido", width: 100, sortable: true, dataIndex: "apellido" },
            { header: "Email", width: 200, sortable: true, dataIndex: "correo" },
            { header: "Grupo", width: 100, sortable: true, dataIndex: "grupo" },
            { header: "Tipo <br>Mensaje", width: 100, sortable: true, dataIndex: "tipo_msg_dest" }
        ];

        this.callParent(arguments);

    }
});
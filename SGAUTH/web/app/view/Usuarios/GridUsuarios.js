/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Usuarios.GridUsuarios", {
    extend: "App.Config.Abstract.Grid",
    title: 'Usuarios',
    imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Usuarios.Usuarios");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Con <br>Resp", width: 50, sortable: false, dataIndex: 'CON_RESP', renderer: me.renderUsuario },
            { header: "Login", width: 90, sortable: true, dataIndex: "LOGIN" },
            { header: "Nombre", width: 150, sortable: true, dataIndex: "NOMBRE" },
            { header: "Email", width: 150, sortable: true, dataIndex: "EMAIL" },
            { header: "Fecha Alta", width: 90, sortable: true, dataIndex: "FCH_ALTA", renderer: Ext.util.Format.dateRenderer('d/m/Y') },
            { header: "Perfil", width: 150, sortable: true, dataIndex: "PERFIL" },
            { header: "Estado", width: 90, sortable: true, dataIndex: "ESTADO" },
        ];

        this.callParent(arguments);

    }
});
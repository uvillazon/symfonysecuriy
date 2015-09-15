/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Usuarios.GridUsuarios", {
    extend: "App.Config.Abstract.Grid",
    title: 'Usuarios',
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
            { header: "Login", width: 90, sortable: true, dataIndex: "login" },
            { header: "Nombre", width: 150, sortable: true, dataIndex: "nombre" },
            { header: "Email", width: 150, sortable: true, dataIndex: "email" },
            { header: "Fecha Alta", width: 90, sortable: true, dataIndex: "fch_alta", renderer: Ext.util.Format.dateRenderer('d/m/Y') },
            { header: "Estado", width: 90, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
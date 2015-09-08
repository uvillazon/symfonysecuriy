/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Usuarios.GridAplicacionesPorUsuario", {
    extend: "App.Config.Abstract.Grid",
    title: 'Aplicaciones Por Usuario',
    imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Usuarios.AppUsr");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Cod. App", width: 100, sortable: true, dataIndex: "codigo_app" },
            { header: "Nombre<br>Aplicacion", width: 200, sortable: true, dataIndex: "aplicacion" },
            { header: "Perfil", width: 100, sortable: true, dataIndex: "perfil" },
            { header: "Fecha Alta", width: 90, sortable: true, dataIndex: "fch_alta", renderer: Ext.util.Format.dateRenderer('d/m/Y') },
            { header: "Estado", width: 90, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
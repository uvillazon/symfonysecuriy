/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Aplicaciones.GridAplicacionesPorUsuario", {
    extend: "App.Config.Abstract.Grid",
    title: 'Usuario Por Aplicacion',
    imprimir: true,
    criterios: true,
    busqueda : true,
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
            { header: "Login", width: 100, sortable: true, dataIndex: "login" },
            { header: "Nombre<br>Usuario", width: 200, sortable: true, dataIndex: "nombre" },
            { header: "Perfil", width: 100, sortable: true, dataIndex: "perfil" },
            { header: "Fecha Alta", width: 90, sortable: true, dataIndex: "fch_alta", renderer: Ext.util.Format.dateRenderer('d/m/Y') },
            { header: "Estado", width: 90, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
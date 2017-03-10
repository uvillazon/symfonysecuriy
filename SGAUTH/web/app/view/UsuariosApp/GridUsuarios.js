/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.UsuariosApp.GridUsuarios", {
    extend: "App.Config.Abstract.Grid",
    title: 'Usuarios Aplicacion',
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    tabla : 'usuarios',
    id_tabla : 'id_usuario',
    reportesHistoricoEstados: false,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Usuarios.UsuariosApp");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Perfil", width: 150, sortable: true, dataIndex: "perfil" },
            { header: "Login", width: 90, sortable: true, dataIndex: "login" },
            { header: "Nombre", width: 150, sortable: true, dataIndex: "nombre" },
            { header: "Email", width: 150, sortable: true, dataIndex: "email" },
            { header: "Area", width: 150, sortable: true, dataIndex: "nom_area" },
            { header: "Fecha Alta", width: 90, sortable: true, dataIndex: "fch_alta", renderer: Ext.util.Format.dateRenderer('d/m/Y') },
            { header: "Estado", width: 90, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
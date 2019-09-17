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
    tabla: 'usuarios',
    id_tabla: 'id_usuario',
    reportesHistoricoEstados: false,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Usuarios.Usuarios");
        me.CargarComponentes();
        me.columns = [
            {xtype: "rownumberer", width: 30, sortable: false},
            {
                header: "Con<br>Certificado",
                width: 60,
                sortable: true,
                dataIndex: "tiene_certificado",
                renderer: function (value, metaData, record) {
                    return value === true ? '<img data-qtip="' + value + '", src="' + Constantes.obtenerHost() + '/Content/Iconos/key.png" />' : null;
                }
            },
            {header: "Login", width: 90, sortable: true, dataIndex: "login"},
            {header: "Nombre", width: 150, sortable: true, dataIndex: "nombre"},
            {header: "Email", width: 150, sortable: true, dataIndex: "email"},
            {header: "Area", width: 150, sortable: true, dataIndex: "nom_area"},
            {header: "Id Empleado", width: 80, sortable: true, dataIndex: "idempleado"},
            {header: "Id Proveedor", width: 80, sortable: true, dataIndex: "idproveedor"},
            {
                header: "Fecha Alta",
                width: 90,
                sortable: true,
                dataIndex: "fch_alta",
                renderer: Ext.util.Format.dateRenderer('d/m/Y')
            },
            {header: "Estado", width: 90, sortable: true, dataIndex: "estado"}
        ];

        this.callParent(arguments);

    }
});
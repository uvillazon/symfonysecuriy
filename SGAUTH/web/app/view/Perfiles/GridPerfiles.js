/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Perfiles.GridPerfiles", {
    extend: "App.Config.Abstract.Grid",
    title: 'Perfiles',
    imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Perfiles.Perfiles");
        me.CargarComponentes();
        me.columns = [
            { xtype: "rownumberer", width: 30, sortable: false },
            { header: "Codigo<br>App", width: 90, sortable: true, dataIndex: "codigo_app" },
            { header: "Aplicacion", width: 200, sortable: true, dataIndex: "aplicacion" },
            { header: "Perfil", width: 150, sortable: true, dataIndex: "nombre" },
            { header: "Descripcion", width: 250, sortable: true, dataIndex: "descripcion" },
            { header: "Estado", width: 90, sortable: true, dataIndex: "estado" }
        ];

        this.callParent(arguments);

    }
});
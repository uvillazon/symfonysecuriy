/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Opciones.GridOpciones", {
    extend: "App.Config.Abstract.Grid",
    alias: 'widget.gridOpciones',
    title: 'Opciones de Menu',
    criterios: true,
    porPerfil: false,
    classStore: 'App.Store.Opciones.Opciones',
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;
        me.store = Ext.create(me.classStore);

        me.CargarComponentes();
        me.columns = [
            {xtype: "rownumberer", width: 30, sortable: false},
            {header: "Icon", width: 50, sortable: true, dataIndex: "icono", renderer: me.renderIcon},
            {header: "Aplicacion", width: 100, sortable: true, dataIndex: "aplicacion"},
            {header: "Opcion <br> Menu", width: 100, sortable: true, dataIndex: "opcion"},
            {header: "Link(Controller)", width: 150, sortable: true, dataIndex: "link"},
            {header: "Tooltip", width: 200, sortable: true, dataIndex: "tooltip"},
            {header: "Nombre <br> Icon", width: 100, sortable: true, dataIndex: "icono"},
            {header: "Css", width: 100, sortable: true, dataIndex: "estilo"},
            {header: "Orden", width: 70, sortable: true, dataIndex: "orden"},
            {header: "Padre", width: 100, sortable: true, dataIndex: "padre"},
            {header: "Estado", width: 90, sortable: true, dataIndex: "estado"}
        ];

        this.callParent(arguments);

    },
    renderIcon: function (value, metaData, record) {
        return '<img data-qtip="' + value + '", src="' + Constantes.obtenerHost() + '/Content/Iconos/' + value + '.png" />';
    }
});
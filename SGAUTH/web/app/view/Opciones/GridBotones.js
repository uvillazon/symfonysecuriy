/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Opciones.GridBotones", {
    extend: "App.Config.Abstract.Grid",
    alias: 'widget.gridBotones',
    title: 'Botones Por Opcion de Menu',
    //imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    busqueda: true,
    classStore : 'App.Store.Opciones.Botones',
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;
        me.store = Ext.create(me.classStore);
        me.CargarComponentes();
        me.columns = [
            {xtype: "rownumberer", width: 30, sortable: false},
            {header: "Icon", width: 50, sortable: true, dataIndex: "icono", renderer: me.renderIcon},
            {header: "Opcion", width: 100, sortable: true, dataIndex: "opcion"},
            {header: "Nombre<br>Boton", width: 100, sortable: true, dataIndex: "boton"},
            {header: "Tooltip", width: 200, sortable: true, dataIndex: "tooltip"},
            {header: "Item Id", width: 100, sortable: true, dataIndex: "id_item"},
            {header: "Nombre <br> Icon", width: 100, sortable: true, dataIndex: "icono"},
            {header: "Accion", width: 100, sortable: true, dataIndex: "accion"},
            {header: "Css", width: 100, sortable: true, dataIndex: "estilo"},
            {header: "Orden", width: 70, sortable: true, dataIndex: "orden"},
            {header: "Padre", width: 100, sortable: true, dataIndex: "padre"},
            {header: "Estado", width: 90, sortable: true, dataIndex: "estado"}
        ];

        this.callParent(arguments);

    },
    renderIcon: function (value, metaData, record) {
        if (!fn.isEmpty(value)) {
            return '<img data-qtip="' + value + '", src="' + Constantes.obtenerHost() + '/Content/Iconos/' + value + '.png" />';
        }
    }
});
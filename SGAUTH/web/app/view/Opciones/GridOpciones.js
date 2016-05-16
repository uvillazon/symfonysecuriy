/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Opciones.GridOpciones", {
    // extend: "Ext.tree.Panel",
    extend: "App.Config.Abstract.Grid",
    alias: 'widget.gridOpciones',
    title: 'Opciones de Menu',
    criterios: true,
    porPerfil: false,
    reportesHistoricoEstados: false,
    tabla: 'menu_opciones',
    id_tabla: 'id_opc',
    classStore: 'App.Store.Opciones.Opciones',
    // useArrows: true,
    // rootVisible: false,
    // multiSelect: true,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;
        // Ext.define('Task', {
        //     extend: 'Ext.data.TreeModel',
        //     fields: [
        //         {name: 'task',     type: 'string'},
        //         {name: 'user',     type: 'string'},
        //         {name: 'duration', type: 'string'},
        //         {name: 'done',     type: 'boolean'}
        //     ]
        // });
        // var store = Ext.create('Ext.data.TreeStore', {
        //     model: 'Task',
        //     proxy: {
        //         type: 'ajax',
        //         //the store will get the content from the .json file
        //         url: 'treegrid.js'
        //     },
        //     folderSort: true
        // });
        me.store = Ext.create(me.classStore);
        // me.store = store;
        // me.columns =  [{
        //     xtype: 'treecolumn', //this is so we know which column will show the tree
        //     text: 'Task',
        //     width: 200,
        //     sortable: true,
        //     dataIndex: 'task',
        //     locked: true
        // }, {
        //     text: 'Assigned To',
        //     width: 150,
        //     dataIndex: 'user',
        //     sortable: true
        // }, {
        //     xtype: 'checkcolumn',
        //     header: 'Done',
        //     dataIndex: 'done',
        //     width: 40,
        //     stopSelection: false
        // }, {
        //     text: 'Edit',
        //     width: 40,
        //     menuDisabled: true,
        //     xtype: 'actioncolumn',
        //     tooltip: 'Edit task',
        //     align: 'center',
        //     icon: '../simple-tasks/resources/images/edit_task.png',
        //     handler: function(grid, rowIndex, colIndex, actionItem, event, record, row) {
        //         Ext.Msg.alert('Editing' + (record.get('done') ? ' completed task' : '') , record.get('task'));
        //     },
        //     // Only leaf level tasks may be edited
        //     isDisabled: function(view, rowIdx, colIdx, item, record) {
        //         return !record.data.leaf;
        //     }
        // }];

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
        if (record.get('id_aplic') === 1) {
            return '<span class="' + value + '"/>';
        }
        else {
            return '<img data-qtip="' + value + '", src="' + Constantes.obtenerHost() + '/Content/Iconos/' + value + '.png" />';
        }
    }
});
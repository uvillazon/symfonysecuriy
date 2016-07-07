/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.Listas.Listas', {
    extend: 'App.Config.Abstract.Controller',
    classPrincipal: 'App.View.Listas.Principal',
    idCmpBotton: 'cmpButtonAdmListas',
    refs: [{
        ref: 'gridItems',
        selector: '#gridListaItems'
    }],
    init: function () {
        var me = this;
        // opc_cbx_app
        me.control({
            'button[itemId=btn_crear_lista]': {
                click: me.winCrearLista
            }
            ,
            'button[itemId=btn_editar_lista]': {
                click: me.winCrearLista
            }
            ,
            'button[itemId=btn_eliminar_lista]': {
                click: me.eliminarLista
            }
            ,
            'button[itemId=btn_crear_item]': {
                click: me.winCrearItem
            }
            ,
            'button[itemId=btn_editar_item]': {
                click: me.winEditarItem
            }
            ,
            'button[itemId=btn_eliminar_item]': {
                click: me.eliminarItem
            }
        });

        this.callParent();
        me.cargarEventos();
    },
    cargarEventos: function () {
        var me = this;
        me.cmpPrincipal.grid.getSelectionModel().on('selectionchange', me.cargarDatosGrid, this);
        me.getGridItems().getSelectionModel().on('selectionchange', me.cargarDatosGridItem, this);
    },
    cargarDatosGridItem: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        console.log("entro");
        me.recordItem = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_eliminar_item', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_editar_item', me.cmpPrincipal, disabled);
    },
    cargarDatosGrid: function (selModel, selections) {
        var me = this;
        // console.dir(selections);
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editar_lista', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_crear_item', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_eliminar_lista', me.cmpPrincipal, disabled);

        if (!disabled) {
            me.getGridItems().getStore().setExtraParams({id_lista: me.record.get("id_lista") , sort : me.record.get('ordenar_por') , dir : me.record.get('tipo_orden')});
            me.getGridItems().getStore().load();
        }
        else {
            me.getGridItems().getStore().setExtraParams({id_lista: 0});
            me.getGridItems().getStore().load();
        }
    },
    winCrearLista: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Listas.FormLista", {botones: false});
        win.add(form);
        win.show();
        if (btn.getItemId() === "btn_editar_lista") {
            // console.dir(me);
            form.getForm().loadRecord(me.record);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('listas', 'listas', win, form, me.cmpPrincipal.grid, 'Esta Seguro de guardar?', null, win);
        });
    },
    eliminarLista: function () {
        var me = this;
        Funciones.AjaxRequestGrid('listas', 'eliminar_listas', me.cmpPrincipal, 'Esta Seguro de Eliminar', {
            id_lista: me.record.get('id_lista')
        }, me.cmpPrincipal.grid);
    },
    eliminarItem: function () {
        var me = this;
        Funciones.AjaxRequestGrid('listas', 'eliminar_items', me.cmpPrincipal, 'Esta Seguro de Eliminar', {
            id_item: me.recordItem.get('id_item')
        }, me.getGridItems());
    },
    winEditarItem: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Listas.FormItem", {botones: false, record: me.record});
        win.add(form);
        win.show();
        form.getForm().loadRecord(me.recordItem);
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('listas', 'listas_items', win, form, me.getGridItems(), 'Esta Seguro de guardar?', null, win);
        });
    },
    winCrearItem: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Listas.FormItem", {botones: false, record: me.record});
        win.add(form);
        win.show();
        form.getForm().loadRecord(me.record);
        form.cbx_estado.setReadOnly(true);
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('listas', 'listas_items', win, form, me.getGridItems(), 'Esta Seguro de guardar?', null, win);
        });
    }
})
;
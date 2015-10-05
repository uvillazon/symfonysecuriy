/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.Opciones.Opciones', {
    extend: 'App.Config.Abstract.Controller',
    classPrincipal: 'App.View.Opciones.Principal',
    idCmpBotton: 'cmpBotonOpcionesMenu',
    refs: [{
        ref: 'gridBoton',
        selector: '#gridOpcBotones'
    }],
    init: function () {
        var me = this;
        me.control({
            'button[itemId=btn_crearOpcion]': {
                click: me.winCreacion
            },
            'button[itemId=btn_editarOpcion]': {
                click: me.winCreacion
            },
            'button[itemId=btn_crearBoton]': {
                click: me.winCrearBoton
            },
            'button[itemId=btn_editarBoton]': {
                click: me.winCrearBoton
            }
            ,
            '#gridOpcBotones': {
                selectionchange: me.cargarGridBoton
            }
        });

        this.callParent();
        me.cargarEventos();
    },
    cargarEventos: function () {
        var me = this;
        me.cmpPrincipal.grid.getSelectionModel().on('selectionchange', me.cargarDatosGrid, this);

    },
    cargarGridBoton: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.recordBoton = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editarBoton', me.cmpPrincipal, disabled);
    },
    cargarDatosGrid: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editarOpcion', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_crearBoton', me.cmpPrincipal, disabled);
        if (!disabled) {
            me.cmpPrincipal.form.CargarDatos(me.record);
            me.cmpPrincipal.gridBotones.getStore().setExtraParams({id_opc: me.record.get("id_opc")});
            me.cmpPrincipal.gridBotones.getStore().load();
        }
        else {
            me.cmpPrincipal.form.getForm().reset();
            me.cmpPrincipal.gridBotones.getStore().setExtraParams({id_opc: 0});
            me.cmpPrincipal.gridBotones.getStore().load();
        }
    },
    winCreacion: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Opciones.FormOpcion", {botones: false});
        win.add(form);
        win.show();
        if (btn.getItemId() === "btn_editarOpcion") {
            form.getForm().loadRecord(me.record);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('opciones', 'opciones', win, form, me.cmpPrincipal.grid, 'Esta Seguro de guardar?', null, win);
        });

    },
    winCrearBoton: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Opciones.FormBoton", {botones: false});
        win.add(form);
        win.show();
        if(btn.getItemId() === "btn_editarBoton"){
            form.getForm().loadRecord(me.recordBoton);
        }
        form.cargarRecordOpcion(me.record);
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('opciones', 'botones', win, form, me.getGridBoton(), 'Esta Seguro de guardar los Cambios?', null, win);
        });

    }

    ///**
    // * Created by uvillazon on 30/07/2015.
    // */
    //Ext.define('App.controller.Usuarios.Usuarios', {
    //    extend: 'App.Config.Abstract.Controller',
    //    classPrincipal: 'App.View.Usuarios.Principal',
    //    idCmpBotton: 'cmpButton',
    //    init: function () {
    //        var me = this;
    //        me.cargarEventos();
    //        this.callParent();
    //    },
    //    cargarEventos: function(){
    //
    //    }

})
;
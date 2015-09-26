/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.Usuarios.Usuarios', {
    extend: 'App.Config.Abstract.Controller',
    classPrincipal: 'App.View.Usuarios.Principal',
    idCmpBotton: 'cmpButton',
    refs: [{
        ref: 'gridApp',
        selector: '#gridUsrAplicciones'
    }],
    init: function () {
        var me = this;
        me.control({
            'button[itemId=btn_crearUsuario]': {
                click: me.winCrearUsuairo
            },
            'button[itemId=btn_editarUsuario]': {
                click: me.winCrearUsuairo
            },
            'button[itemId=btn_UsrApp]': {
                click: me.winCrearUsrApp
            },
            'button[itemId=btn_QuitarUsrApp]': {
                click: me.quitarUsrApp
            }
            ,
            '#gridUsrAplicciones': {
                selectionchange: me.cargarGridApp
            }
        });

        this.callParent();
        me.cargarEventos();
    },
    quitarUsrApp: function () {

    },
    cargarEventos: function () {
        var me = this;
        me.cmpPrincipal.grid.getSelectionModel().on('selectionchange', me.cargarDatosGrid, this);

    },
    cargarGridApp: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.recordApp = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_QuitarUsrApp', me.cmpPrincipal, disabled);
    },
    cargarDatosGrid: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editarUsuario', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_UsrApp', me.cmpPrincipal, disabled);
        if (!disabled) {
            me.cmpPrincipal.form.CargarDatos(me.record);
            me.cmpPrincipal.gridAplicaciones.getStore().setExtraParams({id_usuario: me.record.get("id_usuario")});
            me.cmpPrincipal.gridAplicaciones.getStore().load();
        }
        else {
            me.cmpPrincipal.form.getForm().reset();
            me.cmpPrincipal.gridAplicaciones.getStore().setExtraParams({id_usuario: 0});
            me.cmpPrincipal.gridAplicaciones.getStore().load();
        }
    },
    winCrearUsuairo: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Usuarios.FormUsuario", {botones: false});
        win.add(form);
        win.show();
        if (btn.getItemId() === "btn_editarUsuario") {
            form.getForm().loadRecord(me.record);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('usuarios', 'usuarios', win, form, me.cmpPrincipal.grid, 'Esta Seguro de guardar el Usuarios', null, win);
        });

    },
    winCrearUsrApp: function () {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Usuarios.FormUsrApp", {botones: false});
        console.dir(form);
        win.add(form);
        win.show();
        form.getForm().loadRecord(me.record);
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('usuarios', 'usuariosapps', win, form, me.getGridApp(), 'Esta Seguro de guardar el Usuarios', null, win);
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
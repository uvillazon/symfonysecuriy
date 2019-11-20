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
            'button[itemId=btn_Edit_UsrApp]': {
                click: me.winEditUsrApp
            },
            'button[itemId=btn_QuitarUsrApp]': {
                click: me.quitarUsrApp
            },
            'button[itemId=btn_firma_electronica]': {
                click: me.onFirmaElectronica
            },
            '#gridUsrAplicciones': {
                selectionchange: me.cargarGridApp
            }
        });

        this.callParent();
        me.cargarEventos();
    },
    onFirmaElectronica: function () {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Usuarios.FormFirmaDigital", {botones: false});
        win.add(form);
        win.show();
        form.getForm().loadRecord(me.record);
        win.btn_guardar.on('click', function () {
            fn.getRequestAjax("usuarios/certificado", form, 'POST').then({
                success: function (res) {
                    if (res.success) {
                        win.close();
                        me.cmpPrincipal.grid.getStore().load();
                        Ext.Msg.alert("Exito", res.msg);
                    }
                    else {
                        Ext.Msg.alert("Error", res.msg);

                    }
                    // return notificationService.success("Success", res.msg);
                },
                failure: function (errorMessage) {
                    Ext.Msg.alert("Error", errorMessage);
                    // return notificationService.error("Error", errorMessage);
                }
            }).always(function () {
                return win.setLoading(false);
            });

            // fn.getRequestAjax(accion, form, method, params, validUpload).then({
            //
            // });
            // Funciones.AjaxRequestWin('usuarios', 'usuariosapps', win, form, me.getGridApp(), 'Esta Seguro de guardar el Usuarios', null, win);
        });
        //
    },
    quitarUsrApp: function () {
        var me = this;
        Funciones.AjaxRequestGrid('usuarios', 'eliminars/usuariosapps', me.cmpPrincipal, 'Esta Seguro de Eliminar', {
            id_perfil: me.recordApp.get('id_perfil'),
            id_aplic: me.recordApp.get('id_aplic'),
            id_usuario: me.recordApp.get('id_usuario')
        }, me.getGridApp());

        // console.log(me.recordApp);
        // Ext.Msg.alert("Aviso", "Se esta implementando esta opcion...");
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
        Funciones.DisabledButton('btn_Edit_UsrApp', me.cmpPrincipal, disabled);
    },
    cargarDatosGrid: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editarUsuario', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_UsrApp', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_firma_electronica', me.cmpPrincipal, disabled);
        if (!disabled) {
            me.cmpPrincipal.form.CargarDatos(me.record);
            me.cmpPrincipal.gridAplicaciones.getStore().setExtraParams({
                id_usuario: me.record.get("id_usuario"),
                mostrar_todos: "SI",
                // mostrar_todos: Constantes.APLICACION.codigo === "SGAUTH" ? "SI" : "NO"
            });
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
        var btn12 = Ext.ComponentQuery.query('#btn_crearUsuario');
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
        form.cbx_estado.setReadOnly(true);
        win.add(form);
        win.show();
        form.getForm().loadRecord(me.record);
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('usuarios', 'usuariosapps', win, form, me.getGridApp(), 'Esta Seguro de guardar el Usuarios', null, win);
        });

    },
    winEditUsrApp: function () {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Usuarios.FormUsrApp", {
            botones: false,
            title: 'Edicion de Datos Usuario por aplicacion'
        });
        win.add(form);
        win.show();
        form.cargarDatosEdicion(me.recordApp);
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('usuarios', 'usuariosapps', win, form, me.getGridApp(), 'Esta Seguro de guardar el Usuarios', null, win);
        });
    }
})
;
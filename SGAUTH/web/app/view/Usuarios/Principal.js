/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Usuarios.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        //me.CargarEventos();
        this.callParent(arguments);
    },
    //CargarEventos: function () {
    //    var me = this;
    //    me.grid.getSelectionModel().on('selectionchange', me.CargarDatosGrid, this);
    //
    //    Ext.ComponentQuery.query('#btn_crearUsuario')[0].on('click', me.WinCrearUsuairo, this);
    //    Ext.ComponentQuery.query('#btn_editarUsuario')[0].on('click', me.WinCrearUsuairo, this);
    //    Ext.ComponentQuery.query('#btn_UsrApp')[0].on('click', me.WinUsrApp, this);
    //},
    //WinCrearUsuairo: function (btn) {
    //    var me = this;
    //    var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
    //    var form = Ext.create("App.View.Usuarios.FormUsuario", {botones: false});
    //    win.add(form);
    //    win.show();
    //    if (btn.getItemId() === "btn_editarUsuario") {
    //        form.getForm().loadRecord(me.record);
    //    }
    //    win.btn_guardar.on('click', function () {
    //        Funciones.AjaxRequestWin('usuarios', 'usuarios', win, form, me.grid, 'Esta Seguro de guardar el Usuarios', null, win);
    //    });
    //
    //},
    //CargarDatosGrid: function (selModel, selections) {
    //    var me = this;
    //    disabled = selections.length === 0;
    //    me.record = !disabled ? selections[0] : null;
    //    Funciones.DisabledButton('btn_editarUsuario', me, disabled);
    //    Funciones.DisabledButton('btn_UsrApp', me, disabled);
    //    if (!disabled) {
    //        me.form.CargarDatos(me.record);
    //        me.gridAplicaciones.getStore().setExtraParams({id_usuario: me.record.get("id_usuario")});
    //        me.gridAplicaciones.getStore().load();
    //    }
    //    else {
    //        me.form.getForm().reset();
    //        me.gridAplicaciones.getStore().setExtraParams({id_usuario: 0});
    //        me.gridAplicaciones.getStore().load();
    //    }
    //
    //},
    CargarComponentes: function () {
        var me = this;
        me.grid = Ext.create('App.View.Usuarios.GridUsuarios', {
            width: '100%',
            region: 'center',
            borrarParametros: true,
        });
        var cmpButton  = Ext.create("Ext.Toolbar",{
            width: '100%',
            height : 50,
            region: 'north',
            itemId: 'cmpButton',
            layout: {
                overflowHandler: 'Menu'
            },
        });
        var panelCentral = Ext.create("App.Config.Abstract.FormPanel",
            {
                region: 'west',
                width: '50%',
                frame: false,
                layout: 'border',
                items: [
                    //toolbar,
                    cmpButton,
                    me.grid
                ]
            }
        )
        me.panel = me.form = Ext.create("App.Config.Abstract.FormPanel");

        me.form = Ext.create("App.View.Usuarios.FormUsuario");
        me.form.BloquearFormulario();

        me.gridAplicaciones = Ext.create("App.View.Usuarios.GridAplicacionesPorUsuario", {
            width: '100%',
            itemId: 'gridUsrAplicciones',
            cargarStore: false
        });

        me.panel.add(me.form, me.gridAplicaciones);

        me.items = [panelCentral, me.panel];
    }
})
;

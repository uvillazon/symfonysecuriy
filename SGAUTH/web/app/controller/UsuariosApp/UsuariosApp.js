/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.UsuariosApp.UsuariosApp', {
    extend: 'App.Config.Abstract.Controller',
    classPrincipal: 'App.View.UsuariosApp.Principal',
    idCmpBotton: 'cmpButtonUserApp',
    refs: [{
        ref: 'gridApp',
        selector: '#gridUsrArea'
    }],
    init: function () {
        var me = this;
        me.control({
            'button[itemId=btn_agregar_area_usr]': {
                click: me.winCrearAreaUsuario
            },
            'button[itemId=btn_quitar_area_usr]': {
                click: me.quitarUsrArea
            }
            ,
            '#gridUsrArea': {
                selectionchange: me.cargarGridArea
            }
        });

        this.callParent();
        me.cargarEventos();
    },
    quitarUsrArea: function () {
        // Ext.Msg.alert("Aviso","Se esta implementando esta opcion...");
        var me = this;
        Funciones.AjaxRequestGrid('usuarios', 'usuarios_areas/eliminar', me.cmpPrincipal, 'Esta Seguro de Eliminar', {
            id: me.recordApp.get('id_usr_area'),

        }, me.cmpPrincipal.gridAplicaciones);
    },
    cargarEventos: function () {
        var me = this;
        me.cmpPrincipal.grid.getSelectionModel().on('selectionchange', me.cargarDatosGrid, this);

    },
    cargarGridArea: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.recordApp = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_quitar_area_usr', me.cmpPrincipal, disabled);
    },
    cargarDatosGrid: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_agregar_area_usr', me.cmpPrincipal, disabled);
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
    winCrearAreaUsuario: function () {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.UsuariosApp.FormUsrArea", {botones: false});
        // console.dir(form);
        win.add(form);
        win.show();
        form.getForm().loadRecord(me.record);
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('usuarios', 'usuarios_areas', win, form, me.getGridApp(), 'Esta Seguro de guardar el Area al usuario', null, win);
        });

    }


})
;
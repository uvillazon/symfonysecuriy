/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.Aplicaciones.Aplicaciones', {
    extend: 'App.Config.Abstract.Controller',
    classPrincipal: 'App.View.Aplicaciones.Principal',
    idCmpBotton: 'cmpButtonApp',
    refs: [{
        ref: 'gridUser',
        selector: '#gridAppUsr'
    }],
    init: function () {
        var me = this;
        // opc_cbx_app
        me.control({
            'button[itemId=btn_crear_app]': {
                click: me.winCrearApp
            }
            ,
            'button[itemId=btn_editar_app]': {
                click: me.winCrearApp
            }
        });

        this.callParent();
        me.cargarEventos();
    },
    cargarEventos: function () {
        var me = this;
        me.cmpPrincipal.grid.getSelectionModel().on('selectionchange', me.cargarDatosGrid, this);


    },
    cargarDatosGrid: function (selModel, selections) {
        var me = this;
        console.dir(selections);
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editar_app', me.cmpPrincipal, disabled);
        if (!disabled) {
            me.cmpPrincipal.form.CargarDatos(me.record);
            me.getGridUser().getStore().setExtraParams({id_aplic: me.record.get("id_aplic")});
            me.getGridUser().getStore().load();
        }
        else {
            me.cmpPrincipal.form.getForm().reset();
            me.getGridUser().getStore().setExtraParams({id_aplic: 0});
            me.getGridUser().getStore().load();
        }
    },
    winCrearApp: function (btn) {
        var me = this;
        if (btn.getItemId() === "btn_crear_app" &&  !(Constantes.APLICACION.codigo === "SGAUTH")) {
            return Ext.Msg.alert("Advertencia","Opción habilitada para la administración de la aplicación SGAUTH");
        }
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Aplicaciones.FormAplicacion", {botones: false});
        win.add(form);
        win.show();
        if (btn.getItemId() === "btn_editar_app") {
            form.getForm().loadRecord(me.record);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('aplicaciones', 'aplicaciones', win, form, me.cmpPrincipal.grid, 'Esta Seguro de guardar?', null, win);
        });
    }
})
;
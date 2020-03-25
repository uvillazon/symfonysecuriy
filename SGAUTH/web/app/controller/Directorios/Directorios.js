/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.Directorios.Directorios', {
    extend: 'App.Config.Abstract.Controller',
    classPrincipal: 'App.View.Directorios.Principal',
    idCmpBotton: 'cmpButtonAdmDirectorio',
    refs: [
        {
            ref: 'gridGrupos',
            selector: '#gridGrupos'
        },
        {
            ref: 'gridGrpDest',
            selector: '#gridGruposDest'
        }
    ],
    init: function () {
        var me = this;
        me.control({
            'button[itemId=btn_crear_destinatario]': {
                click: me.winCrearDestinatario
            }
            ,
            'button[itemId=btn_editar_destinatario]': {
                click: me.winCrearDestinatario
            }
            ,
            'button[itemId=btn_crear_grupo]': {
                click: me.winCrearGrupo
            }
            ,
            'button[itemId=btn_editar_grupo]': {
                click: me.winCrearGrupo
            }
            ,
            '#btn_agregar_dest_grupo': {
                click: me.winCrearGrupoDest
            }
            ,
            '#btn_quitar_dest_grupo': {
                click: me.eliminarGrupoDest
            }
        });

        this.callParent();
        me.cargarEventos();
    },
    cargarEventos: function () {
        var me = this;
        me.cmpPrincipal.grid.getSelectionModel().on('selectionchange', me.cargarDatosGrid, this);
        me.getGridGrupos().getSelectionModel().on('selectionchange', me.cargarDatosGridGrupo, this);
        me.getGridGrpDest().getSelectionModel().on('selectionchange', me.cargarDatosGridGrupoDest, this);
    },
    cargarDatosGridGrupoDest: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.recordGrupoDest = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_quitar_dest_grupo', me.cmpPrincipal, disabled);

    },
    cargarDatosGridGrupo: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.recordGrupo = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editar_grupo', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_agregar_dest_grupo', me.cmpPrincipal, disabled);
        if (!disabled) {
            me.getGridGrpDest().getStore().setExtraParams({id_grp: me.recordGrupo.get("id_grp"), id_dest: null});
            me.getGridGrpDest().getStore().load();
            me.cmpPrincipal.grid.getSelectionModel().deselectAll();
        }
    },
    cargarDatosGrid: function (selModel, selections) {
        var me = this;
        console.dir(selections);
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editar_destinatario', me.cmpPrincipal, disabled);
        if (!disabled) {
            me.getGridGrpDest().getStore().setExtraParams({id_dest: me.record.get("id_dest"), id_grp: null});
            me.getGridGrpDest().getStore().load();
            me.getGridGrupos().getSelectionModel().deselectAll();
        }
    },
    winCrearDestinatario: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Directorios.FormDestinatario", {botones: false});
        win.add(form);
        win.show();
        if (btn.getItemId() === "btn_editar_destinatario") {
            // console.dir(me);
            form.getForm().loadRecord(me.record);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('directorios', 'destinatarios', win, form, me.cmpPrincipal.grid, 'Esta Seguro de guardar?', null, win);
        });
    },
    winCrearGrupo: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Directorios.FormGrupo", {botones: false});
        win.add(form);
        win.show();
        if (btn.getItemId() === "btn_editar_grupo") {
            // console.dir(me);
            form.getForm().loadRecord(me.recordGrupo);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('directorios', 'grupos', win, form, me.getGridGrupos(), 'Esta Seguro de guardar?', null, win);
        });
    },
    winCrearGrupoDest: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Directorios.FormGrupoDest", {botones: false});
        win.add(form);
        win.show();
        form.getForm().loadRecord(me.recordGrupo);
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('directorios', 'destGrupos', win, form, me.getGridGrpDest(), 'Esta Seguro de guardar?', null, win);
        });
    },
    eliminarGrupoDest: function () {
        var me = this;
        Ext.MessageBox.confirm('Confirmacion?', "Esta Seguro de Eliminar", function (btn) {
            if (btn == 'yes') {
                me.recordGrupoDest.erase({
                    failure: function (record, operation) {
                        console.log(operation);
                        Ext.MessageBox.alert('Error', "Ocurrio algun error consulte con TI");
                    },
                    success: function (record, operation) {
                        console.log(operation);
                        Ext.MessageBox.alert('Exito', "proceso ejecutado correctamente");
                        // do something if the erase succeeded
                    }

                });

                // console.dir(me.recordGrupoDest);
                // Funciones.AjaxRequestGrid('directorios', 'destGrupos', me.cmpPrincipal, 'Esta Seguro de Eliminar', {
                //     id_lista: me.record.get('id_lista')
                // }, me.cmpPrincipal.grid);
            }

        });
    }
});
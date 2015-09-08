/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Aplicaciones.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    alias: "widget.PrincipalSolicitudes",
    itemIdCmpBto: '',
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        me.CargarEventos();
        this.callParent(arguments);
    },
    CargarEventos: function () {
        var me = this;
        me.grid.getSelectionModel().on('selectionchange', me.CargarDatosGrid, this);

        Ext.ComponentQuery.query('#btn_crearApp')[0].on('click', me.WinCrearUsuairo, this);
        Ext.ComponentQuery.query('#btn_editarApp')[0].on('click', me.WinCrearUsuairo, this);
    } ,
    WinCrearUsuairo : function(btn){
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", { botones: true, destruirWin: true });
        var form = Ext.create("App.View.Aplicaciones.FormAplicacion",{botones : false});
        win.add(form);
        win.show();
        if(btn.getItemId() === "btn_editarApp"){
            form.getForm().loadRecord(me.record);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('aplicaciones', 'aplicaciones', win, form, me.gird, 'Esta Seguro de guardar?', null, win);
        });

    },
    CargarDatosGrid: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editarApp', me, disabled);
        if (!disabled) {
            me.form.CargarDatos(me.record);
            me.gridAplicaciones.getStore().setExtraParams({id_aplic: me.record.get("id_aplic")});
            me.gridAplicaciones.getStore().load();
        }
        else {
            me.form.getForm().reset();
            me.gridAplicaciones.getStore().setExtraParams({id_aplic: 0});
            me.gridAplicaciones.getStore().load();
        }

    },
    CargarComponentes: function () {
        var me = this;

        me.grid = Ext.create('App.View.Aplicaciones.GridAplicaciones', {
            width: '100%',
            region: 'center',
            borrarParametros: true,
        });
        var toolbar = this.buildMenuBar();
        var panelCentral = Ext.create("App.Config.Abstract.FormPanel",
            {
                region: 'west',
                width: '50%',
                frame: false,
                layout: 'border',
                items: [
                    toolbar,
                    me.grid
                ]
            }
        )
        me.panel = me.form = Ext.create("App.Config.Abstract.FormPanel");

        me.form = Ext.create("App.View.Aplicaciones.FormAplicacion");
        me.form.BloquearFormulario();

        me.gridAplicaciones = Ext.create("App.View.Aplicaciones.GridAplicacionesPorUsuario", {
            width: '100%',

            cargarStore: false
        });

        me.panel.add(me.form, me.gridAplicaciones);

        me.items = [panelCentral, me.panel];
    }
    ,
    buildMenuBar: function () {

        return Ext.create('Ext.Toolbar', {
            region: 'north',
            items: [
                {
                    text: 'Crear',
                    scale: 'large',
                    iconCls: 'page_add',
                    itemId: 'btn_crearApp'
                },
                {
                    text: 'Editar',
                    scale: 'large',
                    iconCls: 'page_edit',
                    arrowAlign: 'bottom',
                    itemId: 'btn_editarApp',
                    disabled: true
                }
            ]
        });
    }
})
;

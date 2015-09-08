/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Perfiles.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    alias: "widget.PrincipalSolicitudes",
    view: '',
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

        Ext.ComponentQuery.query('#btn_crearPerfil')[0].on('click', me.WinCrearUsuairo, this);
        Ext.ComponentQuery.query('#btn_editarPerfil')[0].on('click', me.WinCrearUsuairo, this);
    } ,
    WinCrearUsuairo : function(btn){
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", { botones: true, destruirWin: true });
        var form = Ext.create("App.View.Perfiles.FormPerfil",{botones : false});
        win.add(form);
        win.show();
        if(btn.getItemId() === "btn_editarPerfil"){
            form.getForm().loadRecord(me.record);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('perfiles', 'perfiles', win, form, me.grid, 'Esta Seguro de guardar el Usuarios', null, win);
        });

    },
    CargarDatosGrid: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editarPerfil', me, disabled);
        if (!disabled) {
            me.form.CargarDatos(me.record);

        }
        else {
            me.form.getForm().reset();

        }

    },
    CargarComponentes: function () {
        var me = this;

        me.grid = Ext.create('App.View.Perfiles.GridPerfiles', {
            width: '100%',
            region: 'center',
            itemId: 'grid123',
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

        me.form = Ext.create("App.View.Perfiles.FormPerfil");
        me.form.BloquearFormulario();

        me.panel.add(me.form);

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
                    iconCls: 'user_add',
                    itemId: 'btn_crearPerfil'
                },
                {
                    text: 'Editar',
                    scale: 'large',
                    iconCls: 'user_edit',
                    arrowAlign: 'bottom',
                    itemId: 'btn_editarPerfil',
                    disabled: true
                }
            ]
        });
    }
})
;

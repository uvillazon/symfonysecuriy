/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Perfiles.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    requires: [
        "App.View.Opciones.GridBotones",
        "App.View.Opciones.GridOpciones"
    ],
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;
        var cmpButton  = Ext.create("Ext.Toolbar",{
            width: '100%',
            height : 50,
            region: 'north',
            itemId: 'cmpButtonPerfil',
            layout: {
                overflowHandler: 'Menu'
            },
        });
        me.store_app = Ext.create("App.Store.Aplicaciones.Aplicaciones");
        me.store_app.load();
        me.cbx_app = Ext.create("App.Config.Componente.ComboBase", {
            displayField: 'nombre',
            valueField: 'id_aplic',
            name: 'id_aplic',
            emptyText: 'Seleccione Aplicacion',
            width: 150,
            itemId : 'per_cbx_app',
            store: me.store_app
        });
        me.grid = Ext.create('App.View.Perfiles.GridPerfiles', {
            width: '100%',
            region: 'center',
            itemId: 'grid123',
            borrarParametros: true,
        });
        me.grid.AgregarBtnToolbar(me.cbx_app);

        //me.grid.addDocked(me.cbx_app, 1);
        var panelCentral = Ext.create("App.Config.Abstract.FormPanel",
            {
                region: 'west',
                width: '50%',
                frame: false,
                layout: 'border',
                items: [
                    cmpButton,
                    me.grid
                ]
            }
        );
        var tabPanel = Ext.create('Ext.tab.Panel', {
            items: [
                {
                    xtype: 'gridOpciones',
                    itemId : 'gridOpcionesPerfil',
                    classStore : 'App.Store.Opciones.OpcionesPerfil',
                    cargarStore : false,
                    busqueda: true,
                },
                {
                    xtype: 'gridBotones',
                    itemId : 'gridBotonesPerfil',
                    cargarStore : false,
                    classStore : 'App.Store.Opciones.BotonesPerfil'
                }
            ]
        });
        me.panel = me.form = Ext.create("App.Config.Abstract.FormPanel");

        me.form = Ext.create("App.View.Perfiles.FormPerfil");
        me.form.BloquearFormulario();

        me.panel.add(me.form);
        me.panel.add(tabPanel);

        me.items = [panelCentral, me.panel];
    }
})
;

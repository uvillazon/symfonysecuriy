/**
 * Created by uvillazon on 30/07/2016.
 */
Ext.define("App.View.Perfiles.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    requires: [
        "App.View.Opciones.GridBotones",
        "App.View.Opciones.GridOpciones",
        "App.View.Aplicaciones.GridAplicacionesPorUsuario"
    ],
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;
        var cmpButton = Ext.create("Ext.Toolbar", {
            width: '100%',
            height: 50,
            region: 'north',
            itemId: 'cmpButtonPerfil',
            layout: {
                overflowHandler: 'Menu'
            },
        });

        me.btn_historico_cambios = Ext.create('Ext.Button', {
            pressed: true,
            iconCls: 'clock',
            tooltip: 'Historicos de Asociacio de Menu al Perfil',
            itemId: 'btn_hist_perfiles',
            //enableToggle: true,
            scope: this,
            text: 'Hist. Asociacion',
            tooltipType: 'qtip'


        });
        me.grid = Ext.create('App.View.Perfiles.GridPerfiles', {
            width: '100%',
            region: 'center',
            itemId: 'grid123',
            borrarParametros: true,
        });
        me.grid.AgregarBtnToolbar(me.btn_historico_cambios);

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
                    xtype: 'gridUsuariosApp',
                    itemId: 'gridUsuarioPerfil',
                    title:'Usuarios Por Perfil',
                    cargarStore: false,
                    busqueda: true,
                    reportesHistoricoEstados: true,
                    imprimir: true
                },
                {
                    xtype: 'gridOpciones',
                    itemId: 'gridOpcionesPerfil',
                    classStore: 'App.Store.Opciones.OpcionesPerfil',
                    cargarStore: false,
                    busqueda: true,
                    reportesHistoricoEstados: true,
                    imprimir: true
                },
                {
                    xtype: 'gridBotones',
                    itemId: 'gridBotonesPerfil',
                    cargarStore: false,
                    classStore: 'App.Store.Opciones.BotonesPerfil',
                    reportesHistoricoEstados: true,
                    imprimir: true
                }
            ]
        });
        me.panel = me.form = Ext.create("App.Config.Abstract.FormPanel");

        // console.log(Constantes);
        // if (Constantes.APLICACION.codigo === "SGAUTH") {
        var gridAplicaciones = Ext.create("App.View.Aplicaciones.GridAplicaciones", {
            cargarStore: false,
            itemId: 'gridAplicacionPerfil',
            classStore: 'App.Store.Perfiles.Aplicaciones',
            busqueda: true,
            reportesHistoricoEstados: true,
            imprimir: true,
            hidden: !(Constantes.APLICACION.codigo === "SGAUTH")
        });
        tabPanel.add(gridAplicaciones);
        // }

        me.form = Ext.create("App.View.Perfiles.FormPerfil");
        me.form.BloquearFormulario();

        me.panel.add(me.form);
        me.panel.add(tabPanel);

        me.items = [panelCentral, me.panel];
    }
})
;

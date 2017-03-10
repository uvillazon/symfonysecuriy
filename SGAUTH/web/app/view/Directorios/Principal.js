/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Directorios.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;

        me.grid = Ext.create('App.View.Directorios.GridDestinatarios', {
            width: '100%',
            region: 'center',
            borrarParametros: true,
        });
        var cmpButton  = Ext.create("Ext.Toolbar",{
            width: '100%',
            height : 50,
            region: 'north',
            itemId: 'cmpButtonAdmDirectorio',
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
                    cmpButton,
                    me.grid
                ]
            }
        )
        me.panel = me.form = Ext.create("App.Config.Abstract.FormPanel");



        me.gridItems = Ext.create("App.View.Directorios.GridGrupos", {
            width: '100%',
            itemId : 'gridGrupos',
            cargarStore: true
        });

        me.gridGrupoDest  = Ext.create("App.View.Directorios.GridGruposDest",{
            width: '100%',
            itemId : 'gridGruposDest',
            cargarStore: false

        });
        me.panel.add(me.gridItems , me.gridGrupoDest);

        me.items = [panelCentral, me.panel];
    }
})
;

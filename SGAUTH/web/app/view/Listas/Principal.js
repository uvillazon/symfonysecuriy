/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Listas.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;

        me.grid = Ext.create('App.View.Listas.GridListas', {
            width: '100%',
            region: 'center',
            borrarParametros: true,
        });
        var cmpButton  = Ext.create("Ext.Toolbar",{
            width: '100%',
            height : 50,
            region: 'north',
            itemId: 'cmpButtonAdmListas',
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



        me.gridItems = Ext.create("App.View.Listas.GridListasItems", {
            width: '100%',
            itemId : 'gridListaItems',
            cargarStore: false
        });

        me.panel.add(me.gridItems);

        me.items = [panelCentral, me.panel];
    }
})
;

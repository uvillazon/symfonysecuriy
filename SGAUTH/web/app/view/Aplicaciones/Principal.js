/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Aplicaciones.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;

        me.grid = Ext.create('App.View.Aplicaciones.GridAplicaciones', {
            width: '100%',
            region: 'center',
            borrarParametros: true,
        });
        var cmpButton  = Ext.create("Ext.Toolbar",{
            width: '100%',
            height : 50,
            region: 'north',
            itemId: 'cmpButtonApp',
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

        me.form = Ext.create("App.View.Aplicaciones.FormAplicacion");
        me.form.BloquearFormulario();

        me.gridAplicaciones = Ext.create("App.View.Aplicaciones.GridAplicacionesPorUsuario", {
            width: '100%',
            itemId : 'gridAppUsr',
            cargarStore: false
        });

        me.panel.add(me.form, me.gridAplicaciones);

        me.items = [panelCentral, me.panel];
    }
})
;

/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Opciones.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;
        me.grid = Ext.create('App.View.Opciones.GridOpciones', {
            region: 'west',
            width: '50%'
        });
        var cmpButton  = Ext.create("Ext.Toolbar",{
            width: '100%',
            height : 55,
            padding : 2,
            itemId: 'cmpBotonOpcionesMenu',
            layout: {
                overflowHandler: 'Menu'
            },
        });
        me.panel = me.form = Ext.create("App.Config.Abstract.FormPanel");

        me.form = Ext.create("App.View.Opciones.FormOpcion");
        me.form.BloquearFormulario();

        me.gridBotones = Ext.create("App.View.Opciones.GridBotones", {
            width: '100%',
            itemId: 'gridOpcBotones',
            cargarStore: false
        });

        me.panel.add( cmpButton ,me.form,  me.gridBotones);

        me.items = [me.grid, me.panel];
    }
})
;

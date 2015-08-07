/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Usuarios.Principal", {
    extend: "App.Config.Abstract.PanelPrincipal",
    alias: "widget.PrincipalSolicitudes",
    controlador: 'Usuarios',
    accionGrabar: 'GrabarUsuario',
    view: '',
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;
        me.grid = Ext.create('App.View.Usuarios.GridUsuarios', {
            region: 'west',
            width: '50%',
            borrarParametros: true,
        });
        /* me.formulario = Ext.create("App.View.Usuarios.FormUsuarios");

         me.formulario.BloquearFormulario();
         me.items = [me.grid, me.formulario];
         me.grid.on('cellclick', me.CargarDatos, this);*/
        me.form = Ext.create("App.Config.Abstract.FormPanel");

        //me.formulario = Ext.create("App.View.Usuarios.FormUsuarios");
        //me.formulario.BloquearFormulario();
        //
        //me.form.add(me.formulario);
        var toolbar= this.buildMenuBar();
        me.items = [toolbar, me.grid, me.form];
    },
    buildMenuBar: function(){

        return Ext.create('Ext.Toolbar',{
            region : 'north',
            maxWidth : 800,
           items: [
               {
                   xtype:'splitbutton',
                   text: 'Menu Button',
                   iconCls: 'add16',
                   menu: [{text: 'Menu Button 1'}]
               },'-',{
                   xtype:'splitbutton',
                   text: 'Cut',
                   iconCls: 'add16',
                   menu: [{text: 'Cut Menu Item'}]
               },{
                   text: 'Copy',
                   iconCls: 'add16'
               },{
                   text: 'Paste',
                   iconCls: 'add16',
                   menu: [{text: 'Paste Menu Item'}]
               },'-',{
                   text: 'Format',
                   iconCls: 'add16'
               },
               {
                   xtype:'splitbutton',
                   text: 'Menu Button',
                   iconCls: 'add16',
                   menu: [{text: 'Menu Button 1'}]
               },'-',{
                   xtype:'splitbutton',
                   text: 'Cut',
                   iconCls: 'add16',
                   menu: [{text: 'Cut Menu Item'}]
               },{
                   text: 'Copy',
                   iconCls: 'add16'
               },{
                   text: 'Paste',
                   iconCls: 'add16',
                   menu: [{text: 'Paste Menu Item'}]
               },'-',{
                   text: 'Format',
                   iconCls: 'add16'
               },
               {
                   xtype:'splitbutton',
                   text: 'Menu Button',
                   iconCls: 'add16',
                   menu: [{text: 'Menu Button 1'}]
               },'-',{
                   xtype:'splitbutton',
                   text: 'Cut',
                   iconCls: 'add16',
                   menu: [{text: 'Cut Menu Item'}]
               },{
                   text: 'Copy',
                   iconCls: 'add16'
               },{
                   text: 'Paste',
                   iconCls: 'add16',
                   menu: [{text: 'Paste Menu Item'}]
               },'-',{
                   text: 'Format',
                   iconCls: 'add16'
               },
               {
                   xtype:'splitbutton',
                   text: 'Menu Button',
                   iconCls: 'add16',
                   menu: [{text: 'Menu Button 1'}]
               },'-',{
                   xtype:'splitbutton',
                   text: 'Cut',
                   iconCls: 'add16',
                   menu: [{text: 'Cut Menu Item'}]
               },{
                   text: 'Copy',
                   iconCls: 'add16'
               },{
                   text: 'Paste',
                   iconCls: 'add16',
                   menu: [{text: 'Paste Menu Item'}]
               },'-',{
                   text: 'Format',
                   iconCls: 'add16'
               }
           ]
        });
    }
});

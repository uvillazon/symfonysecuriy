/**
 * @class Bleext.abstract.Controller
 * @extends Ext.app.Controller
 * requires
 * @autor Crysfel Villa
 * @date Tue Aug  9 18:07:06 CDT 2011
 *
 * Basic controller, this class set the handlers to the default buttons in
 * the topbar of each class that extends from Bleext.abstract.Viewport, this class
 * also override the "control" method to add the "id" of the window.
 *
 **/

Ext.define("App.Config.Abstract.Controller", {
    extend: "Ext.app.Controller",

    /**
     * datos del menu de opciones
     */
    datosTab: null,

    /**
     * componente donde estanran las opciones  por menu
     */
    idCmpBotton: null,

    /**
     * componente principal
     */
    cmpPrincipal : null,

    /**
     * @cfg {Bleext.desktop.Window} win The main window for this module
     */

    /**
     * @cfg {Object} selectors Object of selectors, used for remove the listeners from the event bus when module is destroyed
     */

    //private
    init: function () {

        var me = this,
            actions = {};


        me.setViewport();
        me.setCmpButton();
        this.callParent();
        //me.control({
        //	"button[action=new]"	: {
        //		click		: me.add
        //	},
        //	"button[action=save]" : {
        //		click		: me.save
        //	},
        //	"button[action=delete]" : {
        //		click		: me.remove
        //	}
        //});
    },
    /**
     * funcion que formara dinamicamente los botones
     */
    setCmpButton : function(){
        var me = this;
        if(me.idCmpBotton != null){
            var cmp = Ext.ComponentQuery.query('#'+me.idCmpBotton)[0];
            me.getMenuBar(cmp,this.datosTab.botones);
            //cmp.add(
            //    [
            //        {
            //            text: 'Crear',
            //            scale: 'large',
            //            iconCls: 'user_add',
            //            itemId: 'btn_crearUsuario',
            //            accion: 'crear'
            //        }
            //    ]
            //);
            //[
            //    {
            //        text: 'Crear',
            //        scale: 'large',
            //        iconCls: 'user_add',
            //        itemId: 'btn_crearUsuario',
            //        accion : 'crear'
            //    }
        }
    },

    /**
     * funcion que crea dinamicamente los botones segun los datosTab
     *
     */
    getMenuBar: function(tb,data){
        var me = this;
        //console.dir(data);
        Ext.each(data, function (menu) {
            if (menu.subBotones) {
                var subMenu = Ext.create('Ext.menu.Menu');
                //alert(menu.text);
                tb.add({
                    text: menu.nombre,
                    titulo: menu.nombre,
                    iconCls: menu.icono,
                    tooltip: menu.tooltip,
                    accion: menu.accion,
                    itemId : menu.id_item,
                    disabled : menu.disabled,
                    datos: menu,
                    scale: 'medium',
                    menu: subMenu
                });
                //console.dir(menu.subBotones);
                me.getMenuBar(subMenu, menu.subBotones);
            }
            else {
                tb.add({
                    text: menu.nombre,
                    titulo: menu.nombre,
                    iconCls: menu.icono,
                    tooltip: menu.tooltip,
                    accion: menu.accion,
                    itemId : menu.id_item,
                    disabled : menu.disabled,
                    scale: 'medium',
                    datos: menu
                });
            }
        });

    },
    /**
     * This method add the window id to the selectors, this way we can create more the one
     * instance of the same window.
     * @param {Object} actions An object with the selectors
     */
    //control: function (actions) {
    //    var me = this;
    //    console.dir(actions);
    //    //if(Ext.isObject(actions)){
    //    //	var obj = {};
    //    //	Ext.Object.each(actions,function(selector){
    //    //		var s = "#"+this.win.id+" "+selector;
    //    //		obj[s] = actions[selector];
    //    //	},this);
    //    //	delete actions;
    //    //
    //    //	if (!me.selectors){
    //    //		me.selectors = [];
    //    //	}
    //    //	me.selectors.push(obj);
    //    //
    //    //	this.callParent([obj]);
    //    //}else{
    //    //	this.callParent(arguments);
    //    //}
    //},

    /**
     * This method display an error message in the status bar of the main window
     * @param {String} msg The message to display
     */
    showError: function (msg) {
        this.win.statusBar.setStatus({
            text: msg,
            iconCls: "x-status-error"
        });
    },

    /**
     * This method display a success message in the status bar of the main window
     * @param {String} msg The message to display
     */
    showMessage: function (msg) {
        this.win.statusBar.setStatus({
            text: msg,
            iconCls: "x-status-valid"
        });
    },

    /**
     * An abstract method to be implemented in the subclass, this method is executed
     * in the "init" method of the controller, the idea is to set the content of the main
     * window.
     *

     setViewport    : function(){
		this.win.add(Ext.create("Ext.panel.Panel",{html:"Hello world!"}));		
	}

     *
     */
    setViewport: function () {
        this.show();
    },
    /**
     * An abstract method. This method is executed when the user clicks in any button
     * withing the main window than contain a property "action" equals to "new".
     *
     */
    add: Ext.emptyFn,
    /**
     * An abstract method. This method is executed when the user clicks in any button
     * withing the main window than contain a property "action" equals to "save".
     */
    save: Ext.emptyFn,
    /**
     * An abstract method. This method is executed when the user clicks in any button
     * withing the main window than contain a property "action" equals to "delete".
     */
    remove: Ext.emptyFn,

    /**
     * creando tab
     */
    buildItems: function () {
        var me = this;
        me.show();
    },
    show: function () {
        var me = this;
        var open = !Ext.getCmp(this.datosTab.id);
        if (open) {
            me.cmpPrincipal = Ext.create(me.classPrincipal);
            var tab = new Ext.Panel({
                id: me.datosTab.id,
                autoHeigth: true,
                autoWidht: true,
                title: me.datosTab.titulo,
                autoScroll: true,
                iconCls: me.datosTab.iconcls,
                tooltip: me.datosTab.tooltip,
                viewConfig: {
                    forceFit: true,
                },
                items: me.cmpPrincipal,
                closable: true,

            });
            me.tabPanel.add(tab);
            tab.show();
        }
        else {
            var tab = Ext.getCmp(this.datosTab.id);
            me.tabPanel.setActiveTab(me.datosTab.id);
        }
        tab.on('destroy',function(obj){
            me.destroyController(me);
            //console.dir(this.id);
        });
        tab.on('activate',me.refrescarPanel,me);
    },
    destroyController	: function(controller){
        var me = this;
        var app  = me.getApplication();
        //remove from collection
        app.controllers.remove(controller);
        //for(var i=0,len=controller.selectors.length;i<len;i++){
        //    var obj = controller.selectors[i];
        //    for(var s in obj){
        //        for(var ev in obj[s]){
        //            //remove selectors from event bus
        //            delete app.eventbus.bus[ev][s];
        //        }
        //
        //    }
        //}
        //delete controller;
    },
    refrescarPanel : function(tab, opt){
        //console.dir(this.getApplication());
        //console.dir(tab);
        console.log("una ves activa el panel se refrescara");
    }
});
/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.Ayuda.ManualUsuario', {
    extend: 'App.Config.Abstract.Controller',
    views: [
        'App.Config.ux.IFrame',
    ],
    init: function () {
        var me = this;
        this.callParent();
    },
    show: function () {
        //var me = this;
        //var win = Ext.create("App.Config.Abstract.Window", {botones: false, destruirWin: true});
        //var form = Ext.create("App.View.Opciones.FormOpcion", {botones: false});
        //win.add(form);
        //win.show();
        var direccion = Constantes.obtenerHostManualUsuario();
        var win = Ext.create("App.Config.Abstract.Window", {
            botones: true,
            title : 'Manual de Usuario SGAUTH',
            botones: false,
            frame : true,
            destruirWin: true ,
            items : [
                {
                    xtype : 'uxiframe',
                    src : direccion,
                    width : 1000,
                    height : 750
                }
            ]
        });
        win.show();

    },

})
;
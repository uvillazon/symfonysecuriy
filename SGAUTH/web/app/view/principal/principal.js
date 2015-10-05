Ext.define("App.View.Principal.Principal", {
    extend: "Ext.Viewport",
    alias: "widget.PanelPrincipal",
    requires: [
		"App.Config.Constantes",
        "App.Config.Funciones",
        //"app.config.consultas",
        //"app.Config.Extensible"
    ],
    title: 'Principal',
    layout: 'border',
    frame: false,
    defaults: {
        split: false
    },
    code: 'es',
    app : null,
    initComponent: function () {
        var me = this;
        //funcion encargada de enviar el token
        Ext.util.Observable.observe(Ext.data.Connection, {
            requestexception: function(conn, response, options) {
                if(response.status == '403'){
                    Ext.Msg.alert("Error",response.responseText, function () {
                        window.location =  Constantes.obtenerHost()+'/logon';
                    });
                }
            }
            //,
                //beforerequest : function (conn, response, options) {
            //    var token = {'Authorization': "Bearer " + window.localStorage.token};
            //    response.headers = token;
            //}
        });
        //creamos un componente
        Constantes.CargarTamano();
        Constantes.CargarLocalStorage();
        Constantes.CargarHost();
        Funciones.cargarValidaciones();
        me.bbar_pie = new Ext.Toolbar({
            iconCls: 'an-icon',
            statusAlign: 'right',
            items: [
                {
                    iconCls: 'calendar',
                    text: Ext.Date.format(new Date(), 'd/n/Y'),

                }, '-', {
                    id: 'clock',
                    //                iconCls         : 'time',
                    text: Ext.Date.format(new Date(), 'g:i:s A')
                },
                        {
                            xtype: 'label',
                            //width: 800,
                            padding: '0 100 0 0',
                            autoHeight: true,
                            html: Constantes.PIEPAGINA,
                            border: false

                        },

                         '->'
                        , me.progress

            ]

        });
        me.panel_centro = new Ext.TabPanel({
            activeItem: 0,
            region: 'center',
            margins: '1 0 0 0',
            autoHeigth: true,
            enableTabScroll: true,
            split: false,
            itemId: 'maintab', /* necesito para encontrar la referencia en el controller principal*/
            plain: false,
            maxTabWidth: 230,
            border: false,
            defaults: { autoScroll: true, layout: 'fit' },
            items: [{
                title: 'AUTH',
                iconCls: 'application_home',

                //items: me.panel

            }
            ]

        });
        me.panel_cabecera = Ext.create("App.View.Principal.Cabecera", { tabPanel: me.panel_centro , app : me.app});
        me.panel_pie = new Ext.Panel({
            region: 'south',
            border: true,
            margins: '0 0 1 0',
            //height: 30,
            bbar: me.bbar_pie

        });

        me.items = [me.panel_cabecera, me.panel_centro, me.panel_pie];
        me.InicializarRunner();
        var nav = Ext.create('Ext.util.KeyNav', Ext.getDoc(), {
            scope: me,
            esc: me.panel_cabecera.SalirSession,
        });
        this.callParent();
    },
    doLoad: function (url, successFn) {
        Ext.Ajax.request({
            url: url,
            disableCaching: false,
            success: successFn,
            failure: function () {
                Ext.Msg.alert('Failure', 'Failed to load locale file.');
                //renderUI();
            }
        });
    },
    InicializarRunner: function () {
        var me = this;
        me.runner = new Ext.util.TaskRunner();
        me.task = me.runner.newTask({
            run: Funciones.ActualizarReloj,
            interval: 1000
        });

        me.task.start();
    },
});















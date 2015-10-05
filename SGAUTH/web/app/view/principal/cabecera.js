/**
 * @class App.View.Principal.Cabecera
 * @extends Ext.Component
 * requires
 * @autor Ubaldo Villazon
 * @date 23/07/2013
 *
 * Description
 *
 *
 **/

Ext.define("App.View.Principal.Cabecera", {
    extend: "Ext.panel.Panel",
    height: 60,
    region: 'north',
    layout: 'border',
    tabPanel: null,
    app: null,
    initComponent: function () {
        var me = this;
        me.cmp_logo = Ext.create('Ext.Img', {
            src: 'Content/images/seguridad-logo.png',
            region: 'west',
            height: 60,
            width: 90,

        });
        me.cabecera_top = Ext.create('Ext.Component', {
            xtype: 'box',
            id: 'header',
            region: 'north',
            html: '<h1> Sistema de Autenticación</h1>',
            height: 30,
            padding: 0,
            margin: 0,
        });
        me.tb = Ext.create('Ext.toolbar.Toolbar', {
            itemId: 'mainmenu',
            padding: 0,
            margin: 0,
            cls: 'ux-start-menu-toolbar',
        });

        me.panel_menubar = new Ext.Panel({
            region: 'south',
            //width: 500,
            border: true,
            margins: '0 0 1 0',
            tbar: me.tb
        });
        me.panel_bar = Ext.create('Ext.panel.Panel', {
            height: 60,
            region: 'center',
            layout: 'border',
            items: [me.cabecera_top, me.panel_menubar]
        });
        me.items = [me.cmp_logo, me.panel_bar];

        me.crearMenuOpciones();
        me.CrearCabeceraLogin(me.tb, Constantes.USUARIO);
        me.callParent();
    },
    crearMenuOpciones: function () {
        var me = this;
        if (Constantes.MENU == null) {
            alert("Error al Recuperar los Datos de las Opciones del Menu.");
            document.location = '/login';
        }
        else {
            me.CrearMenu(me.tb, Constantes.MENU);
        }
    },
    buildDesktop: function (data) {
        var me = this;
        var data1 = Ext.decode(data.responseText);
        me.configuracion = data1;
        console.dir(data1.data);
        me.CrearMenu(me.tb, data1.data);
    },
    VerificarCaducidad: function (caducidad) {
        var me = this;
        if (caducidad != "COMPLETADO") {
            Ext.Msg.confirm("Advertencia", caducidad, function (btn) {
                if (btn === "yes") {
                    me.VentanCambioContrasena();
                }
            });
        }
    },
    CrearCabeceraLogin: function (tb, data) {
        var me = this;
        var NombreUsuario = '<span  style="font-size:11px;height:11px;font-weight: bold;"> ' + data.perfil + ' : ' + data.login + '</span>';
        //var NombreUsuario = '<span  style="font-size:11px;height:11px;font-weight: bold;"> ' + data.Perfil + ' : ' + data.Nombre + ' / ' + data.UsuarioDB + '</span>';
        //var NombreUsuario = '<span  style="font-size:11px;height:11px;font-weight: bold;"> ' + data.Perfil + ' : ' + data.Nombre + ' Inicio :  ' + data.FechaSesion + ' Fin : ' + data.FechaCaducidadSession + ' </span>';
        tb.add("->");
        tb.add(NombreUsuario, {
                text: "Contraseña",
                iconCls: "key",
                tooltip: "Cambiar Contraseña",
                scope: me,
                //handler: me.VentanCambioContrasena
            }, {
                text: "Salir(Esc)",
                iconCls: "exclamation",
                tooltip: "Cerrar Session",
                scope: me,
                handler: me.SalirSession
            }
        );

    },
    SalirSession: function () {
        Ext.Msg.confirm("Confirmar", "Esta seguro salir de la aplicación?", function (btn) {
            if (btn === "yes") {
                window.localStorage.clear();
                document.location = Constantes.obtenerHost()+'logon';

            }
        });
        //Ext.Msg.alert("Aviso", "Falta Implementar Opcion Salir");
        //var redirect = Constantes.HOST + 'Account/LogOff';
        //window.location = redirect;
    },
    CrearMenu: function (tb, data) {
        var me = this;
        //alert(me.tabPanel.getId());
        Ext.each(data, function (menu) {
            if (menu.submenu) {
                var subMenu = Ext.create('Ext.menu.Menu');
                //alert(menu.text);
                tb.add({
                    text: menu.titulo,
                    iconCls: menu.iconcls,
                    titulo: menu.titulo,
                    menu: subMenu,
                    tooltip: menu.tooltip,
                    estilo: menu.estilo,
                    controller: menu.estilo,
                    datos: menu,
                    scope: me,
                    handler: me.CargarControlador
                });

                me.CrearMenu(subMenu, menu.submenu);
            }
            else {
                tb.add({
                    text: menu.titulo,
                    titulo: menu.titulo,
                    iconCls: menu.iconcls,
                    menu: subMenu,
                    tooltip: menu.tooltip,
                    estilo: menu.estilo,
                    controller: menu.estilo,
                    datos: menu,
                    scope: me,
                    handler: me.CargarControlador
                });
            }
        });
    },
    CargarControlador: function (menu) {
        var me = this;
        if (menu.datos.href) {
            controller = me.app.controllers.get('Controller-'+menu.datos.id);
            if (!controller) {
                controller = Ext.create(me.app.getModuleClassName(menu.datos.href, 'controller'), {
                    application: me.app,
                    id: 'Controller-'+menu.datos.id
                });
                me.app.controllers.add(controller);
                controller.tabPanel = me.tabPanel;
                controller.datosTab = menu.datos;
                controller.init(me.app);
                controller.onLaunch(me.app);
                //controller.show();
            }
            else {
                controller.show();
                //console.dir(me.app);
            }
        }

    },
    CargarClase: function (menu) {
        var me = this;
        //console.dir(menu);
        console.dir(menu.datos);
        if (menu.datos.href) {
            //alert(menu.estilo);
            if (menu.datos.estilo == null) {
                var open = !Ext.getCmp(menu.text);
                if (open) {
                    var principal = Ext.create(menu.datos.clase);
                    var tab = new Ext.Panel({
                        id: menu.text,
                        autoHeigth: true,
                        autoWidht: true,
                        title: menu.text,
                        autoScroll: true,
                        iconCls: menu.iconCls,
                        tooltip: menu.tooltip,
                        viewConfig: {
                            forceFit: true,
                        },
                        items: principal,
                        closable: true,

                    });
                    me.tabPanel.add(tab);
                    tab.show();
                }
                else {
                    me.tabPanel.setActiveTab(menu.text);
                }
            }
            else if (menu.datos.estilo == "ventana") {
                var principal = Ext.create(menu.datos.clase).show();
            }
            /* else {
             //sas
             }*/
        }

    },
    CargarBandejaEntrada: function () {
        var me = this;
        var principal = Ext.create("App.View.BandejasEntrada.Principal");
        var tab = new Ext.Panel({
            id: "BandejaPrincipal",
            autoHeigth: true,
            autoWidht: true,
            title: "Bandeja de Entrada",
            autoScroll: true,
            iconCls: "email",
            tooltip: "Bandeja de Entrada por Usuario",
            viewConfig: {
                forceFit: true,
            },
            items: principal,
            closable: true,

        });
        me.tabPanel.add(tab);
        tab.show();
    },
    VentanCambioContrasena: function () {
        var me = this;
        if (me.winContrasena == null) {
            me.winContrasena = Ext.create("App.Config.Abstract.Window", {
                botones: true,
                textGuardar: 'Cambiar Contraseña'
            });
            me.formContrasena = Ext.create("App.View.Principal.Forms", {opcion: 'FormConstrasena', columns: 1});
            me.winContrasena.add(me.formContrasena);
            me.winContrasena.show();
            me.winContrasena.btn_guardar.on('click', function () {
                Funciones.AjaxRequestWin("Usuarios", "CambiarContrasena", me.winContrasena, me.formContrasena, null, "Esta Seguro de Cambiar la Contraseña?", null, me.winContrasena);
            });
        }
        else {
            me.formContrasena.reset();
            me.winContrasena.show();
        }
    }
});

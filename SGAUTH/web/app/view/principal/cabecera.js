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

Ext.define("app.view.principal.cabecera", {
    extend: "Ext.panel.Panel",
    height: 60,
    region: 'north',
    layout: 'border',
    tabPanel: null,
    initComponent: function () {
        var me = this;
        //me.flash = Ext.create('Ext.flash.Component', {
        //    url: 'Content/banner/banner.swf',
        //    region: 'west',
        //    height: 60,
        //    width: 400,
        //});
        me.cmp_logo = Ext.create('Ext.Component',{
            region : 'west',
            height : 60,
            width : 400,

        });
        me.cabecera_top = Ext.create('Ext.Component', {
            xtype: 'box',
            id: 'header',
            region: 'north',
            html: '<h1> Sistema de Autenticación</h1>',
            height: 30,
            //width : 500,
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
            split: false,
            tbar: me.tb
        });
        me.panel_bar = Ext.create('Ext.panel.Panel', {
            height: 60,
            region: 'center',
            layout: 'border',
            items: [me.cabecera_top, me.panel_menubar]
        });
        me.items = [ me.cmp_logo,me.panel_bar];


        Ext.Ajax.request({
            //url: "MenuJs.js",
            url: Constantes.HOST+"opciones/opciones",
            method: 'GET',
            //url:'http://localhost:89/demo/extjs/crysfel-Bleextop-7fdca2b/index.php/desktop/config',
            scope: this,
            success: this.buildDesktop,
            failure: this.onError
        });
        ////me.CargarBandejaEntrada();
        me.callParent();
    },
    onError: function (data) {
        //alert('este'); return Json(new { success = true, msg = encript.valor });
        alert("Error al Recuperar los Datos de las Opciones del Menu.");
        document.location = Constantes.HOST + 'Account/LogOn';

    },
    buildDesktop: function (data) {
        var me = this;
        //console.dir(data);
        //alert('este ok');
        var data1 = Ext.decode(data.responseText);
        me.configuracion = data1;
        //Constantes.LiSTAS = data1.Listas;
        //Constantes.USUARIO = data1.Usuario;
        //me.Usuario = data1.Usuario.Nombre;
        console.dir(data1.data);
        me.CrearMenu(me.tb, data1.data);
        //me.CrearCabeceraLogin(me.tb, data1.Usuario);
        //me.VerificarCaducidad(data1.Usuario.Caducidad);
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
        var NombreUsuario = '<span  style="font-size:11px;height:11px;font-weight: bold;"> ' + data.Perfil + ' : ' + data.UsuarioDB + '</span>';
        //var NombreUsuario = '<span  style="font-size:11px;height:11px;font-weight: bold;"> ' + data.Perfil + ' : ' + data.Nombre + ' / ' + data.UsuarioDB + '</span>';
        //var NombreUsuario = '<span  style="font-size:11px;height:11px;font-weight: bold;"> ' + data.Perfil + ' : ' + data.Nombre + ' Inicio :  ' + data.FechaSesion + ' Fin : ' + data.FechaCaducidadSession + ' </span>';
        tb.add("->");
        tb.add(NombreUsuario, {
            text: "Contraseña",
            iconCls: "key",
            tooltip: "Cambiar Contraseña",
            scope: me,
            handler: me.VentanCambioContrasena
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
                document.location = Constantes.HOST + 'Account/LogOff';
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
            console.dir(menu);
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
                    handler: me.CargarClase
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
                    handler: me.CargarClase
                });
            }
        });
    },
    CargarClase: function (menu) {
        var me = this;

        if (menu.datos.clase) {
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
            me.winContrasena = Ext.create("App.Config.Abstract.Window", { botones: true, textGuardar: 'Cambiar Contraseña' });
            me.formContrasena = Ext.create("App.View.Principal.Forms", { opcion: 'FormConstrasena', columns: 1 });
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

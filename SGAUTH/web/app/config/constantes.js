/**
 * @class App.Config.Constantes
 * @extends
 * @autor Ubaldo Villazon
 * @date 23/07/2013
 *
 * Variables Globales Comunes
 *
 **/
Ext.define("App.Config.Constantes", {
    alternateClassName: ["Constantes", "Lista"],
    singleton: true,
    /* Aqui Defino todas mis contanstantes */
    HOST: 'http://localhost:8000/backend/',
    //HOST                : 'http://elfpre02/SisMan/',
    REQUERIDO: '<span style="color:red;font-weight:bold" data-qtip="Requerido">*</span>',
    PIEPAGINA: '<font color="black"><h2  style="font-size:12px;height:14px">Copyright &copy;  ' + (Ext.Date.format(new Date(), 'Y')) + '  -  Version 1.0</h2></font>',
    ALTO: 660,
    MAXANCHO: 1024,
    MAXALTO: 660,
    ICONO_CREAR: 'application_form_add',
    ICONO_EDITAR: 'application_form_edit',
    ICONO_BAJA: 'application_form_delete',
    ICONO_VER: 'application_view_detail',
    ICONO_PRINT: 'printer',
    LiSTAS: null,
    USUARIO: null,
    MENU: null,
    //TOKEN : null,
    URLLISTAS: 'Listas/ObtenerTodasLasListas',
    URLIMAGEN: "Imagenes/VerImagen?",
    UND_EJEC_MANT: 2,
    UND_EJEC_OPER: 3,
    UND_EJEC_LLVV: 1,
    UND_EJEC_SUB: 4,
    path: 'sgauth/',
    rutaBackend : 'backend/',
    UnidadesRequeridas: function (unidad, requerido) {
        if (requerido) {
            return '<span style="color:red;font-weight:bold" data-qtip="Requerido">*</span><span style="color:blue" data-qtip="Requerido">[' + unidad + ']</span>';
        }
        else {
            return '<span style="color:blue" data-qtip="' + unidad + '">[' + unidad + ']</span>';
        }
    },
    CargarTamano: function () {
        this.ALTO = document.documentElement.clientHeight - 155;
        //this.MAXALTO = document.documentElement.clientHeight - 40;
        this.MAXANCHO = document.documentElement.clientWidth - 50;
        this.MAXALTO = document.documentElement.clientHeight - 90;
        //this.MAXANCHO = 1300;
    },
    VerPrueba: function () {
        Ext.Msg.alert("Entrooo");
    },
    CargarLocalStorage: function () {
        this.USUARIO = JSON.parse(window.localStorage["usuario"]);
        this.MENU = JSON.parse(window.localStorage["menu"]);
        //var token = window.localStorage["token"];
        //
        //var res = token.split(".");
        //console.log(Ext.util.Base64.decode(res[1]));
        //this.TOKEN = JSON.parse( Ext.util.Base64.decode(res[1]));
        //console.dir((this.MENU));
        //console.dir(storedNames);
        //console.dir(storedNames);
    },
    obtenerHost: function () {
        if (window.location.hostname == 'localhost') {
            var host = window.location.origin ;
        }
        else {
            var host = window.location.origin + '/' + this.path;
        }
        return host;
    },
    CargarHost : function(){
        if (window.location.hostname == 'localhost') {
            this.HOST = window.location.origin+'/'+this.rutaBackend ;
        }
        else {
            this.HOST = window.location.origin + '/' + this.path+''+this.rutaBackend;
        }
    }
});
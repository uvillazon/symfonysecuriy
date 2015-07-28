﻿/**
 * @class App.Config.Constantes
 * @extends 
 * @autor Ubaldo Villazon
 * @date 23/07/2013
 *
 * Variables Globales Comunes 
 *
 **/
Ext.define("app.config.constantes", {
    alternateClassName  : ["Constantes","Lista"],
    singleton           : true,
    /* Aqui Defino todas mis contanstantes */
    HOST                : 'http://localhost:8000/backend/',
    //HOST                : 'http://elfpre02/SisMan/',
    REQUERIDO           : '<span style="color:red;font-weight:bold" data-qtip="Requerido">*</span>',
    PIEPAGINA: '<font color="black"><h2  style="font-size:12px;height:14px">Copyright &copy;  ' + (Ext.Date.format(new Date(), 'Y')) + '  -  Version 1.0</h2></font>',
    ALTO: 660,
    MAXANCHO: 1024,
    MAXALTO : 660,
    ICONO_CREAR: 'application_form_add',
    ICONO_EDITAR: 'application_form_edit',
    ICONO_BAJA: 'application_form_delete',
    ICONO_VER: 'application_view_detail',
    ICONO_PRINT : 'printer',
    LiSTAS: null,
    USUARIO :  null,
    URLLISTAS: 'Listas/ObtenerTodasLasListas',
    URLIMAGEN: "Imagenes/VerImagen?",
    UND_EJEC_MANT: 2,
    UND_EJEC_OPER: 3,
    UND_EJEC_LLVV: 1,
    UND_EJEC_SUB : 4,
    UnidadesRequeridas: function (unidad, requerido) {
        if (requerido) {
            return '<span style="color:red;font-weight:bold" data-qtip="Requerido">*</span><span style="color:blue" data-qtip="Requerido">[' + unidad + ']</span>';
        }
        else {
            return '<span style="color:blue" data-qtip="'+unidad+'">['+unidad+']</span>';
        }
    },
    CargarTamano: function () {
        this.ALTO = document.documentElement.clientHeight - 135;
        //this.MAXALTO = document.documentElement.clientHeight - 40;
        this.MAXANCHO = document.documentElement.clientWidth - 40;
        this.MAXALTO =document.documentElement.clientHeight - 70;
        //this.MAXANCHO = 1300;
    },
    VerPrueba: function () {
        Ext.Msg.alert("Entrooo");
    }
});
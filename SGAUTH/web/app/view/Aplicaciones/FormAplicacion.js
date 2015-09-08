/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Aplicaciones.FormAplicacion", {
    extend: "App.Config.Abstract.Form",
    title: "Datos Aplicacion",
    cargarStores: true,
    //Observar el ultimo comentario de la transicion de ESTADO
    verObservacion: true,
    initComponent: function () {
        var me = this;

        me.CargarComponentes();

        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;

        me.txt_id = Ext.create("App.Config.Componente.TextFieldBase", {
            name: "id_aplic",
            hidden: true,
        });
        //me.hid_perfil = Ext.widget('hiddenfield', {
        //    name: 'ID_PERFIL',
        //});

        me.txt_codigo = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Codigo App",
            name: "codigo",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan: 2,
        });
        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Nombre",
            name: "nombre",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan: 2,
            width: 480,
        });
        me.txt_descripcion = Ext.create("App.Config.Componente.TextAreaBase", {
            fieldLabel: "Descripcion",
            name: "descripcion",
           colspan: 2,
            width: 480,
        });
        me.txt_bd = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Base de Datos",
            name: "bd_princ",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,

        });
        me.txt_bd_port = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "BD Port",
            name: "bd_port",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false

        });
        me.txt_bd_host = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "BD Host",
            name: "bd_host",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false

        });
        me.txt_bd_drive = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "BD Drive",
            name: "bd_drive",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false

        });
        me.txt_host = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Host App",
            name: "app_host",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false

        });

        me.cbx_estado = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Estado",
            name: "estado",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            value: 'ACTIVO',
            colspan: 2,
            store: ['ACTIVO', 'INACTIVO'],

        });
        me.items = [
            me.txt_id,
            me.txt_codigo,
            me.txt_nombre,
            me.txt_descripcion,
            me.txt_bd,
            me.txt_bd_port,
            me.txt_bd_host,
            me.txt_bd_drive,
            me.txt_host,
            me.cbx_estado,
        ];


    },

});

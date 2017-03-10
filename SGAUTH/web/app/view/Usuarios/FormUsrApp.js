/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Usuarios.FormUsrApp", {
    extend: "App.Config.Abstract.Form",
    title: "Datos Usuario Por Aplicacion",
    cargarStores: true,
    //Observar el ultimo comentario de la transicion de ESTADO
    verObservacion: true,
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        me.cargarEventos();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;


        me.hid_id_usuario = Ext.widget('hiddenfield', {
            name: 'id_usuario',
        });

        me.hid_id_app = Ext.widget('hiddenfield', {
            name: 'id_aplic',
            value : Constantes.APLICACION.id_aplic,

        });

        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Nombre Completo",
            name: "nombre",
            readOnly: true,
            colspan: 2,
            width: 480,
        });
        me.txt_login = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Login",
            name: "login",
            readOnly: true

        });
        me.txt_email = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Em@il",
            name: "email",
            readOnly: true,
            labelWidth : 70
        });

        me.txt_aplicacion = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Aplicacion",
            name: "aplicacion",
            readOnly: true,
            colspan: 2,
            value : Constantes.APLICACION.aplicacion,
            width: 480,
        });

        me.store_perfil = Ext.create("App.Store.Perfiles.Perfiles");
        me.cbx_perfil = Ext.create("App.Config.Componente.ComboAutoBase", {
            fieldLabel: 'Perfil',
            displayField: 'nombre',
            valueField: 'id_perfil',
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            name: 'id_perfil',
            colspan: 2,
            width: 480,
            store: me.store_perfil,
            textoTpl: function () {
                return '<h4>{nombre}</h4>  {descripcion}';
            }
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
            me.hid_id_usuario,
            me.hid_id_app,
            me.txt_nombre,
            me.txt_login, me.txt_email,
            me.txt_aplicacion,
            me.cbx_perfil,
            me.cbx_estado,
        ];


    },
    cargarEventos: function () {
        var me = this;

    }

});

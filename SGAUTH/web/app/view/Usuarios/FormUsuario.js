/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Usuarios.FormUsuario", {
    extend: "App.Config.Abstract.Form",
    title: "Datos de Usuario",
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
            name: "id_usuario",
            hidden: true,
        });
        //me.hid_perfil = Ext.widget('hiddenfield', {
        //    name: 'ID_PERFIL',
        //});

        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Nombre Completo",
            name: "nombre",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan: 2,
            width: 480,
        });
        me.txt_login = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Login",
            name: "login",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan: 2,
            mayus : false
        });
        me.txt_email = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Em@il",
            name: "email",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            width: 480,
            vtype: 'email',
            colspan: 2

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
            me.txt_nombre,
            me.txt_login,
            me.txt_email,
            me.cbx_estado,
        ];


    },

});

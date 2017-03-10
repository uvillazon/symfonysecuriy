/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.UsuariosApp.FormUsrArea", {
    extend: "App.Config.Abstract.Form",
    title: "Datos Usuario Area",
    cargarStores: true,
    //Observar el ultimo comentario de la transicion de ESTADO
    verObservacion: true,
    initComponent: function () {
        var me = this;
        me.cargarComponentes();
        this.callParent(arguments);
    },
    cargarComponentes: function () {
        var me = this;


        me.hid_id_usuario = Ext.widget('hiddenfield', {
            name: 'id_usuario',
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
        me.store_area = Ext.create("App.Store.Areas.Areas").load();
        me.cbx_area = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: 'Area',
            displayField: 'nom_area',
            valueField: 'id_area',
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            name: 'id_area',
            colspan: 2,
            width: 480,
            store: me.store_area,

        });

        me.items = [
            me.hid_id_usuario,
            me.txt_nombre,
            me.txt_login, me.txt_email,
            me.cbx_area
        ];


    }

});

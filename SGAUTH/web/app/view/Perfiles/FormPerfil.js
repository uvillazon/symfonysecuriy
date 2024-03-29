/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Perfiles.FormPerfil", {
    extend: "App.Config.Abstract.Form",
    title: "Datos del  Perfil",
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
            name: "id_perfil",
            hidden: true,
        });
        //me.hid_perfil = Ext.widget('hiddenfield', {
        //    name: 'ID_PERFIL',
        //});

        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Perfil",
            name: "nombre",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan: 2,
            width: 480,
        });

        me.txt_descripcion = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Descripcion",
            name: "descripcion",
            width: 480,
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
            me.txt_descripcion,
            me.cbx_estado
        ];


    },

});

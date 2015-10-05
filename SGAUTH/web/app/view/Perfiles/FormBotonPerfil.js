/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Perfiles.FormBotonPerfil", {
    extend: "App.Config.Abstract.Form",
    title: "Datos de Boton Por Perfil",
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
        me.hid_idPerfil = Ext.widget('hiddenfield', {
            name: 'id_perfil',
        });
        me.hid_idOpc = Ext.widget('hiddenfield', {
            name: 'id_opc',
        });
        me.hid_idApp = Ext.widget('hiddenfield', {
            name: 'id_aplic',
        });

        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Perfil",
            name: "nombre",
            readOnly: true,
            colspan: 2,
            width: 480
        });
        me.txt_app = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Aplicacion",
            name: "aplicacion",
            readOnly: true,
            colspan: 2,
            width: 480
        });
        me.txt_opcion = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Opcion",
            name: "opcion",
            readOnly: true,
            colspan: 2,
            width: 480
        });

        me.store_botones = Ext.create("App.Store.Opciones.Botones");
        me.cbx_botones = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: 'Boton',
            displayField: 'boton',
            valueField: 'id_boton',
            name: 'id_boton',
            colspan: 2,
            width: 480,
            store: me.store_botones
        });

        me.items = [
            me.hid_idPerfil, me.hid_idApp,me.hid_idOpc,
            me.txt_nombre,
            me.txt_app,
            me.txt_opcion,
            me.cbx_botones

        ];
    },
    cargarBotonesPorOpcion: function (idOpc) {
        var me = this;
        me.cbx_botones.getStore().setExtraParams({id_opc : idOpc});
        me.cbx_botones.getStore().load();
    }
});

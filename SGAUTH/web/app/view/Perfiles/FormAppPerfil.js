/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Perfiles.FormAppPerfil", {
    extend: "App.Config.Abstract.Form",
    title: "Datos de Aplicacion Por Perfil",
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
        var storeApp = Ext.create('Ext.data.Store', {
            fields: ['id_aplic', 'codigo'],
            proxy: {
                type: 'rest',
                url: 'rest-api/aplicaciones/aplicaciones.json',
                extraParams:{
                    estado : 'ACTIVO'
                },
                reader: {
                    type: 'json',
                    root: 'rows'
                }
            },
            autoLoad: true
        });

        me.hid_idPerfil = Ext.widget('hiddenfield', {
            name: 'id_perfil',
        });
        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Perfil",
            name: "nombre",
            readOnly: true,
            colspan: 2,
            width: 480
        });

        me.cbx_app = Ext.create("App.Config.Componente.ComboAutoBase", {
            fieldLabel: 'Aplicacion',
            displayField: 'codigo',
            valueField : 'id_aplic',
            name: 'id_aplic',
            colspan: 2,
            width: 480,
            store: storeApp
        });

        me.items = [
            me.hid_idPerfil, me.hid_idApp,
            me.txt_nombre,
            me.cbx_app

        ];
    }
});

/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Perfiles.FormOpcionPerfil", {
    extend: "App.Config.Abstract.Form",
    title: "Datos de Opcion Por Perfil",
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

        me.store_opcion = Ext.create("App.Store.Opciones.Opciones");
        me.store_opcion.setExtraParams({estado: 'ACTIVO'});

        me.cbx_opcion = Ext.create("App.Config.Componente.ComboAutoBase", {
            fieldLabel: 'Opcion',
            displayField: 'opcion',
            valueField: 'id_opc',
            name: 'id_opc',
            matchFieldWidth: true,
            colspan: 2,
            width: 480,
            store: me.store_opcion,
            listConfig : {
                loadingText: 'Buscando',
                emptyText: 'No Existe Resultado',
                getInnerTpl :  function () {
                    return '<img data-qtip="{tooltip}", src="' + Constantes.obtenerHost() + '/Content/Iconos/{icono}.png" />{opcion}';
                }
            }
        });

        me.items = [
            me.hid_idPerfil, me.hid_idApp,
            me.txt_nombre,
            me.txt_app,
            me.cbx_opcion

        ];
    },
    cargarOpcionesPorAplicaciones: function (idAplic) {
        var me = this;
        me.cbx_opcion.getStore().setExtraParams({id_aplic: idAplic});
        me.cbx_opcion.getStore().load();
    }
});

/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Opciones.FormOpcion", {
    extend: "App.Config.Abstract.Form",
    title: "Datos de Opcion de Menu",
    cargarStores: true,
    //Observar el ultimo comentario de la transicion de ESTADO
    verObservacion: true,
    initComponent: function () {
        var me = this;
        me.cargarComponentes();
        me.cargarEventos();
        this.callParent(arguments);
    },
    cargarEventos: function () {
        var me = this;
        me.cbx_padre.on('select', function (cbx, rec) {
            me.hid_idPadre.setValue(rec.get('id_opc'));
        });
    },
    cargarComponentes: function () {
        var me = this;
        me.hid_id = Ext.widget('hiddenfield', {
            name: 'id_opc',
        });
        me.hid_idPadre = Ext.widget('hiddenfield', {
            name: 'id_padre',
        });
        me.hid_idApp = Ext.widget('hiddenfield', {
            name: 'id_aplic',
        });

        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Menu Opcion",
            name: "opcion",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan: 2,
            width: 480,
            mayus : false
        });
        me.txt_link = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "link (Controller)",
            name: "link",
            colspan: 2,
            width: 480,
            mayus : false
        });

        me.txt_alias = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Alias",
            name: "alias",
            colspan: 2,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            width: 480,
            mayus : false
        });

        me.txt_tooltip = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Tooltip (detalle)",
            name: "tooltip",
            colspan: 2,
            width: 480,
        });

        me.txt_icono = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Icono",
            name: "icono",
            mayus : false

        });
        me.txt_estilo = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Estilo(Css)",
            name: "estilo",
            mayus : false

        });

        me.txt_parametros = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Parametros",
            name: "parametros",
            colspan: 2,
            width: 480,
            mayus : false

        });

        me.txt_orden = Ext.create("App.Config.Componente.NumberFieldBase", {
            fieldLabel: "Orden",
            name: "orden",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,

        });
        me.store_opcion = Ext.create("App.Store.Opciones.Opciones");
        me.cbx_padre = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: 'Opcion Padre',
            displayField: 'opcion',
            valueField: 'id_opc',
            name: 'padre',
            colspan: 2,
            width: 480,
            store: me.store_opcion.load()
        });

        me.cbx_estado = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Estado",
            name: "estado",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            value: 'ACTIVO',
            store: ['ACTIVO', 'INACTIVO'],

        });

        me.items = [
            me.hid_id, me.hid_idPadre,me.hid_idApp,
            me.txt_nombre,
            me.txt_link,
            me.txt_alias,
            me.txt_tooltip,
            me.txt_icono, me.txt_estilo,
            me.txt_parametros,
            me.cbx_padre,
            me.txt_orden, me.cbx_estado
        ];
    }
});

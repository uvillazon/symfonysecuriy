/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Opciones.FormBoton", {
    extend: "App.Config.Abstract.Form",
    title: "Datos del Boton",
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
            me.hid_idPadre.setValue(rec.get('id_boton'));
        });
    },
    cargarComponentes: function () {
        var me = this;
        me.hid_id = Ext.widget('hiddenfield', {
            name: 'id_boton',
        });
        me.hid_idPadre = Ext.widget('hiddenfield', {
            name: 'id_padre',
        });
        me.hid_idOpc = Ext.widget('hiddenfield', {
            name: 'id_opc',
        });

        me.txt_aplicacion = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Aplicacion",
            name: "aplicacion",
            colspan: 2,
            width: 480,
            readOnly : true
        });
        me.txt_opcion = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Opcion Menu",
            name: "opcion",
            colspan: 2,
            width: 480,
            readOnly : true
        });
        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Nombre Boton",
            name: "boton",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            mayus : false
        });
        me.txt_icono = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Icono",
            name: "icono",
            mayus : false

        });
        me.txt_tooltip = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Tooltip (detalle)",
            name: "tooltip",
            colspan: 2,
            width: 480,
        });
        me.txt_item_id = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Item Id",
            name: "id_item",
            mayus : false

        });
        me.txt_accion = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Accion",
            name: "accion",
            mayus : false

        });

        me.txt_estilo = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Estilo(Css)",
            name: "estilo",
            mayus : false

        });
        me.cbx_habilitar = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Habilitado",
            name: "disabled",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            value: 'HABILITADO',
            store: ['HABILITADO', 'INHABILITADO'],

        });

        me.txt_orden = Ext.create("App.Config.Componente.NumberFieldBase", {
            fieldLabel: "Orden",
            name: "orden",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,

        });
        me.store_botones = Ext.create("App.Store.Opciones.Botones");
        me.cbx_padre = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: 'Boton Padre',
            displayField: 'boton',
            valueField: 'id_boton',
            name: 'padre',
            colspan: 2,
            width: 480,
            store: me.store_botones
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
            me.hid_id, me.hid_idPadre,me.hid_idOpc,
            me.txt_aplicacion,
            me.txt_opcion,
            me.txt_nombre,me.txt_icono,
            me.txt_tooltip,
            me.txt_item_id , me.txt_accion,
            me.cbx_habilitar, me.txt_estilo,
            me.cbx_padre,
            me.txt_orden, me.cbx_estado
        ];
    },
    cargarRecordOpcion : function(record){
        var me = this;
        me.store_botones.setExtraParams({id_opc : record.get('id_opc')});
        me.store_botones.load();
        me.hid_idOpc.setValue(record.get('id_opc'));
        me.txt_aplicacion.setValue(record.get('aplicacion'));
        me.txt_opcion.setValue(record.get('opcion'));
    }
});

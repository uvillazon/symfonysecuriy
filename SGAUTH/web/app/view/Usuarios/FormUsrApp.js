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
            value: Constantes.APLICACION.id_aplic,

        });

        me.hid_operacion = Ext.widget('hiddenfield', {
            name: 'operacion',
            value: 'ALTA',

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
            labelWidth: 70
        });

        me.txt_aplicacion = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Aplicacion",
            name: "aplicacion",
            readOnly: true,
            colspan: 2,
            value: Constantes.APLICACION.aplicacion,
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
            colspan: 1,
            store: ['ACTIVO', 'INACTIVO'],

        });

        me.dat_fecha_baja = Ext.create("App.Config.Componente.DateFieldBase", {
            fieldLabel: "Fecha Baja",
            name: "fch_baja",
            readOnly: true,
            hidden: false
        });
        me.items = [
            me.hid_operacion,
            me.hid_id_usuario,
            me.hid_id_app,
            me.txt_nombre,
            me.txt_login, me.txt_email,
            me.txt_aplicacion,
            me.cbx_perfil,
            me.cbx_estado,
            me.dat_fecha_baja
        ];


    },
    cargarEventos: function () {
        var me = this;

        me.cbx_estado.on('select', function (cbx, record) {
            if (cbx.getValue() === 'INACTIVO') {
                var date = new Date();
                me.dat_fecha_baja.setValue(date);
            }
            else {
                me.dat_fecha_baja.setValue(null);
            }
        });
    },

    cargarDatosEdicion: function (record) {
        var me = this;
        console.log(record);
        me.getForm().loadRecord(record);
        me.hid_operacion.setValue("EDITAR");
        me.cbx_perfil.getStore().setExtraParams({mostrar_todos: "SI", id_aplic: record.get('id_aplic')});
        me.cbx_perfil.getStore().load({
            callback: function (records, operation, success) {
                Ext.each(records, function (rec) {
                    if (rec.get('id_perfil') == record.get('id_perfil')) {
                        me.cbx_perfil.select(rec);
                        return me.cbx_perfil.setReadOnly(true);
                    }
                });
            }
        });
    }
});

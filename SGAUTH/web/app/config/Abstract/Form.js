Ext.define("App.Config.Abstract.Form", {
    extend: "Ext.form.Panel",
    layout: {
        type: 'table',
        columns: 2,
        tdAttrs: {
            valign: 'top'
        }
    },
    autoScroll: true,
    iconCls: 'application_form_add',
    columns: 2,
    bodyPadding: 10,
    defaultType: 'textfield',
    botones: true,
    textLimpiar: 'Limpiar',
    textGuardar: 'Guardar',
    fieldDefaults: {
        margin: '2',
        align: 'left',
        labelWidth: 110,
    },
    icono: true,
    record: null,
    mostrarEncabezado: false,
    tituloEncabezado: 'redtertetert',
    cssEncabezado: 'resaltarRojo',
    bloquearFormulario: true,
    btn: null,
    hiddenBtnLimpiar: false,
    dockButtonsTop: null,
    initComponent: function () {
        var me = this;
        me.iconCls = (me.icono) ? 'application_form_add' : '';
        if (me.botones) {
            if (me.btn == null) {
                me.btn_limpiar = Ext.create('Ext.Button', {
                    text: me.textLimpiar,
                    width: 120,
                    textAlign: 'center',
                    iconCls: 'cross',
                    margin: 10,
                    scope: this,
                    hidden : me.hiddenBtnLimpiar,
                    handler: me.LimpiarFormulario

                });
            }
            else {
                if (this.btn != null) {
                    this.btn.removeCls("botones");
                }
                me.btn_limpiar = me.btn;
            }
            me.btn_guardar = Ext.create('Ext.Button', {
                text: me.textGuardar,
                width: 120,
                textAlign: 'center',
                iconCls: 'disk',
                margin: 10,

            });
           
            me.buttons = [me.btn_guardar, me.btn_limpiar];
        }
        this.layout.columns = this.columns;
        if (me.dockButtonsTop != null) {
            me.dockedItems =
                [{
                    xtype: 'toolbar',
                    itemId: 'docked',
                    dock: 'top',
                    items: me.dockButtonsTop

                }];
        }
        this.callParent();
        //me.addDocked(me.encabezado, 'top');
    },
    BloquearFormulario: function (array) {
        var me = this;
        if (me.botones) {
            me.btn_guardar.hide();
            me.btn_limpiar.hide();
        }
        me.bloquearFormulario ? Funciones.BloquearFormulario(me, array) : me.getForm().reset();
    },
    BloquearFormularioReadOnly: function (array) {
        var me = this;
        if (me.botones) {
            me.btn_guardar.hide();
            me.btn_limpiar.hide();
        }
        Funciones.BloquearFormularioReadOnly(me, array);
    },
    DesbloquearFormulario: function (array, readOnly) {
        var me = this;
        if (me.botones) {
            me.btn_guardar.show();
            me.btn_limpiar.show();
        }
        me.bloquearFormulario ? Funciones.DesbloquearFormulario(me, array, readOnly) : me.getForm().reset();
    },
    LimpiarFormulario: function () {
        var me = this;
        me.getForm().reset();
        //me.record = null;

    },
    CargarDatos: function (record) {
        var me = this;
        //alert("entro");
        me.record = record;
        me.getForm().reset();
        me.BloquearFormulario();
        me.getForm().loadRecord(record);
    },

    loadFormulario: function (controlador, accion, params, reset) {
        var me = this;
        me.getForm().load({
            url: Constantes.HOST + '' + controlador + '/' + accion + '',
            params: params,
            failure: function (form, action) {
                if (reset == null) {
                    form.reset();
                }
                console.log("No existe ningun dato")
            }
        }); 
    },


});
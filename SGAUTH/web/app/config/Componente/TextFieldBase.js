Ext.define("App.Config.Componente.TextFieldBase", {
    extend: "Ext.form.TextField",
    alias: 'widget.TextFieldBase',
    margin: '10 0 10 0',
    disabledCls: 'DisabledClase',
    readOnlyCls: 'DisabledClaseReadOnly',
    //    vtype: "uppercase",
    maxLength: 30,
    emptyText: 'Introduzca...',
    enforceMaxLength: true,
    width: 240,
    labelWidth: 110,
    selectOnFocus: true,
    mensaje: '',
    titulo: '',
    scope: this,
    opc: '',
    opcHora : '',
    /**
     * propiedad que convierte en mayuscula o no b
     *valores true or false
     */
    mayus : true,
    initComponent: function () {
        var me = this;
        me.ConvertirCampoRequerido();
        if (me.titulo != '') {
            me.on('render', function (obj) {
                obj.tip = Ext.create('Ext.tip.ToolTip', {
                    target: me.getEl(),
                    title: me.titulo,
                    html: me.mensaje
                });
            });
        }
        if (me.mayus) {
            me.on('blur', function (obj) {
                var text = Ext.util.Format.uppercase(obj.getValue());
                me.setValue(text);
            });
        }
        if (me.vtype == 'Hora') {
            me.value = me.opcHora == ''? null :  Ext.Date.format(new Date(), 'H:i');
        }
        if (me.readOnly) {
            me.maxLength = 10000;
        }
        me.callParent(arguments);
    },
    ConvertirCampoRequerido: function () {
        var me = this;
        if (me.allowBlank == false) {
            if (Ext.typeOf(me.afterLabelTextTpl) == 'undefined') { me.afterLabelTextTpl = Constantes.REQUERIDO }
            //else { me.afterLabelTextTpl = Constantes.REQUERIDO  }
        }
    },
    reset: function () {
        var me = this;
        me.beforeReset();
        if (me.vtype == 'Hora') {
            var newvalue = me.opcHora == '' ? null : Ext.Date.format(new Date(), 'H:i');
            me.setValue(newvalue);
        }
        else {
            me.setValue(me.originalValue);
        }
        me.clearInvalid();
        delete me.wasValid;
    },

});

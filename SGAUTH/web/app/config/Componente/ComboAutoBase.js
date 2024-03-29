﻿Ext.define("App.Config.Componente.ComboAutoBase", {
    extend: "Ext.form.ComboBox",
    alias: ['widget.comboboxAuto', 'widget.comboAuto'],
    fieldLabel: 'Buscar ',
    name: 'NAME',
    typeAhead: false,
    emptyText: 'Buscar...',
    disabledCls: 'DisabledClase',
    readOnlyCls: 'DisabledClaseReadOnly',
    selectOnFocus: true,
    displayField: 'DISPLAY',
    hideTrigger: false,
    pageSize: 10,
    matchFieldWidth: false,
    forceSelection: true,
    editable: true,
    queryParam: 'contiene',
    minChars: 1,
    width: 240,
    labelWidth: 110,
    textoResultado: 'Buscando',
    anchor: '100%',
    textoVacio: 'No Existe Resultados',
    datos : null,
    initComponent: function () {
        var me = this;
        me.callParent(arguments); //y
    },
    refrescarStore : function(){
      this.getStore().load();
    },
    setDisabled: function (disabled) {
        this.forceSelection = disabled ? false : true;
        return this[disabled ? 'disable' : 'enable']();
    },
    setReadOnly: function (readOnly) {
        var me = this,
            old = me.readOnly;
        if (readOnly) {
            this.forceSelection = false;
        }
        me.callParent(arguments);
        if (readOnly != old) {
            me.updateLayout();
        }
    },
    ConvertirCampoRequerido: function () {
        var me = this;
        if (me.allowBlank == false) {
            if (Ext.typeOf(me.afterLabelTextTpl) == 'undefined') { me.afterLabelTextTpl = Constantes.REQUERIDO }
            //else { me.afterLabelTextTpl = Constantes.REQUERIDO  }
        }
    },
    limpiarCombo: function (cmb, a) {
        var me = this;
        if (this.getValue() === null) {
            this.reset();
        }
    }
});

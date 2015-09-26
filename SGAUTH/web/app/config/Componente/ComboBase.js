Ext.define("App.Config.Componente.ComboBase", {
    extend: "Ext.form.ComboBox",
    alias: 'widget.comboBase',
    queryMode: 'local',
    forceSelection: false,
    margin: '0 0 0 10',
    typeAhead: true,
    minChars: 2,
    emptyText: 'Seleccione...',
    disabledCls: 'DisabledClase',
    readOnlyCls: 'DisabledClaseReadOnly',
    displayField: 'VALOR',
    width: 240,
    selectOnFocus: true,
    labelWidth: 110,
    initComponent: function () {
        var me = this;
        me.on('assertValue', function () {
            var me = this;
            if (!me.forceSelection) {
                me.collapse();
            } else {
                me.callParent();
            }
        });
        me.on('change', me.limpiarCombo, this);
        me.callParent(arguments); //y
    },
    setDisabled: function (disabled) {
        this.forceSelection = disabled ? false : true;
        return this[disabled ? 'disable' : 'enable']();
    },
    limpiarCombo: function (cmb, a) {
        var me = this;
        if (this.getValue() === null) {
            this.reset();
        }
    }
});
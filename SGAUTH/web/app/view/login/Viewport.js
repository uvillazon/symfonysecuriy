Ext.define('App.View.Login.Viewport', {
    extend: 'Ext.container.Viewport',
    xtype: 'login-viewport',
    layout: 'border',

    initComponent: function () {

        var win = Ext.create("App.View.Login.Login").show();
        return this.callParent(arguments);
    }
});
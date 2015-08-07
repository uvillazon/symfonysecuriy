/* File Created: August 4, 2013 */

Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('App', 'App');
Ext.Loader.setPath("Extensible","App/extensible");
Ext.require([
    'App.*'
]);
if(window.localStorage.length === 0){
    //alert("as");
    document.location = 'logon';
}
Ext.application({
    name: 'App',
    appFolder: 'App',
//            controllers: ['app.Controller.Main'],

    launch: function () {
        Ext.tip.QuickTipManager.init();
        var panel = Ext.create('App.View.Principal.Principal', {
            app : this
            //            renderTo: 'contenido'
        });
    }
});

/* File Created: August 4, 2013 */

Ext.Loader.setConfig({ enabled: true });
Ext.Loader.setPath('App', 'App');
Ext.Loader.setPath("Extensible","App/extensible");
Ext.require([
    'App.*'
]);
//console.dir(window.localStorage);
//alert("entrara");
//var dec = Ext.util.Base64.decode(window.localStorage.token);
//console.log(dec);
//validamos si existe el token
if(window.localStorage.length === 0){
    //alert("as");
    document.location = 'logon';

}
else{
    console.dir(window.localStorage);
}
Ext.application({
    name: 'App',
    appFolder: 'App',
    controllers: [],
    launch: function () {
        Ext.tip.QuickTipManager.init();
        var panel = Ext.create('App.View.Principal.Principal', {
            app : this
            //            renderTo: 'contenido'
        });
    }
});

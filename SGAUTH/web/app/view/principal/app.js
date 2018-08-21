/* File Created: August 4, 2013 */
Ext.Loader.setConfig({enabled: true});
Ext.Loader.setPath('App', 'App');
Ext.Loader.setPath("Extensible", "App/extensible");
Ext.require([
    'App.*',
    'App.Config.JwtService',
    'App.Config.LocalStorageService',
    'App.Config.Constantes',
    "App.Config.Funciones",
]);
// //console.dir(window.localStorage);
// //alert("entrara");
// //var dec = Ext.util.Base64.decode(window.localStorage.token);
// //console.log(dec);
// //validamos si existe el token
// if(window.localStorage.length === 0){
//     //alert("as");
//     document.location = 'logon';
//
// }
// else{
//     console.dir(window.localStorage);
// }
Ext.application({
    name: 'App',
    appFolder: 'App',
    controllers: [],
    launch: function () {
        var me = this;
        var token;
        Ext.tip.QuickTipManager.init();
        token = localStorage.getItem("token");
        var isTokenExpired = token ? jwtService.isTokenExpired(token) : false;
        console.log(isTokenExpired);
        if (!isTokenExpired && token) {
            toggleCSS.remove();

                var panel = Ext.create('App.View.Principal.Principal', {
                    app : this
                });
        }
        else {
                var panel = Ext.create('App.View.Login.Viewport', {
                    app : this
                });
           }

    }
});

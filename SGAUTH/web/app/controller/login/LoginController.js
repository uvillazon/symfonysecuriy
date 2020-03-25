Ext.define('App.controller.Login.LoginController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.login',

    onButtonClickIngresar: function (button, e, options) {
        var _this = this;
        var loginForm = this.lookupReference('loginForm');
        var credenciales = loginForm.getValues();

        _this.getView().getEl().mask('Verificando credenciales....');
        var loginService = Ext.create("App.Service.Login.LoginService");

        return loginService.login(credenciales).then({
            success: function (res) {
                console.log(res);
                console.log(localStorageService);
                // alert("entroo");
                localStorageService.set("token", res.data.token);
                localStorageService.set("user", res.data.usuario);
                localStorageService.set("menu", res.data.menu);
                window.localStorage.setItem("token", res.data.token);
                window.localStorage.setItem("usuario_sgauth", JSON.stringify(res.data.usuario));
                window.localStorage.setItem("menu_sgauth", JSON.stringify(res.data.menu));
                window.localStorage.setItem("aplicacion_sgauth", JSON.stringify(res.data.aplicacion));
                // window.sessionStorage.setItem("token",res.data.token);
                // window.location = Constantes.obtenerHost();
                // window.location.reload();
                _this.getView().close();
                window.location.reload();
                button.up('window').close();
                return true;
            },
            failure: function (errorMessage) {
                return Ext.Msg.alert("Error", errorMessage)
            }
        }).always(function () {
            return _this.getView().getEl().unmask();
        });
    },

    onKeyup: function (field, event, options) {
        var _this = this;
        if (event.getCharCode() == event.ENTER) {
            var btn = _this.lookupReference('btnLogin');
            _this.onButtonClickIngresar(btn);
        }
    }

})
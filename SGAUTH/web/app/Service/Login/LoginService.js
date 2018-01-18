Ext.define('App.Service.Login.LoginService', {
        requires: [ 'Ext.Ajax'], 
        constructor: function(config) {
                if (config == null) {
                   config = {};
                }
                this.initConfig(config);
                return this.callParent(arguments);
        },
        login: function ( credenciales ) {
                var deferred = new Ext.Deferred();
                Ext.Ajax.request({
                        url: 'login/tokens',
                        params: credenciales,
                        method: 'POST',
                        //cors: true,
                        //useDefaultXhrHeader : false,
                        /*headers: {
                          'Access-Control-Allow-Origin': '*'
                        },*/
                        success: function ( response, options ) { 
                                var res = Ext.JSON.decode( response.responseText ); 
                                if (res.success) {
                                        var res =   Ext.JSON.decode( response.responseText );
                                        deferred.resolve(res); 
                                } 
                                else { 
                                        deferred.reject(res.msg); 
                                } 
                        }, 
                        failure: function ( response, options ) { 
                                deferred.reject(); 
                        } 
                }); 
                 
                return deferred.promise; 
        } 
         
}); 
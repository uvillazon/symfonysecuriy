﻿/* File Created: August 4, 2013 */
Ext.onReady(function () {
    Ext.QuickTips.init();

    function RecuperarPassword(num) {
        Ext.Msg.alert("Enbtro amgo  " + num);
    };
    var storeApp = Ext.create('Ext.data.Store', {
        fields: ['id_aplic', 'codigo'],
        proxy: {
            type: 'rest',
            url: 'rest-api/aplicaciones/aplicaciones.json',
            extraParams:{
                estado : 'ACTIVO'
            },
            reader: {
                type: 'json',
                root: 'rows'
            }
        },
        autoLoad: true
    });
    // Create a variable to hold our EXT Form Panel. 
    // Assign various config options as seen.	 
    var login = new Ext.FormPanel({
        labelWidth: 80,
        frame: true,
        layout: {
            type: 'table',
            columns: 2
        },
        title: 'Ingrese su usuario y contraseña',
        defaultType: 'textfield',
        monitorValid: true,
        // Specific attributes for the text fields for username / password. 
        // The "name" attribute defines the name of variables sent to the server.
        items: [
            {
                xtype: 'image',
                rowspan: 3,
                src: 'Content/images/seguridad.png',
                height : 150,
            },
            {
                xtype: 'hiddenfield',
                name: 'codigoApp',
                value: 'SGAUTH'
            },
            {
                fieldLabel: 'Usuario',
                itemId: 'usuario',
                name: 'username',
                allowBlank: false
            }, {
                fieldLabel: 'Contraseña',
                itemId: 'contrasena',
                name: 'password',
                inputType: 'password',
                allowBlank: false,
                enableKeyEvents: true,
                listeners: {
                    keyup: function (field, event, options) {
                        if (event.getCharCode() == event.ENTER) {
                            login.getForm().submit({
                                method: 'POST',
                                url: 'login/tokens',
                                waitTitle: 'Conectando',
                                waitMsg: 'Verificando credenciales...',
                                success: function (form,action) {
                                    window.localStorage.setItem("token",action.result.data.token);
                                    window.localStorage.setItem("usuario_sgauth",JSON.stringify(action.result.data.usuario));
                                    window.localStorage.setItem("menu_sgauth",JSON.stringify(action.result.data.menu));
                                    window.localStorage.setItem("aplicacion_sgauth",JSON.stringify(action.result.data.aplicacion));
                                    window.location =Constantes.obtenerHost();
                                    win.hide();
                                },
                                failure: function (form, action) {
                                    var razon = action.result;
                                    var u = login.query('#usuario')[0];
                                    var c = login.query('#contrasena')[0];

                                    Ext.Msg.alert('Error en el acceso!', razon.msg,function(){
                                        c.focus();
                                        c.reset();
                                    });
                                }
                            });
                        }
                    }
                }

            },
            {
                xtype : 'combobox'    ,
                fieldLabel: 'Aplicacion',
                itemId: 'aplicacion',
                name: 'id_aplic',
                displayField: 'codigo',
                valueField : 'id_aplic',
                allowBlank: false     ,
                store : storeApp
            }   ,
            {
                xtype: 'component',
                autoEl: {
                    href: 'javascript:Recup.RecuperarPassword()',
                    html: 'Olvido su Contraseña!',
                    tag: 'a',
                }
            }
        ],

        // All the magic happens after the user clicks the button     
        buttons: [{
            text: 'Login',
            formBind: true,
            // Function that fires when user clicks the button 
            handler: function () {
                login.getForm().submit({
                    method: 'POST',
                    url: 'login/tokens',
                    waitTitle: 'Conectando',
                    waitMsg: 'Verificando credenciales...',

                    // Functions that fire (success or failure) when the server responds. 
                    // The one that executes is determined by the 
                    // response that comes from login.asp as seen below. The server would 
                    // actually respond with valid JSON, 
                    // something like: response.write "{ success: true}" or 
                    // response.write "{ success: false, errors: { reason: 'Login failed. Try again.' }}" 
                    // depending on the logic contained within your server script.
                    // If a success occurs, the user is notified with an alert messagebox, 
                    // and when they click "OK", they are redirected to whatever page
                    // you define as redirect. 

                    success: function (form,action) {
                        window.localStorage.setItem("token",action.result.data.token);
                        window.localStorage.setItem("usuario_sgauth",JSON.stringify(action.result.data.usuario));
                        window.localStorage.setItem("menu_sgauth",JSON.stringify(action.result.data.menu));
                        window.localStorage.setItem("aplicacion_sgauth",JSON.stringify(action.result.data.aplicacion));
                        window.location =Constantes.obtenerHost();
                        win.hide();
                    },

                    // Failure function, see comment above re: success and failure. 
                    // You can see here, if login fails, it throws a messagebox
                    // at the user telling him / her as much.  

                    failure: function (form, action) {
                        var razon = action.result;

                        var u = login.query('#usuario')[0];
                        var c = login.query('#contrasena')[0];

                        c.focus();
                        c.reset();
                        Ext.Msg.alert('Error en el acceso!', razon.msg);
                        //alert(u.getItemId());
                        //login.getForm().reset();
                    }
                });
            }
        }],
    });

    //login.omn

    // This just creates a window to wrap the login form. 
    // The login object is passed to the items collection.       
    var win = new Ext.Window({
        layout: 'fit',
        width: 480,
        height: 250,
        closable: false,
        resizable: false,
        draggable: true,
        plain: true,
        border: false,
        items: [login]
    });
    win.show();

});
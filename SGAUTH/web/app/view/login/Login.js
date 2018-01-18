Ext.define('App.View.Login.Login', {
    extend: 'Ext.window.Window',
    alias: 'widget.login',
    requires: [
        'App.controller.Login.LoginController'
    ],
    controller: 'login',
    id: 'loginWindow',
    autoShow: true,
    height: 170,
    width: 360,
    layout: {
        type: 'fit'
    },
    bodyStyle: {
        background: '#F0F4F9',
        font: '12px Georgia, "Times New Roman", Times, serif',
        color: '#888',
        border: '1px solid #E4E4E4'
    },
    labelStyle: 'font-weight:bold;font-size:10px!important;',
    iconCls: 'lock',
    title: 'Login',
    closeAction: 'hide',
    closable: false,
    modal: true,
    config: {
        appConfig: null,
        requiredStyle: "<span class='ux-required-field' data-qtip='Required'>*</span>"
    },
    initComponent: function () {
        var me = this;

        Ext.applyIf(me, {
            items: [
                {
                    xtype: 'form',
                    reference: 'loginForm',
                    frame: false,
                    bodyPadding: 15,
                    bodyStyle: {
                        background: '#F0F4F9',
                        font: '12px Georgia, "Times New Roman", Times, serif',
                        color: '#888',
                        border: '1px solid #E4E4E4'
                    },
                    defaults: {
                        xtype: 'textfield',
                        anchor: '100%',
                        //labelWidth: 60,
                        allowBlank: false,
                        msgTarget: 'under',
                        minLength: 3,
                        blankText: 'Este campo es obligatorio',
                        minLengthText: 'El tama�o minimo de este campo es de 3 carcteres',
                        //afterLabelTextTpl: this.getRequiredStyle(),
                        labelAlign: "right"
                    },
                    items: [
                        {
                            name: 'username',
                            fieldLabel: 'Usuario',
                            labelAlign: 'right',
                            labelStyle: 'font-weight:bold;font-size:11px!important;',
                            itemId: 'usernameField',
                            enableKeyEvents: true,

                        },
                        {
                            inputType: 'password',
                            name: 'password',
                            itemId: 'passwordField',
                            fieldLabel: 'Contrase&#241;a',
                            labelAlign: 'right',
                            labelStyle: 'font-weight:bold;font-size:11px!important;',
                            enableKeyEvents: true,
                            listeners: {
                                keyup: 'onKeyup'
                            }

                        },
                        {
                            xtype: 'combobox',
                            fieldLabel: 'Aplicacion',
                            labelStyle: 'font-weight:bold;font-size:11px!important;',
                            itemId: 'aplicacion',
                            name: 'id_aplic',
                            displayField: 'codigo',
                            valueField: 'id_aplic',
                            allowBlank: false,
                            store: Ext.create('App.Store.Aplicaciones.AplicacionesST')
                        },
                        {
                            name: 'codigoApp',
                            fieldLabel: 'Codigo',
                            value: 'SGAUTH',
                            //value: 'SGLABMED',
                            hidden: true
                        }
                    ],
                    dockedItems: [
                        {
                            xtype: 'toolbar',
                            dock: 'bottom',
                            items: [
                                {
                                    xtype: 'component',
                                    // html: '<a href="'.concat(sgo.config.AppConfig.getEndpoint("recuperarPassword").url, '" style="margin-left: 5px;">Recuperar Contrase&#241;a</a>'),
                                    iconCls: 'server_key',
                                },
                                {
                                    xtype: 'tbfill'
                                },
                                {
                                    xtype: 'button',
                                    reference: 'btnLogin',
                                    text: 'Ingresar',
                                    iconCls: 'key',
                                    formBind: true,
                                    handler: 'onButtonClickIngresar'
                                }
                            ]
                        }
                    ]
                }],

        });
        me.callParent(arguments);
    }

});
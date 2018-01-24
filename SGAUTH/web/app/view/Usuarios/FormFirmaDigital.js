/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Usuarios.FormFirmaDigital", {
    extend: "App.Config.Abstract.Form",
    title: "Datos Del Certificado del Usuario",

    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;


        me.hid_id_usuario = Ext.widget('hiddenfield', {
            name: 'id_usuario',
            hidden : true,
        });


        me.items = [
            me.hid_id_usuario,
            {
                fieldLabel: 'Usuario',
                colspan: 2,
                width: 480,
                name: 'nombre',
                labelStyle: 'font-weight:bold;font-size:11px!important;',
                readOnly: true
            },
            {
                xtype: 'filefield',
                name: 'file',
                fieldLabel: 'Certificado *.p12',
                accept: '.p12',
                colspan : 2,
                width : 480,
                labelStyle: 'font-weight:bold;font-size:11px!important;',
                afterLabelTextTpl: Constantes.REQUERIDO,
                allowBlank: false,
                buttonText: 'Buscar',
                buttonConfig: {
                    iconCls: 'attach'
                }
            },
            {
                inputType: 'password',
                name: 'cert_pwd_base64',
                fieldLabel: 'Contrase&#241;a',
                allowBlank: false,
                width : 240,
                labelStyle: 'font-weight:bold;font-size:11px!important;',
                afterLabelTextTpl: Constantes.REQUERIDO
            },
            {
                xtype: 'datefield',
                fieldLabel: 'Fecha Certificado Caducidad',
                value: new Date(),
                name: 'fch_cert_caducidad',
                labelStyle: 'font-weight:bold;font-size:11px!important;',
                afterLabelTextTpl: Constantes.REQUERIDO,
                allowBlank: false,
                width : 240,
                submitFormat: 'Y-m-d',

            }
        ];


    }

});

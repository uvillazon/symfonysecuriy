Ext.define("App.View.Principal.Forms", {
    extend: "App.Config.Abstract.Form",
    title: "",
    botones: false,
    columns: 2,
    initComponent: function () {
        var me = this;
        if (me.opcion == "FormConstrasena") {
            me.title = "Cambio de Contraseña";
            me.CargarFormConstrasena();
        }
        else {
            alert("Seleccione alguna Opciones");
        }
        this.callParent(arguments);
    },
    CargarFormConstrasena: function () {
        var me = this;
        Ext.create("App.Config.ux.PasswordStrength");
        me.defaults = {
            width: 300,
            //inputType: 'password',
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
        };
        me.defaultType = 'textfield';
        me.items=  [
            {
                fieldLabel: 'Nueva Contraseña',
                name: 'contrasena',
                itemId: 'contrasena',
                inputType: 'password',
                //vtype: "passwordstrength",
                strength: 24,
                plugins: ["passwordstrength"]

            },
            {
                fieldLabel: 'Confirmar Contraseña',
                name: 'pass-cfrm',
                vtype: 'password',
                inputType: 'password',
                strength: 24,
                plugins: ["passwordstrength"],
                initialPassField: 'contrasena' // id of the initial password field
            },
             {
                 xtype: 'checkboxfield',
                 boxLabel: 'Mostrar Caracteres',
                 name: 'topping',
                 inputValue: '1',
                 allowBlank: true,
                 handler: function () {
                     alert("dasda");
                 }
             }
        ]
    }   
});

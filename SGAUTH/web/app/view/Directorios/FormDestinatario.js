Ext.define("App.View.Directorios.FormDestinatario", {
    extend: "App.Config.Abstract.Form",
    title: "Datos del Destinatario",
    opcion: '',
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;

        me.txt_id = Ext.create("App.Config.Componente.TextFieldBase", {
            name: "id_dest",
            hidden: true,
        });
        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Nombre",
            name: "nombre",
            width : 480,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan : 2
        });
        me.txt_apellido = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Apellido",
            name: "apellido",
            width : 480,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan : 2
        });

        me.txt_correo = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Email",
            vtype : 'email',
            name: "correo",
            width : 480,
            mayus : false,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan : 2
        });


        me.txt_estado = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Estado",
            name: "estado",
            width: 240,
            maxLength: 15,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            value :"ACTIVO",
            store : ["ACTIVO", "INACTIVO"]
        });
        me.items = [
            me.txt_id,
            me.txt_nombre,
            me.txt_apellido,
            me.txt_correo,
            me.txt_estado
        ];


    }
});

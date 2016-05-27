Ext.define("App.View.Listas.FormLista", {
    extend: "App.Config.Abstract.Form",
    title: "Datos del Tipo de Lista",
    opcion: '',
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;

        me.txt_id = Ext.create("App.Config.Componente.TextFieldBase", {
            name: "id_lista",
            hidden: true,
        });
        me.txt_lista = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Nombre de Lista",
            name: "lista",
            width : 480,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan : 2
        });
        me.txt_descripcion = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Descripcion",
            name: "descripcion",
            width: 480,
            maxLength: 50,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan : 2
        });
        me.num_tam_limite = Ext.create("App.Config.Componente.NumberFieldBase", {
            fieldLabel: "Tamano Maximo",
            name: "tam_limite",
            width: 240,
            maxLength: 5,
            minValue:1,
            allowNegative: false,
            allowDecimals: false,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
        });
        me.txt_tipo_valor = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Tipo de Lista",
            name: "tipo_valor",
            width: 240,
            maxLength: 10,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            store : ["CADENA","NUMERICO"]
        });
        me.txt_mayus_minus = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Mayus o Minus",
            name: "mayus_minus",
            width: 240,
            maxLength: 5,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            store: ["MAYUS", "MINUS"]
        });
        me.txt_estado = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Estado",
            name: "estado",
            width: 240,
            maxLength: 15,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            value :"A",
            store : ["A", "I"]
        });
        me.items = [
            me.num_id_lista,
            me.txt_lista,
            me.txt_descripcion,
            me.num_tam_limite,
            me.txt_tipo_valor,
            me.txt_mayus_minus,
            me.txt_estado,
        ];


    }
});

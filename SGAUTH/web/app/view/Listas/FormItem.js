Ext.define("App.View.Listas.FormItem", {
    extend: "App.Config.Abstract.Form",
    title: "Datos Items de Listas",
    initComponent: function () {
        var me = this;
        me.data = me.record;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;
        var opc = false;
        me.txt_id_lista = Ext.create("App.Config.Componente.TextFieldBase", {
            name: 'id_lista',
            hidden: true
        });
        me.txt_id = Ext.create("App.Config.Componente.TextFieldBase", {
            name: 'id_item',
            hidden: true
        });
        me.txt_lista = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: 'Tipo Lista',
            value: me.data.get('lista'),
            disabled: true
        });
        me.cbx_estado = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: 'Estado',
            name: 'estado',
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            store: ['A', 'I'],
            value: 'A'

        });
        if (me.data.get('tipo_valor') == "CADENA") {
            console.dir(me.data);
            if (me.data.get('mayus_minus') == 'MIXTO') {
                opc = false;
            }
            else {
                opc = true;
            }

            me.num_valor = Ext.create("App.Config.Componente.TextFieldBase", {
                fieldLabel: 'Valor',
                name: 'valor',
                afterLabelTextTpl: Constantes.REQUERIDO,
                allowBlank: false,
                mayus: opc,
                maxLength: me.data.get("tam_limite")

            });
        }
        else {
            me.num_valor = Ext.create("App.Config.Componente.NumberFieldBase", {
                fieldLabel: 'Valor',
                name: 'valor',
                afterLabelTextTpl: Constantes.REQUERIDO,
                decimalSeparator: '.',
                allowDecimals: true,
                allowBlank: false,
                maxLength: me.data.get("tam_limite")

            });
        }
        me.txt_codigo = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: 'Cod. Lista',
            name: 'codigo',
            itemId: 'codigo',
            afterLabelTextTpl: Constantes.REQUERIDO,
            maxLength: 10,
            allowBlank: false,
            mayus: opc,
            //margin: '10'sadsad
        });

        me.txt_orden = Ext.create("App.Config.Componente.NumberFieldBase", {
            fieldLabel: "Orden",
            name: "orden",
        });
        //////////////////////////////
        this.items = [
            /*  me.txt_id_bb,*/
            me.txt_id,
            me.txt_id_lista,
            me.txt_lista,
            me.txt_codigo,
            me.num_valor,
            me.txt_orden,
            me.cbx_estado
        ];

    }
});

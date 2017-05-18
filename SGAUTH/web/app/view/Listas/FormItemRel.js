Ext.define("App.View.Listas.FormItemRel", {
    extend: "App.Config.Abstract.Form",
    title: "Datos Items Rel de Listas",
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        me.cargarEventos();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;
        var opc = false;
        me.txt_id_padre = Ext.create("App.Config.Componente.TextFieldBase", {
            name: 'id_padre',
            hidden: true
        });
        me.txt_lista = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: 'Lista Padre',
            width: 480,
            colspan: 2,
            name: 'lista_padre',
            readOnly: true
        })

        me.txt_codigo = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: 'Codigo',
            readOnly: true,
            name: 'codigo'
        });


        me.txt_valor = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: 'Valor',
            readOnly: true,
            name: 'valor',


        });

        me.store_lista = Ext.create("App.Store.Listas.Listas");
        me.cbx_tipo_lista = Ext.create("App.Config.Componente.ComboAutoBase", {
            fieldLabel: 'Tipo Lista',
            displayField: 'lista',
            valueField: 'id_lista',
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            name: 'id_lista',
            store: me.store_lista
        });

        me.store_lista_item = Ext.create("App.Store.Listas.ListasItems");
        me.cbx_lista = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: 'Lista Item',
            name: 'id_hijo',
            displayField: 'valor',
            valueField: 'id_item',
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            selectOnFocus: true,
            store: me.store_lista_item
        });


        //////////////////////////////
        this.items = [
            /*  me.txt_id_bb,*/
            me.txt_id_padre,
            me.txt_lista,
            me.txt_codigo,
            me.txt_valor,
            me.cbx_tipo_lista,
            me.cbx_lista
        ];

    },
    cargarEventos: function () {
        var me = this;
        me.cbx_tipo_lista.on('select', function (cmb, record, index) {
            // console.log(record);
            me.store_lista_item.setExtraParams( {id_lista: record.get('id_lista')});
            // me.store_lista_item.load(
            //     {params: {id_lista: record.get('id_lista')}}
            // );
            me.cbx_lista.clearValue();
        })
    }
});

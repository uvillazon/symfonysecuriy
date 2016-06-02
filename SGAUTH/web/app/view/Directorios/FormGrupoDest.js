Ext.define("App.View.Directorios.FormGrupoDest", {
    extend: "App.Config.Abstract.Form",
    title: "Agregar Destinatario a Grupo",
    opcion: '',
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        this.callParent(arguments);
    },
    CargarComponentes: function () {
        var me = this;

        me.txt_id = Ext.create("App.Config.Componente.TextFieldBase", {
            name: "id_grp",
            hidden: true,
        });
        me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Nombre Grupo",
            name: "nombre",
            width : 480,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            colspan : 2      ,
            readOnly : true
        });
        me.store_dest = Ext.create("App.Store.Directorios.Destinatarios");
        me.cbx_dest = Ext.create("App.Config.Componente.ComboAutoBase", {
            fieldLabel: 'Destinatarios',
            displayField: 'nombre',
            valueField: 'id_dest',
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            name: 'id_dest',
            colspan: 2,
            width: 480,
            store: me.store_dest,
            listConfig : {
                loadingText: 'Buscando',
                emptyText: 'No Existe Resultado',
                getInnerTpl :  function () {
                    return '<h4>{nombre} {apellido}</h4>  {correo}';
                }
            }
            // textoTpl: function () {
            //     return '<h4>{nombre} {apellido}</h4>  {correo}';
            // }
        });

        me.txt_tipo = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Tipo Mensaje",
            name: "tipo_msg_dest",
            width: 240,
            maxLength: 15,
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            value :"ORIGINAL",
            store : ["ORIGINAL", "COPIA"]
        });
        me.items = [
            me.txt_id,
            me.txt_nombre,
            me.cbx_dest,
            me.txt_tipo
        ];


    }
});

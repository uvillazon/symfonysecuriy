/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define("App.View.Usuarios.FormUsuario", {
    extend: "App.Config.Abstract.Form",
    title: "Datos de Usuario",
    cargarStores: true,
    //Observar el ultimo comentario de la transicion de ESTADO
    verObservacion: true,
    listeners: {
        boxready: 'onBoxready'
    },
    config: {
        usuario: null
    },
    onBoxready: function () {
        var me = this;

        console.log('onBoxready FormUsuario');
        console.log(me.getUsuario());
        if(Ext.isEmpty(me.getUsuario()))
        {
            me.rg_baseTropico.setDisabled(true);
        }
        else{
            if(Ext.isEmpty(me.getUsuario().get('idproveedor'))){
                me.rg_baseTropico.setDisabled(true);
            }
        }

    },
    initComponent: function () {
        var me = this;
        me.CargarComponentes();
        me.Eventos();
        this.callParent(arguments);
    },
    Eventos: function () {
        var me = this;
        me.txt_nombre.on('select', function (cbx, rec) {
            console.dir(rec);
            me.txt_login.setValue(rec.get('login'));
            me.txt_email.setValue(rec.get('email'));
        });
        me.cbx_proveedor.on('select',function () {
            me.rg_baseTropico.setDisabled(false);
        });
        me.cbx_proveedor.on('change',function (cbx,newValue,oldValue) {
            if(Ext.isEmpty(newValue)){
                me.rg_baseTropico.setDisabled(true);
            }
        });

    },
    CargarComponentes: function () {
        var me = this;

        me.txt_id = Ext.create("App.Config.Componente.TextFieldBase", {
            name: "id_usuario",
            hidden: true,
        });
        //me.hid_perfil = Ext.widget('hiddenfield', {
        //    name: 'ID_PERFIL',
        //});
        me.store_usuarioAd = Ext.create("App.Store.Usuarios.UsuariosAD");
        me.txt_nombre = Ext.create("App.Config.Componente.ComboAutoBase", {
            fieldLabel: 'Nombres',
            displayField: 'nombre',
            valueField: 'nombre',
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            name: 'nombre',
            colspan: 2,
            width: 480,
            anyMatch: true,
            store: me.store_usuarioAd,
            textoTpl: function () {
                return '<h4>{codigo}</h4>  {nombre}';
            }
        });

        me.rg_filtro = Ext.create('Ext.form.RadioGroup', {
            fieldLabel: 'Buscar Por',
            bodyPadding: 10,
            columns: 2,
            colspan: 2,
            width: 480,
            items: [
                {boxLabel: 'Nombre y Apellido', name: 'condicion', inputValue: 'cn', checked: true},
                {boxLabel: 'Login', name: 'condicion', inputValue: 'samaccountname'}
            ],
            listeners: {
                change: function (rg, newValue, oldValue) {
                    me.store_usuarioAd.setExtraParams(newValue);
                    me.txt_nombre.reset();
                    // me.store_usuarioAd.load();
                    // console.log(newValue);
                    // console.log(oldValue);
                }
            }
        });

        me.rg_baseTropico = Ext.create('Ext.form.RadioGroup', {
            fieldLabel: 'Proveedor con base en TROPICO',
            bodyPadding: 10,
            columns: 2,
            colspan: 2,
            width: 480,
            items: [
                {boxLabel: 'SI', name: 'base_tropico', inputValue: 'true'},
                {boxLabel: 'NO', name: 'base_tropico', inputValue: 'false', checked: true}
            ],
            // listeners : {
            //     change  : function (rg,newValue , oldValue) {
            //         me.store_usuarioAd.setExtraParams(newValue);
            //         me.txt_nombre.reset();\
            //     }
            // }
        });
        // me.txt_nombre = Ext.create("App.Config.Componente.TextFieldBase", {
        //     fieldLabel: "Nombre Completo",
        //     name: "nombre",
        //     afterLabelTextTpl: Constantes.REQUERIDO,
        //     allowBlank: false,
        //     colspan: 2,
        //     width: 480,
        // });


        me.txt_login = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Login",
            name: "login",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            mayus: false
        });

        me.store_area = Ext.create("App.Store.Areas.Areas");


        me.cbx_area = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Area",
            name: "id_area",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            displayField: 'nom_area',
            valueField: 'id_area',
            store: me.store_area.load()

        });
        me.txt_email = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Em@il",
            name: "email",
            // afterLabelTextTpl: Constantes.REQUERIDO,
            // allowBlank: false,
            width: 480,
            vtype: 'email',
            colspan: 2

        });

        me.txt_telefono = Ext.create("App.Config.Componente.TextFieldBase", {
            fieldLabel: "Telefonos",
            name: "telefono",
            // afterLabelTextTpl: Constantes.REQUERIDO,
            // allowBlank: false,
            width: 480,
            colspan: 2

        });
        me.cbx_estado = Ext.create("App.Config.Componente.ComboBase", {
            fieldLabel: "Estado",
            name: "estado",
            afterLabelTextTpl: Constantes.REQUERIDO,
            allowBlank: false,
            value: 'ACTIVO',
            colspan: 2,
            store: ['ACTIVO', 'INACTIVO'],

        });

        me.store_empleado = Ext.create("App.Store.Erp.Empleados");
        me.cbx_empleado = Ext.create("App.Config.Componente.ComboAutoBase", {
            fieldLabel: 'Id Empleado',
            displayField: 'idempleado',
            valueField: 'idempleado',
            name: 'idempleado',
            store: me.store_empleado,
            listConfig: {
                loadingText: 'Buscando',
                emptyText: 'No Existe Resultado',
                getInnerTpl: function () {
                    return '<h4>{idempleado}</h4>  {nombre}';
                }
            }
        });

        me.store_proveedor = Ext.create("App.Store.Erp.Proveedores");
        me.cbx_proveedor = Ext.create("App.Config.Componente.ComboAutoBase", {
            fieldLabel: 'Id Proveedor',
            displayField: 'idproveedor',
            valueField: 'idproveedor',
            name: 'idproveedor',
            store: me.store_proveedor,
            listConfig: {
                loadingText: 'Buscando',
                emptyText: 'No Existe Resultado',
                getInnerTpl: function () {
                    return '<h4>{idproveedor}</h4>  {descripcion}';
                }
            }
        });
        me.items = [
            me.txt_id,
            me.rg_filtro,
            me.txt_nombre,
            me.txt_login, me.cbx_area,
            me.txt_email,
            me.txt_telefono,
            me.cbx_empleado, me.cbx_proveedor,
            me.rg_baseTropico,
            me.cbx_estado,
        ];


    },

});

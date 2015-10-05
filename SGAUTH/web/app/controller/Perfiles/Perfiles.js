/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.Perfiles.Perfiles', {
    extend: 'App.Config.Abstract.Controller',
    classPrincipal: 'App.View.Perfiles.Principal',
    idCmpBotton: 'cmpButtonPerfil',
    refs: [{
        ref: 'gridBotones',
        selector: '#gridBotonesPerfil'
    }, {
        ref: 'gridOpciones',
        selector: '#gridOpcionesPerfil'
    }
    ],
    init: function () {
        var me = this;
        me.control({
            'button[itemId=btn_crearPerfil]': {
                click: me.winCrearPerfil
            },
            'button[itemId=btn_editarPerfil]': {
                click: me.winCrearPerfil
            },
            'combobox[itemId=per_cbx_app]': {
                select: me.filtrarPorApp
            },
            '#btn_agregarOpcion': {
                click: me.winAgregarOpcion
            },
            '#btn_quitarOpcion': {
                click: me.quitarOpcionPerfil
            },
            '#btn_agregarBoton': {
                click: me.winAgregarBoton
            },
            '#btn_quitarBoton': {
                click: me.quitarBotonPerfil
            },
            'grid[itemId=gridOpcionesPerfil]':{
                selectionchange : me.cargarBotones
            },
            'grid[itemId=gridBotonesPerfil]':{
                selectionchange : me.cargarOpciones
            }

        });

        this.callParent();
        me.cargarEventos();
    },
    filtrarPorApp: function (cbx, record) {
        var me = this;
        me.cmpPrincipal.grid.getStore().setExtraParams({id_aplic: record.get("id_aplic")});
        me.cmpPrincipal.grid.getStore().load();

    }
    ,
    cargarEventos: function () {
        var me = this;
        me.cmpPrincipal.grid.getSelectionModel().on('selectionchange', me.cargarDatosGrid, this);


    }    ,
    cargarDatosGrid: function (selModel, selections) {
        var me = this;
        disabled = selections.length === 0;
        me.record = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_editarPerfil', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_agregarOpcion', me.cmpPrincipal, disabled);
        if (!disabled) {
            me.cmpPrincipal.form.CargarDatos(me.record);
            me.getGridOpciones().getStore().setExtraParams({id_perfil: me.record.get("id_perfil")});
            me.getGridOpciones().getStore().load();
            me.getGridBotones().getStore().setExtraParams({id_perfil: me.record.get("id_perfil")});
            me.getGridBotones().getStore().load();
        }
        else {
            me.cmpPrincipal.form.getForm().reset();
            me.getGridOpciones().getStore().setExtraParams({id_perfil: 0});
            me.getGridOpciones().getStore().load();
            me.getGridBotones().getStore().setExtraParams({id_perfil: 0});
            me.getGridBotones().getStore().load();
        }
    }
    ,
    winCrearPerfil: function (btn) {
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Perfiles.FormPerfil", {botones: false});
        win.add(form);
        win.show();
        if (btn.getItemId() === "btn_editarPerfil") {
            form.getForm().loadRecord(me.record);
        }
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('perfiles', 'perfiles', win, form, me.cmpPrincipal.grid, 'Esta Seguro de guardar el Usuarios', null, win);
        });

    },
    cargarBotones : function(selModel, selections){
        var me = this;
        disabled = selections.length === 0;
        console.log(disabled);
        me.opcion = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_agregarBoton', me.cmpPrincipal, disabled);
        Funciones.DisabledButton('btn_quitarOpcion', me.cmpPrincipal, disabled);
        if (!disabled) {
            me.getGridBotones().getStore().filter('id_opc', me.opcion.get('id_opc'));
        }
        else {
            me.getGridBotones().getStore().clearFilter();
        }
    },
    cargarOpciones : function(selModel , selections){
        var me = this;
        disabled = selections.length === 0;
        console.log(disabled);
        me.boton = !disabled ? selections[0] : null;
        Funciones.DisabledButton('btn_quitarBoton', me.cmpPrincipal, disabled);
    },
    winAgregarOpcion : function(){
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Perfiles.FormOpcionPerfil", {botones: false});
        form.getForm().loadRecord(me.record);
        form.cargarOpcionesPorAplicaciones(me.record.get('id_aplic'));
        win.add(form);
        win.show();
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('opciones', 'agregars/opcions', win, form, me.getGridOpciones(), 'Esta Seguro de guardar los datos', null, win);
        });
    },
    quitarOpcionPerfil : function(){
        var me = this;
        Funciones.AjaxRequestGrid('opciones', 'quitars/opcions', me.cmpPrincipal, 'Esta Seguro de Eliminar', {id_perfil : me.record.get('id_perfil'),id_opc : me.opcion.get('id_opc')}, me.getGridOpciones());
    },
    winAgregarBoton : function(){
        var me = this;
        var win = Ext.create("App.Config.Abstract.Window", {botones: true, destruirWin: true});
        var form = Ext.create("App.View.Perfiles.FormBotonPerfil", {botones: false});
        form.getForm().loadRecord(me.opcion);
        form.getForm().loadRecord(me.record);
        form.cargarBotonesPorOpcion(me.opcion.get('id_opc'));
        win.add(form);
        win.show();
        win.btn_guardar.on('click', function () {
            Funciones.AjaxRequestWin('opciones', 'agregars/botones', win, form, me.getGridBotones(), 'Esta Seguro de guardar los datos', null, win);
        });
        //App.View.Perfiles.FormBotonPerfil"
    },
    quitarBotonPerfil : function(){
        var me = this;
        Funciones.AjaxRequestGrid('opciones', 'quitars/botons', me.cmpPrincipal, 'Esta Seguro de Eliminar', {id_perfil : me.record.get('id_perfil'),id_boton : me.boton.get('id_boton')}, me.getGridBotones());
    },
})
;
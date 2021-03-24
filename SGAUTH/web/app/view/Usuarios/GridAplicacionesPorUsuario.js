/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define("App.View.Usuarios.GridAplicacionesPorUsuario", {
    extend: "App.Config.Abstract.Grid",
    title: 'Aplicaciones Por Usuario',
    imprimir: true,
    criterios: true,
    opcion: '',
    paramsStore: null,
    noLimpiar: null,
    busqueda: true,
    //parametros obligados para mostrar reporte de historico de estados por tabla
    initComponent: function () {
        var me = this;

        me.store = Ext.create("App.Store.Usuarios.AppUsr");
        me.CargarComponentes();
        me.columns = [
            {xtype: "rownumberer", width: 30, sortable: false},
            {header: "Cod. App", width: 100, sortable: true, dataIndex: "codigo_app"},
            {header: "Nombre<br>Aplicacion", width: 200, sortable: true, dataIndex: "aplicacion"},
            {header: "Perfil", width: 100, sortable: true, dataIndex: "perfil"},
            {
                header: "Fecha Alta",
                width: 90,
                sortable: true,
                dataIndex: "fch_alta",
                renderer: Ext.util.Format.dateRenderer('d/m/Y')
            },
            {header: "Estado", width: 90, sortable: true, dataIndex: "estado"},
            {
                header: "Fecha Baja",
                width: 90,
                sortable: true,
                dataIndex: "fch_baja",
                renderer: Ext.util.Format.dateRenderer('d/m/Y')
            },
            {
                header: 'Activar/Inactivar',
                renderer: function (v, m, r) {
                    var id = Ext.id();
                    var nomBtn = r.get('estado') == 'ACTIVO' ? 'Inactivar' : 'Activar';
                    var iconBtn = r.get('estado') == 'ACTIVO' ? 'bullet_error' : 'lightning';
                    Ext.defer(function () {
                        Ext.widget('button', {
                            renderTo: id,
                            text: nomBtn,
                            iconCls: iconBtn,
                            width: 75,
                            handler: function () {
                                me.activarInactivarUsuario(r, nomBtn)
                                // me.energizarTransformador(r);
                            }
                        });
                    }, 50);
                    return Ext.String.format('<div id="{0}"></div>', id);

                }
            },
        ];

        this.callParent(arguments);

    },
    activarInactivarUsuario: function (record, accion) {
        var me = this;
        console.log('record', record);
        console.log('accion', accion);
        var msg = 'Esta Seguro de Activar al usuario en la aplicacion seleccionada';
        var estado = 'ACTIVO';
        var fecha_baja = '';
        if(accion =='Inactivar'){
            var dt = new Date();
            var msg = 'Esta Seguro de Inactivar al usuario en la aplicacion seleccionada';
            var estado = 'INACTIVO';
            var fecha_baja = Ext.Date.format(dt, 'Y-m-d H:i:s');
        }
        Funciones.AjaxRequestGrid('usuarios', 'usuariosapps', me, msg, {
            id_usuario: record.get('id_usuario'),
            id_aplic: record.get('id_aplic'),
            id_perfil: record.get('id_perfil'),
            operacion: 'EDICION',
            estado : estado,
            fch_baja : fecha_baja
        }, me);

    }
});
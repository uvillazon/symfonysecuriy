Ext.define("App.View.Principal.PanelInfo", {
    extend: "Ext.TabPanel",
    //    title:'DIAGRAMAS TRANSICION ESTADOS',
    defaults: {
        bodyStyle: 'padding:2px'
    },
    activeTab: 0,
    data: '',

    initComponent: function () {

        var me = this;
        var direccion = "http://192.168.60.20:8080/backend/elfec/wmc.php";
        this.items = [
        {
            title: 'SOLICITUDES DE MANTENIMIENTO',
            html: '<IMG SRC="Content/Iconos/DiagrEstados_SM.JPG" width="500" height="450">'
        }, {
            title: 'ORDENES DE TRABAJO',
            html: '<IMG SRC="Content/Iconos/DiagrEstados_OT.PNG" width="500" height="450">'
        },
        {
            title: 'MAPA',
            html : '<iframe name="' + direccion + 'frame" src="' + direccion + '" frameborder="0" width=100% height="100%" scrolling="yes"></iframe>'
        }
        ];
        this.callParent(arguments);

    }
});
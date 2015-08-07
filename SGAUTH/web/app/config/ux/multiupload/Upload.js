Ext.define('App.Config.ux.multiupload.Upload', {
    extend: 'Ext.flash.Component',
    requires: [
        'App.Config.ux.multiupload.UploadManager'
    ],
    alias: 'widget.uploader',
    width: 101,
    height: 22,
    wmode: 'transparent',
    url: Constantes.HOST + 'App/Config/ux/multiupload/Upload.swf',
    statics: {
        instanceId: 0
    },
    constructor: function (config) {
        config = config || {};
        config.instanceId = Ext.String.format('upload-{0}', ++App.Config.ux.multiupload.Upload.instanceId);
        config.flashVars = config.flashVars || {};
        config.flashVars = Ext.apply({
            instanceId: config.instanceId,
            buttonImagePath: Constantes.HOST + 'App/Config/ux/multiupload/button.png',
            buttonImageHoverPath: Constantes.HOST + 'App/Config/ux/multiupload/button_hover.png',
            fileFilters: 'Excel (*.xls, *.xlsx)|*.xls;*.xlsx',
            uploadUrl: Constantes.HOST + 'OrdenesTrabajo/GenerarOTDesdeArchivo',
            maxFileSize: 0,
            maxQueueLength: 0,
            maxQueueSize: 0,
            callback: 'App.Config.ux.multiupload.UploadManager.uploadCallback'
        }, config.uploadConfig);

        this.addEvents(
            'fileadded',
            'uploadstart',
            'uploadprogress',
            'uploadcomplete',
            'uploaddatacomplete',
            'queuecomplete',
            'queuedatacomplete',
            'uploaderror'
        );

        this.callParent([config]);
    },
    initComponent: function () {
        App.Config.ux.multiupload.UploadManager.register(this);
        this.callParent(arguments);
    },
    onDestroy: function () {
        App.Config.ux.multiupload.UploadManager.unregister(this);
        this.callParent(arguments);
    }
});

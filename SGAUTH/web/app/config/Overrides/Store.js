Ext.override(Ext.data.Store, {
    pageSize: 25,
    //metodo para el envio de parametros en el store la forma de envio {name : value} se puede enviar varios parametros
    setExtraParams: function (params) {
        this.proxy.extraParams = this.proxy.extraParams || {};
        for (var x in params) {
            this.proxy.extraParams[x] = params[x];
        }
        this.proxy.applyEncoding(this.proxy.extraParams);
    },
    //metodo para un solo parametro 
    setExtraParam: function (name, value) {
        this.proxy.extraParams = this.proxy.extraParams || {};
        if (value != null) {
            this.proxy.extraParams[name] = Ext.util.Format.uppercase(value);
        }
        else {
            this.proxy.extraParams[name] = value;
        }
        this.proxy.applyEncoding(this.proxy.extraParams);
    },
    //metodo que limpia lso parametros del store excepto los que hay en el array 
    //array solo nombres example ["name1","name2",...,"namen"]
    limpiarParametros: function (array) {
        var me = this;
        if (array != null) {
            var proxy = this.proxy.extraParams;
            this.proxy.extraParams = {};
            Ext.Object.each(proxy, function (key, value, myself) {
                for (i = 0 ; i < array.length ; i++) {
                    if (array[i] == key) {
                        me.proxy.extraParams[key] = value;
                    }
                }
            });
        }
        else {
            this.proxy.extraParams = {};
        }
        this.proxy.applyEncoding(this.proxy.extraParams);
    },
    //envio de parametros cuando el valor es de tipo fecha
    setExtraParamDate: function (name, value) {
        this.proxy.extraParams = this.proxy.extraParams || {};

        this.proxy.extraParams[name] = value;
        this.proxy.applyEncoding(this.proxy.extraParams);
    },
    //verifica si existe algun record dentro del store con ese valor y nombre solo busca uno
    existeRecord: function (name, value) {
        var data = this.data.items,
            dLen = data.length,
            record, d;

        for (d = 0; d < dLen; d++) {
            if (data[d].get(name) == value) {
                return true;
            }

        }
        return false;
    },
    //cantidad de registros que existe con ese name y value
    countRegistros: function (name, value) {
        var count = 0;
        var data = this.data.items,
            dLen = data.length,
            record, d;

        for (d = 0; d < dLen; d++) {
            if (data[d].get(name) == value) {
                count++;
            }

        }
        return count;
    }
});
Ext.Ajax.timeout = 120000;
//Ext.override(Ext.data.proxy.Ajax, { timeout: 120000 });
//Ext.override(Ext.ajax, {
//    timeout: 120000
//});
//Ext.Ajax.request
//Ext.override(Ext.data.proxy.Ajax, {
//    //timeout:60000,
//    doRequest: function (operation, callback, scope) {
//        var writer = this.getWriter(),
//            request = this.buildRequest(operation, callback, scope);

//        if (operation.allowWrite()) {
//            request = writer.write(request);
//        }

//        Ext.apply(request, {
//            headers: this.headers,
//            timeout: this.timeout,
//            //timeout : 120000,
//            scope: this,
//            callback: this.createRequestCallback(request, operation, callback, scope),
//            method: this.getMethod(request),
//            disableCaching: false // explicitly set it to false, ServerProxy handles caching
//        });

//        Ext.Ajax.request(request);
//        return request;
//    }
//});
Ext.override(Ext.form.field.TextArea, {
    maxLength: 500,
    enforceMaxLength: true
});

//Ext.override(Ext.grid.plugin.CellEditing,{
//    onSpecialKey: function(ed, field, e) {
//        var grid = this.grid; 
//        if (e.getKey() == 13){ 
//            grid.plugins[0].tabPressed = true 
//            var pos = grid.getSelectionModel().getCurrentPosition();
//            grid.plugins[0].startEditByPosition({row:pos.row,column:pos.column+1});
//        }else {   
//            var pos = grid.getSelectionModel().getCurrentPosition();
//            stop.event()
//            e.stopEvent();
//        }
//    }
//});
//Ext.override(Ext.grid.plugin.CellEditing, {
//    onSpecialKey: function (ed, field, e) {
//        var sm;
//        //alert(e);
//        if (e.getKey() === e.ENTER) {
//            e.stopEvent();

//            if (ed) {
//                // Allow the field to act on tabs before onEditorTab, which ends
//                // up calling completeEdit. This is useful for picker type fields.
//                ed.onEditorTab(e);
//            }

//            sm = ed.up('tablepanel').getSelectionModel();
//            if (sm.onEditorTab) {
//                return sm.onEditorTab(ed.editingPlugin, e);
//            }
//        }
//    }
//});
//Ext.override(Ext.grid.plugin.CellEditing,{
//    onSpecialKey: function(ed, field, e) {
//        var grid = this.grid; 
//        if (e.getKey() == 9) {
//            alert("9");
//            grid.plugins[0].tabPressed = true 
//            var pos = grid.getSelectionModel().getCurrentPosition();
//            grid.plugins[0].startEditByPosition({row:pos.row,column:pos.column+1});
//        } else  {
//            e.stopEvent();
//            if (ed) {
//                ed.onEditorTab(e);

//            }

//            sm = ed.up('tablepanel').getSelectionModel();
//            if (sm.onEditorTab) {
//                sm.onEditorTab(ed.editingPlugin, e);
//                return false;
//            }
//        }
//    }
//});
//Ext.override(Ext.grid.plugin.Editing, {
//    onEnterKey: function (e) {
//        alert("asdasd");
//        var me = this,
//            grid = me.grid,
//            selModel = grid.getSelectionModel(),
//            record,
//            pos,
//            columnHeader;

//        // Calculate editing start position from SelectionModel if there is a selection
//        // Note that the condition below tests the result of an assignment to the "pos" variable.
//        if (selModel.getCurrentPosition && (pos = selModel.getCurrentPosition())) {
//            record = pos.record;
//            columnHeader = pos.columnHeader;
//        }
//            // RowSelectionModel
//        else {
//            record = selModel.getLastSelected();
//            columnHeader = grid.columnManager.getHeaderAtIndex(0);
//        }

//        // If there was a selection to provide a starting context...
//        if (record && columnHeader) {
//            me.startEdit(record, columnHeader);
//        }
//    },
//});
Ext.override(Ext.grid.Panel, {
    //todos los grid tendra el icono por defecto de la aplicacion con lista
    iconCls: 'application_view_list',

});
//modificando el metodo de Ext.Msg.alert
//completando metodoss
Ext.override(Ext.window.MessageBox, {
    hide: function () {
        if (this.btn3 != null) {
            this.btn3.hide();
        }
        var me = this,
            cls = me.cfg.cls;

        me.dd.endDrag();
        me.progressBar.reset();
        if (cls) {
            me.removeCls(cls);
        }
        me.callParent(arguments);
        //alert("dasda");
    },
    alert: function (cfg, msg, fn, scope, btn) {
        var icono = null;
        //verificamos si existe un btn3 para ocultarlo y no mostrar en los otros mensajes
        if (this.btn3 != null) {
            this.btn3.hide();
        }
        if (cfg == 'Exito') {
            icono = this.INFO;
        }
        else if (cfg == 'Aviso') {
            icono = this.WARNING;
        }
        else {
            icono = this.ERROR;
        }
        if (Ext.isString(cfg)) {
            cfg = {
                title: cfg,
                msg: msg,
                buttons: this.OK,
                icon: icono,
                fn: fn,
                scope: scope,
                minWidth: this.minWidth
            };
        }

        return this.show(cfg);
    },
    //para agregar un boton en los ventans emergentes de confirmacion 
    confirm: function (cfg, msg, fn, scope, btn) {
        if (Ext.isString(cfg)) {
            cfg = {
                title: cfg,
                icon: this.QUESTION,
                msg: msg,
                buttons: this.YESNO,
                callback: fn,
                scope: scope
            };
        }
        if (btn != null) {
            btn.removeCls("botones");
            if (this.btn3 != null) {
                this.bottomTb.remove(this.btn3);
            }
            this.btn3 = btn;
            this.bottomTb.add(this.btn3);
        }
        else {
            if (this.btn3 != null) {
                this.btn3.hide();
            }
        }
        return this.show(cfg);
    }
});

Ext.override(Ext.form.ComboBox, {
    getSelectedIndex: function () {
        var v = this.getValue();
        var r = this.findRecord(this.valueField || this.displayField, v);
        return (this.store.indexOf(r));
    },

    getSelectedRecord: function () {
        var v = this.getValue();
        var r = this.findRecord(this.valueField || this.displayField, v);
        return (r);
    }
});

Ext.override(Ext.form.field.File, {
    extractFileInput: function () {
        var me = this,
            fileInput = me.fileInputEl.dom,
            clone = fileInput.cloneNode(true);

        fileInput.parentNode.replaceChild(clone, fileInput);
        me.fileInputEl = Ext.get(clone);

        me.fileInputEl.on({
            scope: me,
            change: me.onFileChange
        });

        return fileInput;
    }
});
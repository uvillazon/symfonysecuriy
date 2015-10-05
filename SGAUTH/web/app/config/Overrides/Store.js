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
Ext.override(Ext.form.field.TextArea, {
    maxLength: 500,
    enforceMaxLength: true
});

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
/**
 * @class App.Config.Funciones
 * @extends
 * @autor Ubaldo Villazon
 * @date 23/07/2013
 *
 * Funciones Comunes
 *
 **/
Ext.define("App.Config.Funciones", {
    alternateClassName: ["Funciones", "fn"],
    singleton: true,
    winReporte: null,
    nameReport: '',
    paramsReport: '',
    //token: "",
    token: {'Authorization': "Bearer " + window.localStorage.token},
    Fecha: function (value, record) {
        if (value == null) {
            return null;
        }
        else {
            var milli = value.replace(/\/Date\((-?\d+)\)\//, '$1');
            var d = new Date(parseInt(milli));
            return d;
        }
    },
    //funcion que bloque todos los componentes field de un formulario a exception de algunos definidos en el array 
    //tambien se define si los botones se taoman en cuenta para el bloquear true o false
    BloquearFormulario: function (form, array, btn) {
        var els = form.query('.field');
        //var btn = form.query('.button');
        Ext.each(els, function (o) {
            if (o.hidden == true || Funciones.EsComponenteNombre(o, array)) {
                o.setDisabled(false);
                o.setReadOnly(false);
            }
            else {
                o.setDisabled(true);
                o.setReadOnly(false);
            }
            //adasd
        });
        try {
            if (btn == null) {
                var btn = form.query('.button');
                Ext.each(btn, function (o) {
                    if (o.isHidden() == false) {
                        if (Funciones.EsComponenteBoton(o, array) == false) {
                            o.setDisabled(true);
                        }
                        else {
                            o.setDisabled(false);
                        }
                    }
                });
            }
        }
        catch (e) {
            console.log(e)
        }
    },

    BloquearFormularioReadOnly: function (form, array) {
        var els = form.query('.field');
        Ext.each(els, function (o) {
            if (Funciones.EsComponenteNombre(o, array)) {
                o.setReadOnly(false);
            }
            else {
                o.setReadOnly(true);
            }

        });
        try {
            var btn = form.query('.button');
            Ext.each(btn, function (o) {
                if (o.isHidden() == false) {
                    o.setDisabled(true);
                }
            });
        }
        catch (e) {
            Console.log(e)
        }
    },
    //Desbloquea todo el Formulario si recibe array
    //solo desbloqueara todos los campos excepto el que se envia en el array
    // en caso de que reciba un readOnly(bool) en ves de bloquear se pondra solo para Leer 
    DesbloquearFormulario: function (form, array, readOnly) {
        var els = form.query('.field');
        Ext.each(els, function (o) {
            if (Funciones.EsComponenteNombre(o, array)) {
                if (readOnly) {
                    o.setReadOnly(readOnly);
                    o.setDisabled(false);
                }
                else {
                    o.setDisabled(true);
                }
            }
            else {
                o.setDisabled(false);
            }

        });
        try {
            var btn = form.query('.button');
            Ext.each(btn, function (o) {
                if (Funciones.EsComponenteBoton(o, array) == false) {
                    o.setDisabled(false);
                }
                else {
                    o.setDisabled(true);
                }
                //if (o.isDisabled() == true) {
                //    o.setDisabled(false);
                //}
            });
        }
        catch (e) {
            Console.log(e)
        }
    },
    EsComponenteNombre: function (cmp, array) {
        for (x in array) {
            if (cmp.getName() == array[x]) {
                return true;
            }

        }
        return false;
    },
    EsComponenteBoton: function (btn, array) {
        for (x in array) {
            if (btn.getItemId() == array[x]) {
                return true;
            }

        }
        return false;
    },
    ActualizarReloj: function (reloj) {
        Ext.fly('clock').update(Ext.Date.format(new Date(), 'g:i:s A'));
    },
    CrearMenuBar: function (dock) {
        dock = (dock == null) ? 'top' : dock
        var menuBar = Ext.create("Ext.toolbar.Toolbar", {
            dock: dock,
        });
        return menuBar;
    },
    CrearMenu: function (id, nombre, icono, handler, menu, scope, controlador, /*para agregar diamicamente un controlador al controller principal*/ titulotab, tooltip, disabled, cls) {
        var boton = Ext.create('Ext.Button', {
            text: nombre,
            iconCls: icono,
            tooltip: tooltip,
            itemId: id,
            cls: cls == null ? 'botones' : cls,
            scope: scope,
            handler: handler,
            minHeight: 27,
            minWidth: 80,
            disabled: disabled,
            controller: controlador,
            titulo: titulotab
        });
        try {
            menu.add(boton);
        }
        catch (e) {
            return boton;
        }
    },
    //CrearBtn : function(id, nombre, icono, handler, menu, scope){

    //},
    CrearGrupoBoton: function (column, titulo) {
        var grupo = new Ext.container.ButtonGroup({
            columns: column,
            title: titulo,
            bodyPadding: 5,
        });
        return grupo;
    },
    //Ajax Request Con Confirmacion para los Windows
    AjaxRequestWin: function (controlador, accion, mask, form, grid, msg, param, win) {

        var formSend = form.getForm();
        //var time = (timeout == null) ? 
        var mensaje = (msg == null) ? 'Esta Seguro de Guardar Los cambios?' : msg;
        if (formSend.isValid()) {

            Ext.MessageBox.confirm('Confirmacion?', mensaje, function (btn) {
                if (btn == 'yes') {
                    mask.el.mask('Procesando...', 'x-mask-loading');
                    formSend.submit({
                        submitEmptyText: false,
                        url: Constantes.HOST + '' + controlador + '/' + accion + '',
                        params: param,
                        headers: fn.token,
                        timeout: 1200,
                        success: function (form, action) {
                            mask.el.unmask();
                            Ext.MessageBox.alert('Exito', action.result.msg);
                            //me.Formulario.Bloquear();
                            if (grid != null) {
                                try {
                                    grid.getStore().load();
                                }
                                catch (err) {
                                    grid.load();
                                }
                            }
                            if (win != null) {
                                try {
                                    win.destruirWin ? win.close() : win.hide();
                                }
                                catch (err) {
                                    win.hide();
                                }

                            }
                        },
                        failure: function (form, action) {
                            mask.el.unmask();
                            Ext.MessageBox.alert('Error', action.result.msg);
                        }
                    });

                }
            });

        }
        else {
            Ext.MessageBox.alert('Error', "Falta Parametros. Revisar Formulario.");
        }
    },

    //ajax para cerrar varias ventanas en un solo evento
    AjaxRequestWinArray: function (controlador, accion, mask, form, grid, msg, param, winArray) {

        var formSend = form.getForm();
        var mensaje = (msg == null) ? 'Esta Seguro de Guardar Los cambios?' : msg;
        if (formSend.isValid()) {

            Ext.MessageBox.confirm('Confirmacion?', mensaje, function (btn) {
                if (btn == 'yes') {
                    mask.el.mask('Procesando...', 'x-mask-loading');
                    formSend.submit({
                        submitEmptyText: false,
                        url: Constantes.HOST + '' + controlador + '/' + accion + '',
                        params: param,
                        headers: fn.token,
                        success: function (form, action) {
                            mask.el.unmask();
                            Ext.MessageBox.alert('Exito', action.result.msg);
                            //me.Formulario.Bloquear();
                            if (grid != null) {
                                try {
                                    grid.getStore().load();
                                }
                                catch (err) {
                                    grid.load();
                                }
                            }

                            if (winArray != null) {
                                for (i = 0; i < winArray.length; i++) {
                                    winArray[i].hide();
                                }
                                //grid.getStore().load();
                            }

                        },
                        failure: function (form, action) {
                            mask.el.unmask();
                            Ext.MessageBox.alert('Error', action.result.msg);
                        }
                    });

                }
            });

        }
        else {
            Ext.MessageBox.alert('Error', "Falta Parametros. Revisar Formulario.");
        }
    },
    //Ajax Request Con Confirmacion para los FormPanel
    AjaxRequestForm: function (controlador, accion, mask, form, grid, msg, param, Formulario) {

        var formSend = form.getForm();
        var mensaje = (msg == null) ? 'Esta Seguro de Guardar Los cambios?' : msg;
        if (formSend.isValid()) {
            Ext.MessageBox.confirm('Confirmacion?', mensaje, function (btn) {
                if (btn == 'yes') {
                    mask.el.mask('Procesando...', 'x-mask-loading');
                    formSend.submit({
                        submitEmptyText: false,
                        url: Constantes.HOST + '' + controlador + '/' + accion + '',
                        params: param,
                        headers: fn.token,
                        success: function (form, action) {
                            mask.el.unmask();
                            Ext.MessageBox.alert('Exito', action.result.msg);
                            //me.Formulario.Bloquear();
                            if (grid != null) {
                                grid.getStore().load();
                            }
                            if (Formulario != null) {
                                Formulario.BloquearFormulario();
                            }
                        },
                        failure: function (form, action) {
                            mask.el.unmask();
                            Ext.MessageBox.alert('Error', action.result.msg);
                        }
                    });

                }
            });

        }
        else {
            Ext.MessageBox.alert('Error', "Falta Parametros. Revisar Formulario.");
        }
    },
    //Ajax Request Sin Confirmacion para los FormPanel
    AjaxRequestFormSC: function (controlador, accion, mask, form, grid, param, Formulario) {

        var formSend = form.getForm();
        if (formSend.isValid()) {
            mask.el.mask('Procesando...', 'x-mask-loading');
            formSend.submit({
                submitEmptyText: false,
                url: Constantes.HOST + '' + controlador + '/' + accion + '',
                params: param,
                headers: fn.token,
                success: function (form, action) {
                    mask.el.unmask();
                    Ext.MessageBox.alert('Exito', action.result.msg);
                    if (grid != null) {
                        grid.getStore().load();
                    }
                    if (Formulario != null) {
                        Formulario.BloquearFormulario();
                    }
                },
                failure: function (form, action) {
                    mask.el.unmask();
                    Ext.MessageBox.alert('Error', action.result.msg);
                }
            });

        }
        else {
            Ext.MessageBox.alert('Error', "Falta Parametros. Revisar Formulario.");
        }
    },
    //para concatenar valores del modelo es necesario enviar un value (defaultValue) separadas por la (,) coma
    //ejm (" - ,NOMBRE,APELLIDO,EDAD") la primera posiicon es el separador y las siguines el orden de como se mostrara en el modelo
    // Ubaldo - Villazon - 30
    //si el nombre no existe en el record mostrara la palabra undifiend
    ConcatenarModelo: function (v, record) {
        var cadena = v.split(",");
        var result = "";
        var separador = "";
        for (x in cadena) {
            if (x == 0) {
                separador = cadena[x];
            }
            else if (x == 1) {
                result = record.get(cadena[x]);
            }
            else {
                result = result + "" + separador + "" + record.get(cadena[x]);
            }
        }
        return result;
    },
    MaterialesCSS: function (v, record) {
        if (record.get('IDSTATUS') == 0) {
            return "MatInactivosCSS";
        }
        else {
            return "";
        }
    },
    CopiarRecordmodelo: function (v, record) {
        return record.get(v);
    },
    AjaxRequestComponente: function (controlador, accion, mask, cmp, param, win, cmpArray) {
        mask.el.mask('Procesando...', 'x-mask-loading');
        Ext.Ajax.request({
            url: Constantes.HOST + '' + controlador + '/' + accion + '',
            params: param,
            success: function (response) {
                mask.el.unmask();
                var str = Ext.JSON.decode(response.responseText);
                //res = Ext.util.JSON.decode(result.responseText);
                if (str.success == true) {
                    //cmp.setValue(str);
                    try {
                        cmp.loadRecord(str.Result);
                        if (cmpArray != null) {
                            Funciones.loadResultCmpArray(cmpArray, str.Result);
                        }
                    }
                    catch (e) {
                        Funciones.loadRecordCmp(cmp, str.Result);
                        if (cmpArray != null) {
                            Funciones.loadResultCmpArray(cmpArray, str.Result);
                        }
                    }
                    //return true;
                }
                else {
                    if (cmpArray != null) {
                        Funciones.resetCmpArray(cmpArray);
                    }
                    if (win != null) {
                        win.show();
                    }
                    //Ext.MessageBox.alert('Error', "Ocurrio un Error al Procesar la Solicitud.");
                    //return false;
                }


            },
        });
    },
    //Se Recuperar Informacion para Cargar el Resultado a algunos Componentes enviados por el cmpArray
    AjaxRequestComponenteArray: function (controlador, accion, mask, cmpArray, param, win) {
        mask.el.mask('Procesando...', 'x-mask-loading');
        Ext.Ajax.request({
            url: Constantes.HOST + '' + controlador + '/' + accion + '',
            params: param,
            success: function (response) {
                mask.el.unmask();
                var str = Ext.JSON.decode(response.responseText);
                if (str.success == true) {
                    Funciones.loadResultCmpArray(cmpArray, str.Result);
                }
                else {
                    Funciones.resetCmpArray(cmpArray);
                    if (win != null) {
                        win.show();
                    }
                }


            },
        });
    },
    AjaxRequestGrid: function (controlador, accion, mask, msg, param, grid, win, destruirwin) {
        var mensaje = (msg == null) ? 'Esta Seguro de Guardar Los cambios?' : msg;
        Ext.MessageBox.confirm('Confirmacion?', mensaje, function (btn) {
            if (btn == 'yes') {
                mask.el.mask('Procesando...', 'x-mask-loading');
                Ext.Ajax.request({
                    url: Constantes.HOST + '' + controlador + '/' + accion + '',
                    params: param,
                    headers: fn.token,
                    success: function (response) {
                        mask.el.unmask();
                        var str = Ext.JSON.decode(response.responseText);
                        if (str.success == true) {
                            if (grid != null && win != null) {
                                grid.getStore().load();
                                destruirwin == null ? win.hide() : win.close();
                            }
                            else if (grid != null && win == null) {
                                grid.getStore().load();
                            }
                            else if (grid == null && win != null) {
                                //win.hide();
                                destruirwin == null || !win.destruirwin ? win.hide() : win.close();
                            }
                            Ext.MessageBox.alert('Exito', str.msg);
                        }
                        else {
                            Ext.MessageBox.alert('Error', str.msg);
                        }
                    },
                });
            }
        });
    },
    AjaxRequestGridWinArray: function (controlador, accion, mask, msg, param, grid, winArray, destruirwin) {
        var mensaje = (msg == null) ? 'Esta Seguro de Guardar Los cambios?' : msg;
        Ext.MessageBox.confirm('Confirmacion?', mensaje, function (btn) {
            if (btn == 'yes') {
                mask.el.mask('Procesando...', 'x-mask-loading');
                Ext.Ajax.request({
                    url: Constantes.HOST + '' + controlador + '/' + accion + '',
                    params: param,
                    success: function (response) {
                        mask.el.unmask();
                        var str = Ext.JSON.decode(response.responseText);
                        if (str.success == true) {
                            if (grid != null && winArray != null) {
                                grid.getStore().load();
                                for (i = 0; i < winArray.length; i++) {
                                    destruirwin == null ? winArray[i].hide() : winArray[i].close();
                                }
                            }
                            else if (grid != null && win == null) {
                                grid.getStore().load();
                            }
                            else if (grid == null && winArray != null) {
                                for (i = 0; i < winArray.length; i++) {
                                    destruirwin == null ? winArray[i].hide() : winArray[i].close();
                                }
                                //destruirwin == null ? win.hide() : win.close();
                            }
                            Ext.MessageBox.alert('Exito', str.msg);
                        }
                        else {
                            Ext.MessageBox.alert('Error', str.msg);
                        }
                    },
                });
            }
        });
    },
    //No muestra mensaje de confirmacion de accion pero si muestra resultado de accion
    AjaxRequestGridSC: function (controlador, accion, mask, param, grid, win, showExito) {

        mask.el.mask('Procesando...', 'x-mask-loading');
        Ext.Ajax.request({
            url: Constantes.HOST + '' + controlador + '/' + accion + '',
            params: param,
            success: function (response) {
                mask.el.unmask();
                var str = Ext.JSON.decode(response.responseText);
                if (str.success == true) {
                    if (grid != null && win != null) {
                        grid.getStore().load();
                        win.hide();
                    }
                    else if (grid != null && win == null) {
                        grid.getStore().load();
                    }
                    else if (grid == null && win != null) {
                        win.hide();
                    }
                    if (showExito == null) {
                        Ext.MessageBox.alert('Exito', str.msg);
                    }
                }
                else {
                    Ext.MessageBox.alert('Error', str.msg);
                }
            },
        });

    },
    //No muestra mensaje de confirmacion de accion y tampoco muestra resultado de accion
    AjaxRequestGridSCC: function (controlador, accion, mask, param, grid, win, showExito) {

        mask.el.mask('Procesando...', 'x-mask-loading');
        Ext.Ajax.request({
            url: Constantes.HOST + '' + controlador + '/' + accion + '',
            params: param,
            success: function (response) {
                mask.el.unmask();
                var str = Ext.JSON.decode(response.responseText);
                if (str.success == true) {
                    if (grid != null && win != null) {
                        grid.getStore().load();
                        win.hide();
                    }
                    else if (grid != null && win == null) {
                        grid.getStore().load();
                    }
                    else if (grid == null && win != null) {
                        win.hide();
                    }
                    if (showExito == null) {
                        // Ext.MessageBox.alert('Exito', str.msg);
                    }
                }
                else {
                    Ext.MessageBox.alert('Error', str.msg);
                }
            },
        });

    },
    AjaxRequestGridArray: function (controlador, accion, mask, msg, param, ArrayGrid) {
        var mensaje = (msg == null) ? 'Esta Seguro de Guardar Los cambios?' : msg;
        Ext.MessageBox.confirm('Confirmacion?', mensaje, function (btn) {
            if (btn == 'yes') {
                mask.el.mask('Procesando...', 'x-mask-loading');
                Ext.Ajax.request({
                    url: Constantes.HOST + '' + controlador + '/' + accion + '',
                    params: param,
                    success: function (response) {
                        mask.el.unmask();
                        var str = Ext.JSON.decode(response.responseText);
                        if (str.success == true) {
                            if (ArrayGrid != null) {
                                for (i = 0; i < ArrayGrid.length; i++) {
                                    ArrayGrid[i].getStore().load();
                                }
                                //grid.getStore().load();
                            }
                            Ext.MessageBox.alert('Exito', str.msg);
                        }
                        else {
                            Ext.MessageBox.alert('Error', str.msg);
                        }
                    },
                });
            }
        });
    },
    convertirJson: function (grid) {
        var modified = grid.getStore().getModifiedRecords(); //step 1
        var recordsToSend = [];
        if (!Ext.isEmpty(modified)) {
            Ext.each(modified, function (record) { //step 2
                recordsToSend.push(Ext.apply(record.data));
            });
            recordsToSend = Ext.JSON.encode(recordsToSend);
            return recordsToSend;
        }
        else {
            return false;
        }

    },
    //obtener un componente de un formulario 
    cargarValorComponeteForm: function (form, cmp) {
        var els = form.query('.field');
        Ext.each(els, function (o) {
            if (o.getName() == cmp.getName()) {
                o.setValue(cmp.getValue());
                return true;
            }

        });
        return false;
    },
    //cargar formulario de un formulario a otro siempre y cuando los nane son iguales 
    //formulario al que se le va actualizar los componentes del form2
    cargarFormDesdeOtroForm: function (form1, form2) {
        var me = this;
        var els = form2.query('.field');
        Ext.each(els, function (o) {
            if (o.getValue() != null) {
                Funciones.cargarValorComponeteForm(form1, o);
            }

        });
    },
    cargarValidaciones: function () {
        Ext.apply(Ext.form.VTypes, {
            validacionNumero: function (value, field) {
                return /[0-9]/.test(value);
            },
            validacionNumeroText: 'Los datos ingresado no son válidos. Solo números',
            validacionNumeroMask: /[0-9]/i,

            validacionTexto: function (value, field) {
                return /[A-Za-z0-9 c]/.test(value);
            },
            validacionTextoText: 'Los datos ingresado no son válidos. Solo números',
            validacionTextoMask: /[A-Za-z0-9 !@#$%^&*()_+\-=?;:",.ñ]/i,

            validacionLetrasConEspacios: function (value, field) {
                return /[A-Za-z]/.test(value);
            },
            validacionLetrasConEspaciosText: 'Datos ingresados no válidos. Solo letras',
            validacionLetrasConEspaciosMask: /[A-Za-z]/,

            CodigoEquiposMask: /^[a-z0-9]*[@]?$/i,
            CodigoEquipos: function (val, field) {
                var texto = val;
                if (texto.length == 1) {
                    texto = texto + "-";
                }
                texto = Ext.util.Format.uppercase(texto);

                field.setRawValue(texto);
                return true;
            },
            //convierte a mayuscula
            //CodigoEquiposMask: /^[0-9]*[:]?$/i,
            //HoraMask: /^[0-9]*[:]?$/i,
            HoraMask: /[\d\s:]/i,
            HoraText: "No es una hora valida. Este es el formato 0:00 - 23:59 ",
            Hora: function (value, field) {
                var texto = value;
                if (texto.length == 2) {
                    texto = texto + ":";
                }

                field.setRawValue(texto);
                return /^(1|01|2|02|3|03|4|04|5|05|6|06|7|07|8|08|9|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|00|0):(([0-5][0-9]|[0-9])|([0-5][0-9]|[0-9]):[0-5][0-9])$/.test(value);
            },

            HoraSegMask: /[\d\s:]/i,
            HoraSegText: "No es una hora valida. Este es el formato 00:00:00 - 23:59:59 ",
            HoraSeg: function (value, field) {
                var texto = value;
                if (texto.length == 2 || texto.length == 5) {
                    texto = texto + ":";
                }

                field.setRawValue(texto);
                return /^(1|01|2|02|3|03|4|04|5|05|6|06|7|07|8|08|9|09|10|11|12|13|14|15|16|17|18|19|20|21|22|23|00|0):(([0-5][0-9]|[0-9])|([0-5][0-9]|[0-9]):[0-5][0-9])$/.test(value);
            },
            //            Hora: function (val, field) {
            //                var texto = val;
            //                if (texto.length == 2) {
            //                    texto =texto+":";
            //                }
            //                texto = Ext.util.Format.uppercase(texto);

            //                field.setRawValue(texto);
            //                return true;
            //            },


            uppercase: function (value, field) {
                texto = Ext.util.Format.uppercase(value);
                //                field.setValue(value.charAt(0).toUpperCase() + value.slice(1));
                field.setValue(texto);
                return true;
            },
            password: function (val, field) {
                if (field.initialPassField) {
                    var pwd = field.up('form').down('#' + field.initialPassField);
                    return (val == pwd.getValue());
                }
                return true;
            },

            passwordText: 'la contraseña no es la misma ...',

            validara: function (value, field) {
                return /(\W|^)[\w.!@#$%^&*()_+=?:",.ñáéíóúÁÉÍÓÚ\s]/.test(value);
            },
            validaraMask: /(\W|^)[\w.!@#$%^&*()_+=?:",.ñáéíóúÁÉÍÓÚ\s]/,
            validaraText: 'Datos ingresados no válidos. No ; ni -',
        });
    },
    AjaxRequestRecord: function (controlador, accion, mask, record, recordName, recordId, param, win) {
        mask.el.mask('Procesando...', 'x-mask-loading');
        Ext.Ajax.request({
            url: Constantes.HOST + '' + controlador + '/' + accion + '',
            params: param,
            success: function (response) {
                mask.el.unmask();
                var str = Ext.JSON.decode(response.responseText);
                if (str.success == true) {
                    Ext.each(str.Result, function (name) {
                        record.set(recordName, name[recordName]);
                        record.set(recordId, name[recordId]);
                    });
                }
                else {
                    if (win != null) {
                        win.show();
                    }
                }


            },
        });
    },
    AjaxRequestRecordArray: function (controlador, accion, mask, record, recordArray, param, win) {
        mask.el.mask('Procesando...', 'x-mask-loading');
        Ext.Ajax.request({
            url: Constantes.HOST + '' + controlador + '/' + accion + '',
            params: param,
            success: function (response) {
                mask.el.unmask();
                var str = Ext.JSON.decode(response.responseText);
                if (str.success == true) {
                    Ext.each(str.Result, function (name) {
                        for (i = 0; i < recordArray.length; i++) {
                            try {
                                record.set(recordArray[i], name[recordArray[i]]);
                                //return false;
                            }
                            catch (e) {
                                console.log(e);
                            }
                            //alert(recordArray[i]);
                            //alert(name);
                        }
                    });
                }
                else {
                    if (win != null) {
                        win.show();
                    }
                }


            },
        });
    },
    loadRecordCmp: function (cmp, result) {
        var els = cmp.query('.field');
        Ext.Object.each(result, function (key, value, myself) {
            Ext.each(els, function (o) {
                if (o.getName() == key) {
                    o.setValue(value);
                }

            });

        });
    },
    //Carga el Resultar de un Ajax Request a un un Componente Array
    loadResultCmpArray: function (cmpArray, result) {
        //primero limpiamos todos los com,ponenbtes;
        Funciones.resetCmpArray(cmpArray);
        //luego Actualizamos todos los componentes si tiene respusta
        Ext.Object.each(result, function (key, value, myself) {
            if (cmpArray != null) {
                for (i = 0; i < cmpArray.length; i++) {
                    if (cmpArray[i].getName() == key) {
                        cmpArray[i].setValue(value);
                    }
                }
            }
        });
    },
    //limpiar todos los campos de ese compomente Array
    resetCmpArray: function (cmpArray) {
        if (cmpArray != null) {
            for (i = 0; i < cmpArray.length; i++) {
                cmpArray[i].reset();
            }
        }
    },
    resetForm: function (form, array) {
        var els = form.query('.field');
        Ext.each(els, function (o) {
            if (!Funciones.EsComponenteNombre(o, array)) {
                o.reset();
            }

        });
    },
    contieneValorEnArray: function (valor, array) {
        for (x in array) {
            if (valor == array[x]) {
                return true;
            }

        }
        return false;
    },

    /*Para manejar caducidad de sesiones*/
    checkTimeout: function (data) {
        var me = this;
        var thereIsStillTime = true;
        if (data) {
            if (data.responseText) {
                if ((data.responseText.indexOf("&lt;title&gt;Log On&lt;/title&gt;") > -1) || (data.responseText.indexOf("&lt;title&gt;Object moved&lt;/title&gt;") > -1) || (data.responseText === '"_Logon_"')) thereIsStillTime = false;
            } else {
                if (data == '"_Logon_"') thereIsStillTime = false;
            }

            if (!thereIsStillTime) {
                alert("Su session ha expirado, en breve sera redireccionado a la pagina de inicio");
                document.location = Constantes.HOST + 'Account/LogOn';
            }
        } else {
            Ext.Ajax.request({
                url: Constantes.HOST + "Home/CheckTimeout/",
                type: 'ajax',
                method: 'POST',
                async: false,
                success: function (result) {
                    thereIsStillTime = me.checkTimeout(result);
                }
            });
        }

        return thereIsStillTime;
    },
    //Desabilitar un boton 
    DisabledButton: function (id, component, disabled) {
        try {
            component.down('#' + id).setDisabled(disabled);
        }
        catch (e) {

        }
    },
    //verificar si un valor es nulo
    isEmpty: function (val) {
        return (val === undefined || val == null || val.length <= 0) ? true : false;
    },
    CargarHistoricoEstadoPorVentana: function (tabla, id) {
        var grid = Ext.create("App.View.Historicos.GridHistoricosEstado");
        grid.MostrarVentanaHistorico(tabla, id);
    },
    CargarHistoricoEdicionPorVentana: function (tabla, id) {
        var grid = Ext.create("App.View.Historicos.GridHistoricos");
        grid.MostrarVentanaHistorico(tabla, id);
    },
    HiddenButton: function (id, component, hidden) {
        try {
            if (hidden) {
                component.down('#' + id).hide();
            }
            else {
                component.down('#' + id).show();
            }

        }
        catch (e) {

        }
    },
    ImprimirReport: function (nameReport, params) {
        if (Funciones.winReporte == null) {
            Funciones.winReporte = Ext.create("App.Config.Abstract.Window");
            fn.store_view = Ext.create('Ext.data.Store', {
                fields: ['src', 'caption', 'tipo'],
                data: [
                    {src: Constantes.HOST + '/Content/images/PDF.png', caption: 'PDF', tipo: 'pdf'},
                    {src: Constantes.HOST + '/Content/images/EXCEL.png', caption: 'Excel', tipo: 'excel'},
                    //{ src: 'http://www.sencha.com/img/20110215-feat-html5.png', caption: 'Overhauled Theme' },

                ]

            });

            Funciones.viewReport = Ext.create('Ext.view.View', {
                store: fn.store_view,
                /* width : 100,
                 height: 100,*/
                tpl: [
                    '<tpl for=".">',
                    '<div class="thumb-wrap">',
                    '<img src="{src}" height="50" width="50" alt={caption}/>',
                    '<br/><span>{caption}</span>',
                    '</div>',
                    '</tpl>'
                ],
                itemSelector: 'div.thumb-wrap',
                emptyText: 'No images available',
                //renderTo: Ext.getBody()
            });
            fn.viewReport.on('itemclick', fn.EnviarImprimirReport, fn);//(this, record, item, index, e, eOpts)
            fn.winReporte.add(fn.viewReport);
            //Funciones.winReporte.btn_guardar.on('click',fn.EnviarImprimirReport,fn)

        }
        fn.nameReport = nameReport;
        fn.paramsReport = params;
        fn.winReporte.show();
        //Funciones.winReporte.show();
        //    Funciones.winReporte.btn_guardar.on('click', function () {
        //        alert(nameReport + "?" + params)
        //        window.open(Constantes.HOST + '' + nameReport + '?' + params);
        //    });


    },
    EnviarImprimirReport: function (view, record, item) {
        window.open(Constantes.HOST + 'ReportesPDF/' + fn.nameReport + '?' + fn.paramsReport + '&tipo=' + record.get('tipo'));
    },
    ObtenerJerarquia: function (COD_OBJETO, ID_OBJETO) {
        var me = this;
        return 'POSTE/PUESTO/DERIVACION/ALIMENTADOR/SUBESTACION/URBANO /DIRECCION SIN DEFINIR';
    },
    //ObtenerJerarquiaJson : function
    renderHref: function (val, meta, record) {
        //alert(val);
        if (!fn.isEmpty(val)) {
            return '<a id="' + val + '"class="href_css" href="#" onClick="Rep.VerReporteObjeto(this.id)">' + val + '</a>';

        }
        else {
            return "";
        }
        //<a class="test" id="test" href="#" onClick="Ext.get('componentid').openwindow();"></a>
    },
    renderHrefSM: function (val, meta) {
        if (!fn.isEmpty(val)) {
            return '<a id="' + val + '"class="href_cssSM" href="#" onClick="Rep.VerSMPorId(this.id)">' + val + '</a>';

        }
        else {
            return "";
        }
    },
    isValidDate: function (day, month, year) {
        var dteDate;

        // En javascript, el mes empieza en la posicion 0 y termina en la 11 
        //   siendo 0 el mes de enero
        // Por esta razon, tenemos que restar 1 al mes
        month = month - 1;
        // Establecemos un objeto Data con los valore recibidos
        // Los parametros son: año, mes, dia, hora, minuto y segundos
        // getDate(); devuelve el dia como un entero entre 1 y 31
        // getDay(); devuelve un num del 0 al 6 indicando siel dia es lunes,
        //   martes, miercoles ...
        // getHours(); Devuelve la hora
        // getMinutes(); Devuelve los minutos
        // getMonth(); devuelve el mes como un numero de 0 a 11
        // getTime(); Devuelve el tiempo transcurrido en milisegundos desde el 1
        //   de enero de 1970 hasta el momento definido en el objeto date
        // setTime(); Establece una fecha pasandole en milisegundos el valor de esta.
        // getYear(); devuelve el año
        // getFullYear(); devuelve el año
        dteDate = new Date(year, month, day);

        //Devuelva true o false...
        return ((day == dteDate.getDate()) && (month == dteDate.getMonth()) && (year == dteDate.getFullYear()));
    },
    //Verifica que fecha tenga el formato YYYY-MM-DD
    FormatoInglesFecha: function (fecha) {

        var patron = new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");

        if (fecha.search(patron) == 0) {
            var values = fecha.split("-");
            if (fn.isValidDate(values[2], values[1], values[0])) {
                return true;
            }
        }
        return false;
    },
    //funcion que mapea un objeto en un modelo 
    MapeoObjetoAModelo: function (objeto, model) {
        var rec = Ext.create(model);
        Ext.Object.each(objeto, function (key, value, myself) {
            //console.log(key + "  " + value);
            rec.set(key, value);

        });
        return rec;
    }
});
//Rep.VerReporteObjeto("POSTE-L24A41");

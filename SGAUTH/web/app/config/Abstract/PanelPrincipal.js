Ext.define("App.Config.Abstract.PanelPrincipal", {
    extend: "Ext.panel.Panel",
    alias: "widget.PanelPrincipal",
    width: '100%',
    height: Constantes.ALTO,
    frame: true,
    layout: 'border',
    fixed: true,
    defaults: {
        split: true
    },
    controlador: '',
    accionCrear: '',
    accionBaja: '',
    accionCambioEstado: '',
    idTabla: '',
    tabla: '',
    CargarDatos: function (grid, td, cellIndex, record, tr, owIndex, e, eOpts) {
        var me = this;
            me.formulario.CargarDatos(record);
    },
    CargarPanelImagen : function( verReporte){
        var me = this;
      
        me.ViewImagen = Ext.create("App.View.Imagenes.ViewImagenes");
        if (verReporte == null) {
            me.ViewImagen.on('selectionchange', me.onIconSelect, this);
        }
        else { alert("Otro Evento");}
        me.panelImagen = Ext.create('Ext.panel.Panel', {
            bodyPadding: 5,
            height: 400,
            title: 'Visor de Imagenes',
            items: [me.ViewImagen]
        });
    },
    CargarImagen: function (btn) {
        var me = this;
        if (me.formulario.record != null) {
            me.formImagen = Ext.create("App.View.Imagenes.FormImagen", { opcion: 'FormImagen' });
            me.formImagen.MostrarWindowImagen(me.tabla, me.formulario.record.get(me.idTabla), me.ViewImagen.store);
        }
        else {
            Ext.MessageBox.alert('Error', "Seleccione un Registro");
        }
    },
    onIconSelect: function (dataview, selections) {
        var me = this;
        var selected = selections[0];

        if (selected) {
            var id = selected.get('ID_IMG');
            var slider = Ext.create('Ext.slider.Single', {
                value: 0,
                increment: 5,
                minValue: 0,
                maxValue: 100,
                fieldLabel: "Aumentar",
            });
            //var size = new Ext.slider.SingleSlider({ //step 1
            //    fieldLabel: "Size",
            //    width: 100, // el tama�o que tendr� el slider
            //    minValue: 20, // el valor m�nimo que se obtendr� del slider
            //    maxValue: 120, //el valor m�ximo que obtendr� el slider
            //    value: 50, //valor inicial que tendr� el slider 
            //    //plugins: tip
            //});

            
            var win = Ext.create("App.Config.Abstract.Window", {
                height: 550,
                width: 800,
            });
            var panel = Ext.create('Ext.panel.Panel', {
                title: selected.get('DESCRIPCION'),
                autoScroll : true,
                
            });
            var wrappedImage = Ext.create('Ext.Img', {
                height: 550,
                width: 800,
                src: Constantes.getUrlImagen() + 'id=' + id + '&tamano=500',
                
            });
           
            panel.addDocked(slider);
            panel.add(wrappedImage);
            win.add(panel);
            win.show();
            slider.on('changecomplete', function (sl, newValue, thumb, eOpts) {
                //alert(newValue);
                var h = 800 + (newValue * 10);
                wrappedImage.setSize(h,h);
                //wrappedImage.setWidth(newValue + "%")
                //wrappedImage.center(frame);
                //wrappedImage.src = Constantes.getUrlImagen(true) + 'id=' + id + '&tamano=' + h;
                wrappedImage.setSrc(Constantes.getUrlImagen(true) + 'id=' + id + '&tamano=' + h);
                //alert(wrappedImage.getSize().width);
                //wrappedImage.setSrc('http://www.sencha.com/img/20110215-feat-perf.png');
                //wrappedImage.doAutoRender();
                //win.doLayout();
            });
            //me.panelInfo.loadRecord(selected);
            //this.down('infopanel').loadRecord(selected);
        }
    }  
});

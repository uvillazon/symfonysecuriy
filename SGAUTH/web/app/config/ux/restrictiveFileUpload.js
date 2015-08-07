/***********************************************
Adds extension validation at the client side
for the extjs File Upload field. You must
set the extension in an array of strings.
 **********************************************/
Ext.define('App.Config.ux.restrictiveFileUpload', {
    extend: 'Ext.form.field.File',
    alias: 'widget.restfileupload',
    // Array of acceptable file extensions
    // overridden when decalred with a string
    // of extensions minus the period.
    accept: [],
    listeners: {
        validitychange: function (me) {
            // This gets the part of the file name after the last period
            var indexofPeriod = me.getValue().lastIndexOf("."),
                uploadedExtension = me.getValue().substr(indexofPeriod + 1, me.getValue().length - indexofPeriod);

            // See if the extension is in the
            //array of acceptable file extensions
            if (!Ext.Array.contains(this.accept, uploadedExtension)) {
                // Add the tooltip below to
                // the red exclamation point on the form field
                me.setActiveError('Por favor, solo seleccione archivos del tipo:  <b>' + this.accept.join() + '</b>');
                // Let the user know why the field is red and blank!
                Ext.MessageBox.show({
                    title: 'Error de tipo de archivo',
                    msg: 'Por favor, solo seleccione archivos del tipo:  <b>' + this.accept.join() + '</b>',
                    buttons: Ext.Msg.OK,
                    icon: Ext.Msg.ERROR
                });
                // Set the raw value to null so that the extjs form submit
                // isValid() method will stop submission.
                me.setRawValue(null);
            }
        },
    }
});

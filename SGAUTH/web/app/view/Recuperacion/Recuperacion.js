/**
 * Created by uvillazon on 17/03/2016.
 */
/* File Created: August 4, 2013 */
Ext.onReady(function () {
    Ext.QuickTips.init();
    Constantes.CargarHostSinSeguridad();

    //console.dir(Ext.get("cogioApp").dom.value);
    var codigoApp = Ext.get("cogioApp").dom.value;
    //alert(codigoApp);


    Ext.apply(Ext.form.VTypes, {
        password: function (val, field) {
            if (field.initialPassField) {
                var pwd = field.up('form').down('#' + field.initialPassField);
                return (val == pwd.getValue());
            }
            return true;
        },
        passwordText: 'la contraseña no es la misma ...'
    });
    var htmlTitulo = Ext.create('Ext.Component', {
        html: '<div class="ntl-msg ntl-info ntl-mc"><strong class="ntl-title">Pasos a seguir</strong>' +
        '        <ol>' +
        '        <li>Introduce su nombre usuario <b>"Usuario"</b> </li>' +
        '        <li>Si no tienes tu Codigo de Control, haz click en <b>“Obtener tu Codigo”</b> y' +
        '    se enviara un codigo a su correo electronico asociado al usuario ingresado. El periodo de validez del codigo es de 10 min</li>' +
        '    <li>Si ya tienes tu Codigo De Control, introduce el mismo en el espacio denominado' +
        '    <b>“Codigo”</b></li>' +
        '    <li>introduce tu contraseña y confirma la contraseña' +
        '    <b>y haz click en <b>“Actualizar Contraseña”</b></li>' +
        '    </ol>    </div>',
        width: 480,
        height: 250,
        //padding: 20,
        colspan: 2,
        rowspan: 5

    });
    var txt_usuario = Ext.create('Ext.form.TextField', {
        maxLength: 255,
        emptyText: 'Introduzca Nombre de usuario...',
        width: 300,
        labelWidth: 70,
        fieldLabel: "Usuario",
        name: "usuario",
        allowBlank: false,
        afterLabelTextTpl: Constantes.REQUERIDO
    });
    var txt_codigo = Ext.create('Ext.form.TextField', {
        emptyText: 'Introduzca Codigo de control...',
        width: 300,
        labelWidth: 70,
        fieldLabel: "Codigo",
        name: "codigo",
        allowBlank: false,
        afterLabelTextTpl: Constantes.REQUERIDO
    });
    var txt_contrasena = Ext.create('Ext.form.TextField', {
        emptyText: 'Introduzca Su Nueva Contraseña...',
        width: 300,
        labelWidth: 70,
        fieldLabel: 'Nueva Contraseña',
        name: 'contrasena',
        itemId: 'contrasena',
        inputType: 'password',
        afterLabelTextTpl: Constantes.REQUERIDO,
        allowBlank: false,
        strength: 24,
        plugins: ["passwordstrength"]
    });
    var txt_nva_contrasena = Ext.create('Ext.form.TextField', {
        emptyText: 'Confirmar Contraseña...',
        width: 300,
        labelWidth: 70,
        fieldLabel: 'Confirmar',
        name: 'pass-cfrm',
        inputType: 'password',
        afterLabelTextTpl: Constantes.REQUERIDO,
        allowBlank: false,
        strength: 24,
        vtype: 'password',
        plugins: ["passwordstrength"],
        initialPassField: 'contrasena'
    });
    var btn_obtenerCodigo = Ext.create('Ext.Button', {
        text: 'Obtener Codigo de Control',
        width: 300,
    });

    var btn_actualizar = Ext.create('Ext.Button', {
        text: 'Actualizar Contraseña',
        width: 300,
    });
    btn_obtenerCodigo.on('click', function () {
        if (txt_usuario.isValid()) {
            AjaxRequestGrid("login","recuperacions",login,"Es seguro de Solicitar el Codigo de Control",{usuario : txt_usuario.getValue() , codigoApp : codigoApp});
        }
        else {
            alert('Debe ingresar un usuario');
        }
    });

    btn_actualizar.on('click',function(){
        //alert('Completar Formulario.');
        if(login.getForm().isValid()){
            AjaxRequestGrid("login","cambiar_passwords",login,"Es seguro de cambiar su contraseña",{codigo : txt_codigo.getValue() , password : txt_contrasena.getValue()});
        }
        else{
            alert('Completar Formulario.');
        }
    });
    // Create a variable to hold our EXT Form Panel.
    // Assign various config options as seen.
    var login = new Ext.FormPanel({
        labelWidth: 80,
        frame: true,
        bodyPadding: 5,
        layout: {
            type: 'table',
            columns: 3
        },

        defaultType: 'textfield',
        monitorValid: true,
        // Specific attributes for the text fields for username / password.
        // The "name" attribute defines the name of variables sent to the server.
        items: [
            txt_usuario, htmlTitulo,
            btn_obtenerCodigo,
            txt_codigo,
            txt_contrasena,
            txt_nva_contrasena


        ]
    });


    //login.omn

    // This just creates a window to wrap the login form.
    // The login object is passed to the items collection.
    var win = new Ext.Window({
        title: 'Restaurar Contraseña',
        layout: 'fit',

        items: [login],
        buttons: [btn_actualizar]
    });
    win.show();


    function AjaxRequestGrid(controlador, accion, mask, msg, param) {
        var mensaje = (msg == null) ? 'Esta Seguro de Guardar Los cambios?' : msg;
        Ext.MessageBox.confirm('Confirmacion?', mensaje, function (btn) {
            if (btn == 'yes') {
                mask.el.mask('Procesando...', 'x-mask-loading');
                Ext.Ajax.request({
                    url: Constantes.HOST_TOKEN + '' + controlador + '/' + accion + '',
                    params: param,
                    success: function (response) {
                        mask.el.unmask();
                        var str = Ext.JSON.decode(response.responseText);
                        if (str.success == true) {
                            Ext.MessageBox.alert('Exito', str.msg);
                        }
                        else {
                            Ext.MessageBox.alert('Error', str.msg);
                        }
                    },
                });
            }
        });
    };
});
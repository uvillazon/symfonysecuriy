/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Listas.Item', {
    extend: 'Ext.data.Model',
    fields: [
        { name: 'valor', type: 'string' },
        { name: 'codigo', type: 'string' },
        { name: 'id_lista', type: 'int' },
        { name: 'id_item', type: 'int' }

    ]
});


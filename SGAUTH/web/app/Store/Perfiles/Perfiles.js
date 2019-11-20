/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Perfiles.Perfiles', {
    model: 'App.Model.Perfiles.Perfiles',
    url: 'perfiles/perfiles',
    sortProperty: 'nombre',
    sortDirection: 'ASC',
    extend: 'App.Config.Abstract.Store'
});
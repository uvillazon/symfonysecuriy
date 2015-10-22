/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.Store.Historicos.HistoricosEdicion', {

    model: 'App.Model.Historicos.HistoricosEdicion',
    url: 'historicos/ediciones',
    sortProperty: 'id_hist',
    extend: 'App.Config.Abstract.Store'
});
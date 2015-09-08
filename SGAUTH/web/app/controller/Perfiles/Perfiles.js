/**
 * Created by uvillazon on 30/07/2015.
 */
Ext.define('App.controller.Perfiles.Perfiles', {
    extend: 'App.Config.Abstract.Controller',
    classPrincipal: 'App.View.Perfiles.Principal',
    //init: function () {
    //    var me = this;
    //    this.callParent();
    //    console.log(toolbar.prop);
    //    var q = Ext.ComponentQuery.query('#grid123');
    //    console.dir(q);
    //    this.control({
    //        'tab panel grid[itemId=grid123]': {
    //            itemclick: 'updateUser'
    //        }
    //    });
    //
    //},
    onPanelRendered: function () {
        console.log('The panel was rendered');
    },
    afterrenderToolbar: function () {
        console.log("asdasd");
    },
    updateUser: function () {
        console.log("asdad");
    }
//init: function() {
//    this.buildItems();
//    console.log('Initialized Users! This happens before ' +
//        'the Application launch() function is called');
//}
})
;
/**
 * @class Ext.ux.Exporter
 * @author Ed Spencer (http://edspencer.net), with modifications from iwiznia.
 * Class providing a common way of downloading data in .xls or .csv format
 */
Ext.define("App.Config.ux.Exporter", {
    uses: [
        "App.Config.ux.Base64",
        "App.Config.ux.csvFormatter.CsvFormatter",
        "App.Config.ux.excelFormatter.ExcelFormatter"
    ],

    statics: {
        exportAny: function(component, formatter, title) {
            var func = "export";
            if(!component.is) {
                func = func + "Store";
            } else if(component.is("gridpanel")) {
                func = func + "Grid";
            } else if (component.is("treepanel")) {
                func = func + "Tree";
            } else {
                func = func + "Store";
                component = component.getStore();
            }

            return this[func](component, formatter, title);
        },
        exportGridVAnt: function (grid, formatter, title) {
            //console.dir(grid);
            formatter = this.getFormatterByName(formatter);
            var columns = Ext.Array.filter(grid.columns, function (col) {
                //var col = col;
                //alert(col.xtype);
                return !col.hidden && (!col.xtype || col.xtype != "actioncolumn");
            });
            var config = {
                title: grid.title ? grid.title : title,
                columns: columns
            };
            console.dir(grid.store);
            return formatter.format(grid.store, config);
        },
        //exportGridStoreLoad: function (store,grid, formatter, title) {
        
        //},
        exportGrid: function (store,grid, formatter, title) {
          formatter = this.getFormatterByName(formatter);
          var columns = Ext.Array.filter(grid.columns, function (col) {
              //var col = col;
              //alert(col.xtype);
              return !col.hidden && (!col.xtype || col.xtype != "actioncolumn");
          });
          var config = {
              title: grid.title ? grid.title : title,
              columns: columns
          };
          //var store2 = new Ext.data.Store({
          //    proxy: grid.store.proxy,
          //    reader: grid.store.reader,
          //    sortInfo: grid.store.sortInfo,
          //    model: grid.store.model
          //});
          //limit = grid.store.getTotalCount();
          //store2.load({ limit: limit, start: 0, page: 1 });
          //alert("entro");
          return formatter.format(store, config);
          //return formatter.format(grid.store, config);
        },

        exportStore: function(store, formatter, title) {
           formatter = this.getFormatterByName(formatter);
           var config = {
               title: title,
               columns: store.fields ? store.fields.items : store.model.prototype.fields.items
           }
           return formatter.format(store, config);
        },

        exportTree: function(tree, formatter, title) {
          formatter = this.getFormatterByName(formatter);
          var store = tree.store;
          var config = {
              title: tree.title ? tree.title : title
          }
          return formatter.format(store, config);
        },

        getFormatterByName: function(formatter) {
            formatter = formatter ? formatter : "excel";
            formatter = !Ext.isString(formatter) ? formatter : Ext.create("App.Config.ux." + formatter + "Formatter." + Ext.String.capitalize(formatter) + "Formatter");
            return formatter;
        }
    }
});
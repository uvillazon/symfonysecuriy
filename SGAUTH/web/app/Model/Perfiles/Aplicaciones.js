/**
 * Created by uvillazon on 04/09/2015.
 */
Ext.define('App.Model.Perfiles.Aplicaciones', {
    extend: 'Ext.data.Model',
    fields: [
        {type: "int", name: "id_aplic"},
        {type: "int", name: "id_perfil"},
        {type: "int", name: "id_prf_app"},
        {type: "string", name: "codigo", mapping: "aplicaciones.codigo"},
        {type: "string", name: "perfil", mapping: "perfiles.nombre"},
        {type: "string", name: "nombre", mapping: "aplicaciones.nombre"},
        {type: "string", name: "descripcion", mapping: "aplicaciones.descripcion"},
        {type: "string", name: "estado", mapping: "aplicaciones.estado"},
        {type: "date", name: "fch_alta", mapping: "aplicaciones.fch_alta"},
        {type: "string", name: "bd_princ", mapping: "aplicaciones.bd_princ"},
        {type: "string", name: "bd_port", mapping: "aplicaciones.bd_port"},
        {type: "string", name: "bd_host", mapping: "aplicaciones.bd_host"},
        {type: "string", name: "bd_drive", mapping: "aplicaciones.bd_drive"},
        {type: "string", name: "app_host", mapping: "aplicaciones.app_host"},
        {type: "string", name: "secret_key", mapping: "aplicaciones.secret_key"},
        {type: "float", name: "tiempo_valido_token", mapping: "aplicaciones.tiempo_valido_token"}
    ]
});
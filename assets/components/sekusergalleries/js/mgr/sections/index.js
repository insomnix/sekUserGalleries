// JavaScript Document
Ext.onReady(function() {
    MODx.load({ xtype: 'sekug-page-home'});
});
 
sekUserGalleries.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'sekug-panel-home'
            ,renderTo: 'sekug-panel-home-div'
        }]
    });
    sekUserGalleries.page.Home.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.page.Home,MODx.Component);
Ext.reg('sekug-page-home',sekUserGalleries.page.Home);
var sekUserGalleries = function(config) {
    config = config || {};
    sekUserGalleries.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('sekug',sekUserGalleries);
sekUserGalleries = new sekUserGalleries();
// JavaScript Document
sekUserGalleries.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,cls: 'container'
        ,items: [{
            html: '<h2>'+_('sekug.manager')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('sekug.groupsettings')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('sekug.groupsettings.manager.desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'sekug-grid-groupsettings'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('sekug.mimetypes')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('sekug.mimetypes.manager.desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'sekug-grid-mimetypes'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('sekug.imagesizes')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('sekug.imagesizes.manager.desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'sekug-grid-imagesizes'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('sekug.watermark.images')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('sekug.watermark.manager.desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'sekug-form-watermarks'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
                ,listeners: {
                    activate:  function() {
                        //alert('tab was activated.');
                        //this.getImages();
                        //sekUserGalleries.panel.WatermarkImages.prototype.getImages();
                        Ext.getCmp('sekug-form-watermarks').getImages();
                    }
                }
            },{
                title: _('sekug.reportabuse')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('sekug.reportabuse.manager.desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'sekug-grid-reportabuse'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('sekug.usersettings')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('sekug.usersettings.manager.desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'sekug-grid-usersettings'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            },{
                title: _('sekug.albums')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('sekug.album.manager.desc')+'</p>'
                    ,border: false
                    ,bodyCssClass: 'panel-desc'
                },{
                    xtype: 'sekug-grid-albums'
                    ,cls: 'main-wrapper'
                    ,preventRender: true
                }]
            }]
        }]
    });
    sekUserGalleries.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.panel.Home,MODx.Panel);
Ext.reg('sekug-panel-home',sekUserGalleries.panel.Home);
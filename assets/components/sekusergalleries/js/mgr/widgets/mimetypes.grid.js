// JavaScript Document
sekUserGalleries.grid.MimeTypes = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'sekug-grid-mimetypes'
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: { action: 'mgr/mimetypes/getlist' }
        ,fields: ['id','mimetype','resize_ext','menu']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'mimetype'
        ,save_action: 'mgr/mimetypes/updatefromgrid'
        ,autosave: true
        ,columns: [{
            header: _('sekug.mimetypes')
            ,dataIndex: 'mimetype'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.file.ext.resize')
            ,dataIndex: 'resize_ext'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        }]
        ,tbar:[{
            text: _('sekug.create')
            ,handler: { xtype: 'sekug-window-mimetypes-create' ,blankValues: true }
        }]
        ,getMenu: function() {
            return [{
                text: _('sekug.update')
                ,handler: this.updateMimeTypes
            },'-',{
                text: _('sekug.remove')
                ,handler: this.removeMimeTypes
            }];
        }
        ,updateMimeTypes: function(btn,e) {
            if (!this.updateMimeTypesWindow) {
                this.updateMimeTypesWindow = MODx.load({
                    xtype: 'sekug-window-mimetypes-update'
                    ,record: this.menu.record
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.updateMimeTypesWindow.setValues(this.menu.record);
            this.updateMimeTypesWindow.show(e.target);
        }
        ,removeMimeTypes: function() {
            MODx.msg.confirm({
                title: _('sekug.remove')
                ,text: _('sekug.remove.confirm')
                ,url: this.config.url
                ,params: {
                    action: 'mgr/mimetypes/remove'
                    ,id: this.menu.record.id
                }
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
    });
    sekUserGalleries.grid.MimeTypes.superclass.constructor.call(this,config)
};
Ext.extend(sekUserGalleries.grid.MimeTypes,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});Ext.reg('sekug-grid-mimetypes',sekUserGalleries.grid.MimeTypes);

sekUserGalleries.window.CreateMimeTypes = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.create')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/mimetypes/create'
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.mimetypes')
            ,name: 'mimetype'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.file.ext.resize')
            ,name: 'resize_ext'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.CreateMimeTypes.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.CreateMimeTypes,MODx.Window);
Ext.reg('sekug-window-mimetypes-create',sekUserGalleries.window.CreateMimeTypes);

sekUserGalleries.window.UpdateMimeTypes = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.update')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/mimetypes/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.mimetypes')
            ,name: 'mimetype'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.file.ext.resize')
            ,name: 'resize_ext'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.UpdateMimeTypes.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.UpdateMimeTypes,MODx.Window);
Ext.reg('sekug-window-mimetypes-update',sekUserGalleries.window.UpdateMimeTypes);
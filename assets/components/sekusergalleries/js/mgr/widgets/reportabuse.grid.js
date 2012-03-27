// JavaScript Document
sekUserGalleries.grid.ReportAbuse = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'sekug-grid-reportabuse'
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: { action: 'mgr/reportabuse/getlist' }
        ,fields: ['id','item_type','item_id','description','postedon','resolved','notes','menu']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'item_id'
        ,save_action: 'mgr/reportabuse/updatefromgrid'
        ,autosave: true
        ,columns: [{
            header: _('sekug.item_type')
            ,dataIndex: 'item_type'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'sekug-combo-itemtype', renderer: true }
        },{
            header: _('sekug.item')
            ,dataIndex: 'item_id'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.postedon')
            ,dataIndex: 'postedon'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'datefield' }
        },{
            header: _('sekug.resolved')
            ,dataIndex: 'resolved'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'modx-combo-boolean', renderer: true }
        },{
            header: _('sekug.notes')
            ,dataIndex: 'notes'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        }]
        ,tbar:[{
            text: _('sekug.create')
            ,handler: { xtype: 'sekug-window-reportabuse-create' ,blankValues: true }
        }]
        ,getMenu: function() {
            return [{
                text: _('sekug.update')
                ,handler: this.updateReportAbuse
            },'-',{
                text: _('sekug.remove')
                ,handler: this.removeReportAbuse
            }];
        }
        ,updateReportAbuse: function(btn,e) {
            if (!this.updateReportAbuseWindow) {
                this.updateReportAbuseWindow = MODx.load({
                    xtype: 'sekug-window-reportabuse-update'
                    ,record: this.menu.record
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.updateReportAbuseWindow.setValues(this.menu.record);
            this.updateReportAbuseWindow.show(e.target);
        }
        ,removeReportAbuse: function() {
            MODx.msg.confirm({
                title: _('sekug.remove')
                ,text: _('sekug.remove.confirm')
                ,url: this.config.url
                ,params: {
                    action: 'mgr/reportabuse/remove'
                    ,id: this.menu.record.id
                }
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
    });
    sekUserGalleries.grid.ReportAbuse.superclass.constructor.call(this,config)
};
Ext.extend(sekUserGalleries.grid.ReportAbuse,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});Ext.reg('sekug-grid-reportabuse',sekUserGalleries.grid.ReportAbuse);

sekUserGalleries.window.CreateReportAbuse = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.create')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/reportabuse/create'
        }
        ,fields: [{
            xtype: 'sekug-combo-itemtype'
            ,fieldLabel: _('sekug.item_type')
            ,name: 'item_type'
            ,hiddenName: 'item_type'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.item')
            ,name: 'item_id'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.postedon')
            ,name: 'postedon'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.resolved')
            ,name: 'resolved'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.notes')
            ,name: 'notes'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.CreateReportAbuse.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.CreateReportAbuse,MODx.Window);
Ext.reg('sekug-window-reportabuse-create',sekUserGalleries.window.CreateReportAbuse);

sekUserGalleries.window.UpdateReportAbuse = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.update')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/reportabuse/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'sekug-combo-itemtype'
            ,fieldLabel: _('sekug.item_type')
            ,name: 'item_type'
            ,hiddenName: 'item_type'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.item')
            ,name: 'item_id'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.postedon')
            ,name: 'postedon'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.resolved')
            ,name: 'resolved'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.notes')
            ,name: 'notes'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.UpdateReportAbuse.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.UpdateReportAbuse,MODx.Window);
Ext.reg('sekug-window-reportabuse-update',sekUserGalleries.window.UpdateReportAbuse);


sekUserGalleries.combo.ItemType = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['itemtype','display']
            ,data: [
                ['Album','Album']
                ,['Item','Item']
            ]
        })
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'itemtype'
    });
    sekUserGalleries.combo.ItemType.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.combo.ItemType,MODx.combo.ComboBox);
Ext.reg('sekug-combo-itemtype',sekUserGalleries.combo.ItemType);
// JavaScript Document
sekUserGalleries.grid.GroupSettings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'sekug-grid-groupsettings'
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: { action: 'mgr/groupsettings/getlist' }
        ,fields: ['id','usergroup','userrole','amount','unit','level','private','menu']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'usergroup'
		,save_action: 'mgr/groupsettings/updatefromgrid'
		,autosave: true
        ,columns: [{
            header: _('sekug.usergroup')
            ,dataIndex: 'usergroup'
            ,sortable: true
            ,width: 80
            ,editor: { xtype: 'modx-combo-usergroup', renderer: true }
        },{
            header: _('sekug.userrole')
            ,dataIndex: 'userrole'
            ,sortable: false
            ,width: 80
            ,editor: { xtype: 'modx-combo-usergrouprole', renderer: true }
        },{
            header: _('sekug.amount')
            ,dataIndex: 'amount'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.unit')
            ,dataIndex: 'unit'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'sekug-combo-units', renderer: true }
        },{
            header: _('sekug.level')
            ,dataIndex: 'level'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'sekug-combo-levels', renderer: true }
        },{
            header: _('sekug.private')
            ,dataIndex: 'private'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'modx-combo-boolean', renderer: true }
        }]
		,tbar:[{
			   text: _('sekug.create')
			   ,handler: { xtype: 'sekug-window-groupsettings-create' ,blankValues: true }
		}]
		,getMenu: function() {
			return [{
				text: _('sekug.update')
				,handler: this.updateGroupSettings
			},'-',{
				text: _('sekug.remove')
				,handler: this.removeGroupSettings
			}];
		}
		,updateGroupSettings: function(btn,e) {
			if (!this.updateGroupSettingsWindow) {
				this.updateGroupSettingsWindow = MODx.load({
					xtype: 'sekug-window-groupsettings-update'
					,record: this.menu.record
					,listeners: {
						'success': {fn:this.refresh,scope:this}
					}
				});
			}
			this.updateGroupSettingsWindow.setValues(this.menu.record);
			this.updateGroupSettingsWindow.show(e.target);
		}
		,removeGroupSettings: function() {
			MODx.msg.confirm({
				title: _('sekug.remove')
				,text: _('sekug.remove.confirm')
				,url: this.config.url
				,params: {
					action: 'mgr/groupsettings/remove'
					,id: this.menu.record.id
				}
				,listeners: {
					'success': {fn:this.refresh,scope:this}
				}
			});
		}
    });
    sekUserGalleries.grid.GroupSettings.superclass.constructor.call(this,config)
};
Ext.extend(sekUserGalleries.grid.GroupSettings,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});Ext.reg('sekug-grid-groupsettings',sekUserGalleries.grid.GroupSettings);

sekUserGalleries.window.CreateGroupSettings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.create')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/groupsettings/create'
        }
        ,fields: [{
            xtype: 'modx-combo-usergroup'
            ,fieldLabel: _('sekug.usergroup')
            ,name: 'usergroup'
			,hiddenName: 'usergroup'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-role'
            ,fieldLabel: _('sekug.userrole')
            ,name: 'userrole'
			,hiddenName: 'userrole'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.amount')
            ,name: 'amount'
            ,anchor: '100%'
        },{
            xtype: 'sekug-combo-units'
            ,fieldLabel: _('sekug.unit')
            ,name: 'unit'
			,hiddenName: 'unit'
            ,anchor: '100%'
        },{
            xtype: 'sekug-combo-levels'
            ,fieldLabel: _('sekug.level.enforcement')
            ,name: 'level'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.private.only')
            ,name: 'private'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.CreateGroupSettings.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.CreateGroupSettings,MODx.Window);
Ext.reg('sekug-window-groupsettings-create',sekUserGalleries.window.CreateGroupSettings);

sekUserGalleries.window.UpdateGroupSettings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.update')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/groupsettings/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'modx-combo-usergroup'
            ,fieldLabel: _('sekug.usergroup')
            ,name: 'usergroup'
			,hiddenName: 'usergroup'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-role'
            ,fieldLabel: _('sekug.userrole')
            ,name: 'userrole'
			,hiddenName: 'userrole'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.amount')
            ,name: 'amount'
            ,anchor: '100%'
        },{
            xtype: 'sekug-combo-units'
            ,fieldLabel: _('sekug.unit')
            ,name: 'unit'
			,hiddenName: 'unit'
            ,anchor: '100%'
        },{
            xtype: 'sekug-combo-levels'
            ,fieldLabel: _('sekug.level.enforcement')
            ,name: 'level'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.private.only')
            ,name: 'private'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.UpdateGroupSettings.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.UpdateGroupSettings,MODx.Window);
Ext.reg('sekug-window-groupsettings-update',sekUserGalleries.window.UpdateGroupSettings);


sekUserGalleries.combo.Units = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		store: new Ext.data.ArrayStore({
			id: 0
			,fields: ['unit','display']
			,data: [
				['MiB','Mebibyte']
				,['GiB','Gibibyte']
				,['TiB','Tebibyte']
				,['PiB','Pebibyte']
				,['EiB','Exbibyte']
				,['ZiB','Zebibyte']
				,['YiB','Yobibyte']
			]
    	})
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'unit'
    });
    sekUserGalleries.combo.Units.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.combo.Units,MODx.combo.ComboBox);
Ext.reg('sekug-combo-units',sekUserGalleries.combo.Units);

sekUserGalleries.combo.Levels = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		store: new Ext.data.ArrayStore({
			id: 0
			,fields: ['level']
			,data: [
				['Soft']
				,['Hard']
			]
    	})
        ,mode: 'local'
        ,displayField: 'level'
        ,valueField: 'level'
    });
    sekUserGalleries.combo.Levels.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.combo.Levels,MODx.combo.ComboBox);
Ext.reg('sekug-combo-levels',sekUserGalleries.combo.Levels);
// JavaScript Document
sekUserGalleries.grid.UserSettings = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'sekug-grid-usersettings'
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: { action: 'mgr/usersettings/getlist' }
        ,fields: ['gallery_user','gallery_title','gallery_description','gallery_cover','private','menu']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'gallery_title'
		,save_action: 'mgr/usersettings/updatefromgrid'
		,autosave: true
        ,columns: [{
            header: _('sekug.user')
            ,dataIndex: 'gallery_user'
            ,sortable: true
            ,width: 100
        },{
            header: _('sekug.title')
            ,dataIndex: 'gallery_title'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.description')
            ,dataIndex: 'gallery_description'
            ,sortable: false
            ,width: 350
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.coverimage')
            ,dataIndex: 'gallery_cover'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.private')
            ,dataIndex: 'private'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'modx-combo-boolean', renderer: true }
        }]
		,tbar:[{
			   text: _('sekug.create')
			   ,handler: { xtype: 'sekug-window-usersettings-create' ,blankValues: true }
			},'->',{
				xtype: 'textfield'
				,id: 'sekug-usersettings-search-filter'
				,emptyText: _('sekug.search...')
				,listeners: {
					'change': {fn:this.search,scope:this}
					,'render': {fn: function(cmp) {
						new Ext.KeyMap(cmp.getEl(), {
							key: Ext.EventObject.ENTER
							,fn: function() {
								this.fireEvent('change',this);
								this.blur();
								return true;
							}
							,scope: cmp
						});
					}
					,scope:this
				}
			}
		}]
		,getMenu: function() {
			return [{
				text: _('sekug.update')
				,handler: this.updateUserSetting
			},'-',{
				text: _('sekug.remove')
				,handler: this.removeUserSetting
			}];
		}
		,updateUserSetting: function(btn,e) {
			if (!this.updateUserSettingWindow) {
				this.updateUserSettingWindow = MODx.load({
					xtype: 'sekug-window-usersettings-update'
					,record: this.menu.record
					,listeners: {
						'success': {fn:this.refresh,scope:this}
					}
				});
			}
			this.updateUserSettingWindow.setValues(this.menu.record);
			this.updateUserSettingWindow.show(e.target);
		}
		,removeUserSetting: function() {
			MODx.msg.confirm({
				title: _('sekug.remove')
				,text: _('sekug.remove.confirm')
				,url: this.config.url
				,params: {
					action: 'mgr/usersettings/remove'
					,gallery_user: this.menu.record.gallery_user
				}
				,listeners: {
					'success': {fn:this.refresh,scope:this}
				}
			});
		}
    });
    sekUserGalleries.grid.UserSettings.superclass.constructor.call(this,config)
};
Ext.extend(sekUserGalleries.grid.UserSettings,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});Ext.reg('sekug-grid-usersettings',sekUserGalleries.grid.UserSettings);

sekUserGalleries.window.CreateUserSetting = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.create')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/usersettings/create'
        }
        ,fields: [{
            xtype: 'modx-combo-user'
            ,fieldLabel: _('sekug.user')
            ,name: 'gallery_user'
			,hiddenName: 'gallery_user'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.title')
            ,name: 'gallery_title'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.description')
            ,name: 'gallery_description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.coverimage')
            ,name: 'gallery_cover'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.private.only')
            ,name: 'private'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.CreateUserSetting.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.CreateUserSetting,MODx.Window);
Ext.reg('sekug-window-usersettings-create',sekUserGalleries.window.CreateUserSetting);

sekUserGalleries.window.UpdateUserSetting = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.update')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/usersettings/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'gallery_user'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.title')
            ,name: 'gallery_title'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.description')
            ,name: 'gallery_description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.coverimage')
            ,name: 'gallery_cover'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.private.only')
            ,name: 'private'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.UpdateUserSetting.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.UpdateUserSetting,MODx.Window);
Ext.reg('sekug-window-usersettings-update',sekUserGalleries.window.UpdateUserSetting);
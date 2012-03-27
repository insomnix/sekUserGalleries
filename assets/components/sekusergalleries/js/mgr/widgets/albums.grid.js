// JavaScript Document
sekUserGalleries.grid.Albums = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'sekug-grid-albums'
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: { action: 'mgr/albums/getlist' }
        ,fields: ['id','album_user','album_title','album_description','album_keywords','active_from','active_to','album_cover','private','createdon','editedon','menu']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'album_title'
		,save_action: 'mgr/albums/updatefromgrid'
		,autosave: true
        ,columns: [{
            header: _('sekug.id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 50
        },{
            header: _('sekug.user')
            ,dataIndex: 'album_user'
            ,sortable: true
            ,width: 100
        },{
            header: _('sekug.title')
            ,dataIndex: 'album_title'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.description')
            ,dataIndex: 'album_description'
            ,sortable: false
            ,width: 150
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.keywords')
            ,dataIndex: 'album_keywords'
            ,sortable: false
            ,width: 150
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.active.from')
            ,dataIndex: 'active_from'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'datefield' }
			,allowBlank: true
        },{
            header: _('sekug.active.to')
            ,dataIndex: 'active_to'
            ,sortable: false
            ,width: 100
            ,editor: { xtype: 'datefield' }
			,allowBlank: true
        },{
            header: _('sekug.coverimage')
            ,dataIndex: 'album_cover'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.parent')
            ,dataIndex: 'album_parent'
            ,sortable: true
            ,width: 100
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.private')
            ,dataIndex: 'private'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'modx-combo-boolean', renderer: true }
        },{
            header: _('sekug.createdon')
            ,dataIndex: 'createdon'
            ,sortable: true
            ,width: 100
        },{
            header: _('sekug.updatedon')
            ,dataIndex: 'editedon'
            ,sortable: true
            ,width: 100
        }]
		,tbar:[{
			   text: _('sekug.create')
			   ,handler: { xtype: 'sekug-window-album-create' ,blankValues: true }
			},'->',{
				xtype: 'textfield'
				,id: 'sekug-album-search-filter'
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
				,handler: this.updateAlbum
			},'-',{
				text: _('sekug.remove')
				,handler: this.removeAlbum
			}];
		}
		,updateAlbum: function(btn,e) {
			if (!this.updateAlbumWindow) {
				this.updateAlbumWindow = MODx.load({
					xtype: 'sekug-window-album-update'
					,record: this.menu.record
					,listeners: {
						'success': {fn:this.refresh,scope:this}
					}
				});
			}
			this.updateAlbumWindow.setValues(this.menu.record);
			this.updateAlbumWindow.show(e.target);
		}
		,removeAlbum: function() {
			MODx.msg.confirm({
				title: _('sekug.remove')
				,text: _('sekug.remove.confirm')
				,url: this.config.url
				,params: {
					action: 'mgr/albums/remove'
					,id: this.menu.record.id
				}
				,listeners: {
					'success': {fn:this.refresh,scope:this}
				}
			});
		}
    });
    sekUserGalleries.grid.Albums.superclass.constructor.call(this,config)
};
Ext.extend(sekUserGalleries.grid.Albums,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});Ext.reg('sekug-grid-albums',sekUserGalleries.grid.Albums);

sekUserGalleries.window.CreateAlbum = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.create')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/albums/create'
        }
        ,fields: [{
            xtype: 'modx-combo-user'
            ,fieldLabel: _('sekug.user')
            ,name: 'album_user'
			,hiddenName: 'album_user'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.title')
            ,name: 'album_title'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.description')
            ,name: 'album_description'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.keywords')
            ,name: 'album_keywords'
            ,anchor: '100%'
        },{
            xtype: 'datefield'
            ,fieldLabel: _('sekug.active.from')
            ,name: 'active_from'
            ,anchor: '100%'
        },{
            xtype: 'datefield'
            ,fieldLabel: _('sekug.active.to')
            ,name: 'active_to'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.coverimage')
            ,name: 'album_cover'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.parent')
            ,name: 'album_parent'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.private.only')
            ,name: 'private'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.CreateAlbum.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.CreateAlbum,MODx.Window);
Ext.reg('sekug-window-album-create',sekUserGalleries.window.CreateAlbum);

sekUserGalleries.window.UpdateAlbum = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.update')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/albums/update'
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.title')
            ,name: 'album_title'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.description')
            ,name: 'album_description'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.keywords')
            ,name: 'album_keywords'
            ,anchor: '100%'
        },{
            xtype: 'datefield'
            ,fieldLabel: _('sekug.active.from')
            ,name: 'active_from'
            ,anchor: '100%'
        },{
            xtype: 'datefield'
            ,fieldLabel: _('sekug.active.to')
            ,name: 'active_to'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.coverimage')
            ,name: 'album_cover'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.parent')
            ,name: 'album_parent'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.private.only')
            ,name: 'private'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.UpdateAlbum.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.UpdateAlbum,MODx.Window);
Ext.reg('sekug-window-album-update',sekUserGalleries.window.UpdateAlbum);
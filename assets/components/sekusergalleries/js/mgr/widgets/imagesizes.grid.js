// JavaScript Document
sekUserGalleries.grid.ImageSizes = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'sekug-grid-imagesizes'
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: { action: 'mgr/imagesizes/getlist' }
        ,fields: ['id','name','description','max_width','max_height','image_quality','watermark_image','watermark_brightness','watermark_text','watermark_text_color','watermark_font','watermark_font_size','watermark_location','primary','menu']
        ,paging: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'name'
        ,save_action: 'mgr/imagesizes/updatefromgrid'
        ,autosave: true
        ,columns: [{
            header: _('sekug.name')
            ,dataIndex: 'name'
            ,sortable: false
            ,width: 50
        },{
            header: _('sekug.description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.max_width')
            ,dataIndex: 'max_width'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.max_height')
            ,dataIndex: 'max_height'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.imagequality')
            ,dataIndex: 'image_quality'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.watermark.image')
            ,dataIndex: 'watermark_image'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.brightness')
            ,dataIndex: 'watermark_brightness'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.watermark.text')
            ,dataIndex: 'watermark_text'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.textcolor')
            ,dataIndex: 'watermark_text_color'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.watermark.font')
            ,dataIndex: 'watermark_font'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.watermark.fontsize')
            ,dataIndex: 'watermark_font_size'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'textfield' }
        },{
            header: _('sekug.watermark.location')
            ,dataIndex: 'watermark_location'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'sekug-combo-watermarklocation', renderer: true }
        },{
            header: _('sekug.primary')
            ,dataIndex: 'primary'
            ,sortable: false
            ,width: 50
            ,editor: { xtype: 'modx-combo-boolean', renderer: true }
        }]
        ,tbar:[{
            text: _('sekug.create')
            ,handler: { xtype: 'sekug-window-imagesizes-create' ,blankValues: true }
        }]
        ,getMenu: function() {
            return [{
                text: _('sekug.update')
                ,handler: this.updateImageSizes
            },'-',{
                text: _('sekug.remove')
                ,handler: this.removeImageSizes
            }];
        }
        ,updateImageSizes: function(btn,e) {
            if (!this.updateImageSizesWindow) {
                this.updateImageSizesWindow = MODx.load({
                    xtype: 'sekug-window-imagesizes-update'
                    ,record: this.menu.record
                    ,listeners: {
                        'success': {fn:this.refresh,scope:this}
                    }
                });
            }
            this.updateImageSizesWindow.setValues(this.menu.record);
            this.updateImageSizesWindow.show(e.target);
        }
        ,removeImageSizes: function() {
            MODx.msg.confirm({
                title: _('sekug.remove')
                ,text: _('sekug.remove.confirm')
                ,url: this.config.url
                ,params: {
                    action: 'mgr/imagesizes/remove'
                    ,id: this.menu.record.id
                }
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
    });
    sekUserGalleries.grid.ImageSizes.superclass.constructor.call(this,config)
};
Ext.extend(sekUserGalleries.grid.ImageSizes,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
});Ext.reg('sekug-grid-imagesizes',sekUserGalleries.grid.ImageSizes);

sekUserGalleries.window.CreateImageSizes = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.create')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/imagesizes/create'
        }
        ,fields: [{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.name')
            ,name: 'name'
            ,anchor: '100%'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.max_width')
            ,name: 'max_width'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.max_height')
            ,name: 'max_height'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.imagequality')
            ,name: 'image_quality'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.image')
            ,name: 'watermark_image'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.brightness')
            ,name: 'watermark_brightness'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.text')
            ,name: 'watermark_text'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.textcolor')
            ,name: 'watermark_text_color'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.font')
            ,name: 'watermark_font'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.fontsize')
            ,name: 'watermark_font_size'
            ,anchor: '100%'
        },{
            xtype: 'sekug-combo-watermarklocation'
            ,fieldLabel: _('sekug.watermark.location')
            ,name: 'watermark_location'
            ,hiddenName: 'watermark_location'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.primary')
            ,name: 'primary'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.CreateImageSizes.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.CreateImageSizes,MODx.Window);
Ext.reg('sekug-window-imagesizes-create',sekUserGalleries.window.CreateImageSizes);

sekUserGalleries.window.UpdateImageSizes = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('sekug.update')
        ,url: sekUserGalleries.config.connectorUrl
        ,baseParams: {
            action: 'mgr/imagesizes/update'
        }
        ,fields: [{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'hidden'
            ,name: 'name'
        },{
            xtype: 'textarea'
            ,fieldLabel: _('sekug.description')
            ,name: 'description'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.max_width')
            ,name: 'max_width'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.max_height')
            ,name: 'max_height'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.image')
            ,name: 'watermark_image'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.brightness')
            ,name: 'watermark_brightness'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.text')
            ,name: 'watermark_text'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.textcolor')
            ,name: 'watermark_text_color'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.font')
            ,name: 'watermark_font'
            ,anchor: '100%'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('sekug.watermark.fontsize')
            ,name: 'watermark_font_size'
            ,anchor: '100%'
        },{
            xtype: 'sekug-combo-watermarklocation'
            ,fieldLabel: _('sekug.watermark.location')
            ,name: 'watermark_location'
            ,hiddenName: 'watermark_location'
            ,anchor: '100%'
        },{
            xtype: 'modx-combo-boolean'
            ,fieldLabel: _('sekug.primary')
            ,name: 'primary'
            ,anchor: '100%'
        }]
    });
    sekUserGalleries.window.UpdateImageSizes.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.window.UpdateImageSizes,MODx.Window);
Ext.reg('sekug-window-imagesizes-update',sekUserGalleries.window.UpdateImageSizes);


sekUserGalleries.combo.WatermarkLocation = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.ArrayStore({
            id: 0
            ,fields: ['location','display']
            ,data: [
                ['NorthWest','TopLeft']
                ,['North','TopMiddle']
                ,['NorthEast','TopRight']
                ,['West','Left']
                ,['Center','Center']
                ,['East','Right']
                ,['SouthWest','BottomLeft']
                ,['South','BottomMiddle']
                ,['SouthEast','BottomRight']
            ]
        })
        ,mode: 'local'
        ,displayField: 'display'
        ,valueField: 'location'
    });
    sekUserGalleries.combo.WatermarkLocation.superclass.constructor.call(this,config);
};
Ext.extend(sekUserGalleries.combo.WatermarkLocation,MODx.combo.ComboBox);
Ext.reg('sekug-combo-watermarklocation',sekUserGalleries.combo.WatermarkLocation);
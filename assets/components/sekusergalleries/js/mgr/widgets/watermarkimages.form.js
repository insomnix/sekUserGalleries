sekUserGalleries.panel.WatermarkImages = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'sekug-form-watermarks'
        ,anchor: '97%'
        ,layout: 'form'
        ,autoHeight: true
        ,fileUpload: true
        ,items: [{
            xtype: 'fieldset'
            ,title: _('sekug.image.upload.new')
            ,autoHeight: true
            ,items: [{
                xtype: 'fileuploadfield'
                ,emptyText: _('sekug.image.select')
                ,buttonOnly: true
                ,fieldLabel: _('sekug.image.upload')
                ,name: 'file'
                ,allowBlank: true
                ,listeners: {
                    fileselected: function(fb, v) {
                        Ext.getCmp('sekug-form-watermarks').getForm().submit( {
                            url: sekUserGalleries.config.connectorUrl
                            ,params: {
                                action: 'mgr/imagesizes/watermarkupload'
                            }
                            ,waitMsg : _('sekug.uploading.file')
                            ,success : function(form, action) {
                                Ext.getCmp('sekug-form-watermarks').getImages();
                            }
                        });
                    }
                }
            }]
        },{
            xtype: 'fieldset'
            ,title: _('sekug.images.current')
            ,autoHeight: true
            ,items: [{
                xtype: 'panel'
                ,id: 'images-panel'
                ,html: '<div id="current-images"></div>'
            }]
        }]
        ,getImages: function() {
            Ext.Ajax.request({
                url: sekUserGalleries.config.connectorUrl,
                params: {
                    action: 'mgr/imagesizes/watermarkimages'
                }
                ,scope: this
                ,success: function(response) {
                    var images = response.responseText;
                    Ext.get('current-images').update(images);
                    this.addImageEvents();
                }
                ,failure:function() {
                    alert('There was a problem loading the current watermark images.');
                }
            });
        }
        ,addImageEvents: function() {
            var images = Ext.getBody().select('div.image-thumb');

            images.each(function(el, ce, index) {
                el.dd = new Ext.dd.DDProxy(el.dom.id);

                el.on('contextmenu', function(event, element) {
                    var id = element.id;
                    if (id == '') {
                        var parent = Ext.get(element).up('div');
                        id = parent.dom.id;
                    }

                    imageMenu.baseParams.image = id;

                    event.stopEvent();
                    imageMenu.showAt(event.xy);
                }, this);

            }, this);
        }
    });
    sekUserGalleries.panel.WatermarkImages.superclass.constructor.call(this,config)
};
Ext.extend(sekUserGalleries.panel.WatermarkImages,MODx.FormPanel);
Ext.reg('sekug-form-watermarks',sekUserGalleries.panel.WatermarkImages);


imageMenu = new Ext.menu.Menu({
    baseParams: {
        image: ''
    }
    ,items: [{
        text: _('sekug.remove'),
        listeners: {
            click: {
                scope: this,
                fn: function() {
                    Ext.Msg.show({
                        title: _('sekug.remove.watermark'),
                        msg: _('sekug.remove.watermark.confirmation'),
                        buttons: Ext.Msg.YESNO,
                        fn: function(response) {
                            if (response == 'yes') {
                                Ext.Ajax.request({
                                    url: sekUserGalleries.config.connectorUrl,
                                    params: {
                                        image: this.imageMenu.baseParams.image,
                                        action: 'mgr/imagesizes/watermarkdelete'
                                    },
                                    scope: this,
                                    success: function(response) {
                                        Ext.getCmp('sekug-form-watermarks').getImages();
                                    }
                                });
                            }
                        },
                        icon: Ext.MessageBox.QUESTION,
                        scope: this
                    });
                }
            }
        }
    }]
});


/*!
 * Ext JS Library 3.4.0
 * Copyright(c) 2006-2011 Sencha Inc.
 * licensing@sencha.com
 * http://www.sencha.com/license
 */
Ext.ns('Ext.ux.form');

/**
 * @class Ext.ux.form.FileUploadField
 * @extends Ext.form.TextField
 * Creates a file upload field.
 * @xtype fileuploadfield
 */
Ext.ux.form.FileUploadField = Ext.extend(Ext.form.TextField,  {
    /**
     * @cfg {String} buttonText The button text to display on the upload button (defaults to
     * 'Browse...').  Note that if you supply a value for {@link #buttonCfg}, the buttonCfg.text
     * value will be used instead if available.
     */
    buttonText: _('sekug.browse...'),
    /**
     * @cfg {Boolean} buttonOnly True to display the file upload field as a button with no visible
     * text field (defaults to false).  If true, all inherited TextField members will still be available.
     */
    buttonOnly: false,
    /**
     * @cfg {Number} buttonOffset The number of pixels of space reserved between the button and the text field
     * (defaults to 3).  Note that this only applies if {@link #buttonOnly} = false.
     */
    buttonOffset: 3,
    /**
     * @cfg {Object} buttonCfg A standard {@link Ext.Button} config object.
     */

    // private
    readOnly: true,

    /**
     * @hide
     * @method autoSize
     */
    autoSize: Ext.emptyFn,

    // private
    initComponent: function(){
        Ext.ux.form.FileUploadField.superclass.initComponent.call(this);

        this.addEvents(
            /**
             * @event fileselected
             * Fires when the underlying file input field's value has changed from the user
             * selecting a new file from the system file selection dialog.
             * @param {Ext.ux.form.FileUploadField} this
             * @param {String} value The file value returned by the underlying file input field
             */
            'fileselected'
        );
    },

    // private
    onRender : function(ct, position){
        Ext.ux.form.FileUploadField.superclass.onRender.call(this, ct, position);

        this.wrap = this.el.wrap({cls:'x-form-field-wrap x-form-file-wrap'});
        this.el.addClass('x-form-file-text');
        this.el.dom.removeAttribute('name');
        this.createFileInput();

        var btnCfg = Ext.applyIf(this.buttonCfg || {}, {
            text: this.buttonText
        });
        this.button = new Ext.Button(Ext.apply(btnCfg, {
            renderTo: this.wrap,
            cls: 'x-form-file-btn' + (btnCfg.iconCls ? ' x-btn-icon' : '')
        }));

        if(this.buttonOnly){
            this.el.hide();
            this.wrap.setWidth(this.button.getEl().getWidth());
        }

        this.bindListeners();
        this.resizeEl = this.positionEl = this.wrap;
    },

    bindListeners: function(){
        this.fileInput.on({
            scope: this,
            mouseenter: function() {
                this.button.addClass(['x-btn-over','x-btn-focus'])
            },
            mouseleave: function(){
                this.button.removeClass(['x-btn-over','x-btn-focus','x-btn-click'])
            },
            mousedown: function(){
                this.button.addClass('x-btn-click')
            },
            mouseup: function(){
                this.button.removeClass(['x-btn-over','x-btn-focus','x-btn-click'])
            },
            change: function(){
                var v = this.fileInput.dom.value;
                this.setValue(v);
                this.fireEvent('fileselected', this, v);
            }
        });
    },

    createFileInput : function() {
        this.fileInput = this.wrap.createChild({
            id: this.getFileInputId(),
            name: this.name||this.getId(),
            cls: 'x-form-file',
            tag: 'input',
            type: 'file',
            size: 1
        });
    },

    reset : function(){
        if (this.rendered) {
            this.fileInput.remove();
            this.createFileInput();
            this.bindListeners();
        }
        Ext.ux.form.FileUploadField.superclass.reset.call(this);
    },

    // private
    getFileInputId: function(){
        return this.id + '-file';
    },

    // private
    onResize : function(w, h){
        Ext.ux.form.FileUploadField.superclass.onResize.call(this, w, h);

        this.wrap.setWidth(w);

        if(!this.buttonOnly){
            var w = this.wrap.getWidth() - this.button.getEl().getWidth() - this.buttonOffset;
            this.el.setWidth(w);
        }
    },

    // private
    onDestroy: function(){
        Ext.ux.form.FileUploadField.superclass.onDestroy.call(this);
        Ext.destroy(this.fileInput, this.button, this.wrap);
    },

    onDisable: function(){
        Ext.ux.form.FileUploadField.superclass.onDisable.call(this);
        this.doDisable(true);
    },

    onEnable: function(){
        Ext.ux.form.FileUploadField.superclass.onEnable.call(this);
        this.doDisable(false);

    },

    // private
    doDisable: function(disabled){
        this.fileInput.dom.disabled = disabled;
        this.button.setDisabled(disabled);
    },


    // private
    preFocus : Ext.emptyFn,

    // private
    alignErrorIcon : function(){
        this.errorIcon.alignTo(this.wrap, 'tl-tr', [2, 0]);
    }

});

Ext.reg('fileuploadfield', Ext.ux.form.FileUploadField);

// backwards compat
Ext.form.FileUploadField = Ext.ux.form.FileUploadField;
/*
Ext.override(Ext.form.Field, {
    hideItem: function(){
        if (this.getForm(this)) {
            this.getForm(this).addClass('x-hide-' + this.hideMode);
        }
    },
    showItem: function(){
        if (this.getForm(this)) {
            this.getForm(this).removeClass('x-hide-' + this.hideMode);
        }
    },
    setFieldLabel: function(text) {
        if (this.getForm(this)) {
            var label = this.getForm(this).first('label.x-form-item-label');
            label.update(text);
        }
    },
    getForm: function() {
        return this.el.findParent('.x-form-item', 3, true);
    }
});
*/


Ext.define('Account.GR.Item.Form_spec', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'gr/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

// Start Write Forms
		this.items = [{
			xtype: 'container',
            layout: 'hbox',
            anchor: '100%',
            defaultType: 'textfield',
            //margin: '5 0 5 600',
        items: [{
                xtype: 'container',
                layout: 'anchor',
     items :[{
   	        xtype: 'textfield',
   	        fieldLabel: 'Serial No',
			align: 'right',
			readOnly: true,
			margin: '3 0 0 0',
			width:400,
			name: 'serno'
		},{
                xtype: 'container',
                layout: 'hbox',
                items :[{
   	        xtype: 'textfield',
   	        fieldLabel: 'GL Account',
			align: 'right',
			readOnly: true,
			margin: '3 0 0 0',
			width:200,
			name: 'saknr'
		},{
			xtype: 'displayfield',
			name: 'gltxt',
			margins: '3 0 0 5',
			width:200
                }]
            },{
   	        xtype: 'textfield',
   	        fieldLabel: 'Brand',
			align: 'right',
			readOnly: true,
			margin: '3 0 0 0',
			width:400,
			name: 'brand'
		},{
			xtype: 'textfield',
			fieldLabel: 'Model',
			margin: '3 0 0 0',
			readOnly: true,
			width:400,
			name: 'model'
		},{
			xtype: 'textfield',
			fieldLabel: 'Specification',
			margin: '3 0 0 0',
			readOnly: true,
			width:400,
			name: 'specs'
		}]
            },{
                xtype: 'container',
                layout: 'anchor',
                margins: '0 0 0 60',
        items: [{
                xtype: 'container',
                layout: 'hbox',
                items :[{
   	        xtype: 'textfield',
   	        fieldLabel: 'Under Asset',
			align: 'right',
			readOnly: true,
			margin: '3 0 0 0',
			width:200,
			name: 'assnr'
		},{
			xtype: 'displayfield',
			name: 'asstx',
			margins: '3 0 0 5',
			width:200
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[{
   	        xtype: 'textfield',
   	        fieldLabel: 'Requesting By',
			align: 'right',
			readOnly: true,
			margin: '3 0 0 0',
			width:200,
			name: 'reque'
		},{
			xtype: 'displayfield',
			name: 'reqtx',
			margins: '3 0 0 5',
			width:200
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[{
   	        xtype: 'textfield',
   	        fieldLabel: 'Asset Holder',
			align: 'right',
			readOnly: true,
			margin: '3 0 0 0',
			width:200,
			name: 'holds'
		},{
			xtype: 'displayfield',
			name: 'hodtx',
			margins: '3 0 0 5',
			width:200
                }]
            },{
                xtype: 'container',
                layout: 'hbox',
                items :[{
   	        xtype: 'textfield',
   	        fieldLabel: 'Department',
			align: 'right',
			readOnly: true,
			margin: '3 0 0 0',
			width:200,
			name: 'depnr'
		},{
			xtype: 'displayfield',
			name: 'deptx',
			margins: '3 0 0 5',
			width:200
                }]
            },{
			xtype: 'textfield',
			fieldLabel: 'Keeping Area',
			margin: '3 0 0 0',
			readOnly: true,
			width:350,
			name: 'keepi'
		},{
			xtype: 'textfield',
			fieldLabel: 'Residual Value',
			margin: '3 0 0 0',
			readOnly: true,
			width:250,
			name: 'resid'
		}]
		}]
		}];

		// Event /////////
		var setAlignRight = function(o){
			o.inputEl.setStyle('text-align', 'right');
		};
		var setBold = function(o){
			o.inputEl.setStyle('font-weight', 'bold');
		};

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'gr/load'
		});
	},
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();
		if (_form_basic.isValid()) {
			_form_basic.submit({
				success: function(form_basic, action) {
					form_basic.reset();
					_this.fireEvent('afterSave', _this);
				},
				failure: function(form_basic, action) {
					Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
				}
			});
		}
	},
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'gr/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
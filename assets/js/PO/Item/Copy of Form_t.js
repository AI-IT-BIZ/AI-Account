Ext.define('Account.PR2.Item.Form_t', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'pr2/save',
			/*
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
				labelWidth: 100,
				width:300,
				labelStyle: 'font-weight:bold'
			}
			*/
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				labelWidth: 100,
				//width:300,
				labelStyle: 'font-weight:normal'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [{
			xtype: 'textfield',
			fieldLabel: 'Total',
			name: 'beamt',
			//align: 'right',
			//flex: 2,
			//anchor:'50%',
			labelWidth: 155,
			width:270,
			margin: '0 0 0 590',
			allowBlank: false
		},{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '5 0 5 590',
   items: [{
			xtype: 'textfield',
			fieldLabel: 'Discount',
			name: 'dismt',
			//anchor:'80%',
			//fieldWidth: 250,
			//align: 'right',
			//margin: '0 0 0 650',
			labelWidth: 80,
			width:150,
			allowBlank: true
		},{
            xtype: 'textfield',
			//fieldLabel: 'Discount',
			name: 'aaa',
			//align: 'right',
			//anchor:'80%',
			width:110,
			margin: '0 0 0 10',
			allowBlank: true
         
         }]
         },{
         	xtype: 'textfield',
			fieldLabel: 'After Discount',
			name: 'bbb',
			//align: 'right',
			//flex: 2,
			//anchor:'90%',
			width:270,
			labelWidth: 155,
			margin: '0 0 0 590',
			allowBlank: false
		},{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '5 0 5 590',
   items: [{
			xtype: 'textfield',
			fieldLabel: 'Tax',
			name: 'taxpr',
			//align: 'right',
			labelWidth: 80,
			//anchor:'90%',
			width:120,
			allowBlank: true
		},{
			xtype: 'displayfield',
			//fieldLabel: '%',
			//name: 'taxpr',
			//align: 'right',
			//labelWidth: 5,
			//anchor:'90%',
			width:10,
			value: '%',
			allowBlank: true
		},{
            xtype: 'textfield',
			//fieldLabel: 'Discount',
			name: 'ccc',
			//align: 'right',
			//anchor:'90%',
			margin: '0 0 0 30',
			width:110,
			allowBlank: true
         
         }]
         },{
         	xtype: 'textfield',
			fieldLabel: 'Net Amount',
			name: 'netwr',
			//align: 'right',
			//flex: 2,
			//anchor:'90%',
			width:270,
			labelWidth: 155,
			margin: '0 0 0 590',
			labelStyle: 'font-weight:bold',
			allowBlank: false
         },{
         	xtype: 'textarea',
			fieldLabel: 'Comment',
			name: 'sgtxt',
			//align: 'right',
			//flex: 2,
			//anchor:'90%',
			width:455,
			height:50,
			labelWidth: 100,
			margin: '0 0 0 10',
			allowBlank: false
		}];

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pr2/load'
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
			url:__site_url+'pr2/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
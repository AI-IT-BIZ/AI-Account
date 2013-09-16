Ext.define('Account.Bankname.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'bankname/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
				msgTarget: 'qtip',//'side',
				labelWidth: 105,
				//width:300,
				//labelStyle: 'font-weight:bold'
			}
		});
		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		// INIT Warehouse search popup ///////
		//this.customerDialog = Ext.create('Account.Customer.MainWindow');
		
		this.items = [{
			xtype:'textfield',
            title: 'Bank Data',
            //collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
     items :[{
			xtype: 'hidden',
			name: 'id'
		},{
            xtype: 'textfield',
			fieldLabel: 'Bank Code',
			name: 'bcode'
			//width:460
		},{
            xtype: 'textfield',
			fieldLabel: 'Bank Name(EN)',
			name: 'bname',
			//width:460,
		},{
            xtype: 'textfield',
			fieldLabel: 'Bank Name(TH)',
			name: 'bthai'
			//width:460,
		},
		{
            xtype: 'textfield',
			fieldLabel: 'GL No.',
			name: 'saknr'
			//width:460,
		},
		
		{
			xtype: 'textarea',
			fieldLabel: 'Address',
			name: 'addrs'
			//width:300,

        }
        ]
		}];

		//return this.callParent(arguments);
	//},

		return this.callParent(arguments);
	},
	
	// load //
	load : function(id){
		var _this=this;
		
		this.getForm().load({
			params: { id: id },
			url:__site_url+'bankname/load'//,
			//success: function(form, act){
			//	_this.fireEvent('afterLoad', form, act);
			//}			
		});
	},
	
	// save //
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
			url:__site_url+'bankname/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// default status = wait for approve
		//this.comboJStatus.setValue('01');
	}
});
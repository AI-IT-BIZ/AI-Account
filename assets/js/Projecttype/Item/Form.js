Ext.define('Account.Projecttype.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'project/save_type',
			border: false,
			//bodyPadding: 10,
			fieldDefaults: {
            	msgTarget: 'side',
				labelWidth: 105,
				//labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:15px;'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;


/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id',
		},{
			xtype: 'textfield',
			fieldLabel: 'Type Code',
			name: 'jtype',
			labelWidth: 120,
			labelStyle: 'font-weight:bold',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: 'Project Type',
			name: 'typtx',
			width: 400,
			labelWidth: 120,
			allowBlank: false
		}];
            	

/*(4)---Buttons-------------------------------*/
		this.buttons = [{
			text: 'Save',
			disabled: !UMS.CAN.EDIT('PJ'),
			handler: function() {
				var _form_basic = this.up('form').getForm();
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
			}
		}, {
			text: 'Cancel',
			handler: function() {
				this.up('form').getForm().reset();
				this.up('window').hide();
			}
		}];

		return this.callParent(arguments);
	},

/*(5)---Call Function-------------------------------*/
	/*
	load : function(kunnr){
		this.getForm().load({
			params: { kunnr: kunnr },
			url:__site_url+'customer2/load'
		});
	},*/

	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'project/load_type'

		});
	},
	reset: function(){
		this.getForm().reset();

		// default status = wait for approve
		//this.comboQStatus.setValue('01');
		//this.comboPleve.setValue('01');
	},
	remove : function(ktype){
		var _this=this;
		this.getForm().load({
			params: { id: jtype },
			url:__site_url+'project/remove_type',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
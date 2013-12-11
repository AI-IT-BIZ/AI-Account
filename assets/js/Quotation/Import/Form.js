Ext.define('Account.Quotation.Import.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			border: false,
			bodyStyle : 'padding:5px 0px 5px 0px;',
			labelWidth : 80,
			buttonAlign : 'center',
			border: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.uploadAct = new Ext.Action({
			text: 'Upload',
			iconCls: 'b-small-save'
		});

		this.items = [{
			xtype: 'filefield',
			name: 'userfile',
			fieldLabel: 'Excel file',
			labelAlign: 'right',
			msgTarget: 'side',
			allowBlank: false,
			anchor: '70%',
			buttonText: 'Select Excel file...',
			allowBlank: false
		}];

		this.buttons = [this.uploadAct];

		this.uploadAct.setHandler(function(){
			_this.save();
		});

		return this.callParent(arguments);
	},
	save: function(){
		var _this=this,
			form = this.getForm();
		if(form.isValid()){
			_this.fireEvent('upload_click');
			form.submit({
				url: __site_url+'import/upload/do_upload',
				waitMsg: 'Uploading excel file...',
				success: function(form, action) {
					//Ext.Msg.alert('Success', 'Your excel file "' + action.result.file + '" has been uploaded.');
					_this.fireEvent('upload_success', action.result.file);
				},
				failure: function(form, action) {
					Ext.Msg.show({
						title: 'An error occured.',
						msg: action.result.msg.error,
						buttons: Ext.Msg.OK,
						icon: Ext.MessageBox.ERROR
					});
				}
			});
		}
	},
	reset: function(){
		this.getForm().reset();
	}
});
Ext.define('Account.CustType.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'customertype/save',
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

        this.glnoDialog = Ext.create('Account.GL.MainWindow');
		
		this.trigGlno = Ext.create('Ext.form.field.Trigger', {
			name: 'saknr',
			fieldLabel: 'GL Account',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true,
			//width:290,
		});

/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id',
		},{
			xtype:'displayfield',
			fieldLabel: 'Type Code',
			name: 'ktype',
			readOnly: true,
			labelStyle: 'font-weight:bold',
			value: 'CSXX'
		}, {
			xtype: 'textfield',
			fieldLabel: 'Customer Type',
			name: 'custx',
			width: 400,
			allowBlank: false
		},{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigGlno,{
						xtype: 'displayfield',
						name: 'sgtxt',
						margins: '4 0 0 6',
						width:236//,
						//allowBlank: false
                }]
            }];
            
       // event trigGlno//
		this.trigGlno.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'gl/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.saknr);
							//_this.trigType.setValue(r.data.mtart);
			_this.getForm().findField('sgtxt').setValue(r.data.sgtxt);

						}else{
							o.setValue('');
			_this.getForm().findField('sgtxt').setValue('');
							o.markInvalid('Could not find GL no : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.glnoDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGlno.setValue(record.data.saknr);
			_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

			grid.getSelectionModel().deselectAll();
			_this.glnoDialog.hide();
		});

		this.trigGlno.onTriggerClick = function(){
			_this.glnoDialog.grid.load();
			_this.glnoDialog.show();
		};	

/*(4)---Buttons-------------------------------*/
		this.buttons = [{
			text: 'Save',
			disabled: !UMS.CAN.EDIT('CT'),
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
			url:__site_url+'customertype/load'

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
			params: { id: ktype },
			url:__site_url+'customertype/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
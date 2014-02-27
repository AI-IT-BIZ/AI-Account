Ext.define('Account.AssetGrp.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'asset/save_grp',
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
		
		this.typeDialog = Ext.create('Account.SAssettype.Window');
		
		this.trigType = Ext.create('Ext.form.field.Trigger', {
			name: 'mtart',
			fieldLabel: 'Asset Type',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true
		});

/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id',
		},{
			xtype:'displayfield',
			fieldLabel: 'Group Code',
			name: 'matkl',
			readOnly: true,
			labelStyle: 'font-weight:bold',
			value: 'TXX'
		}, {
			xtype: 'textfield',
			fieldLabel: 'Asset Group',
			name: 'matxt',
			width: 400,
			allowBlank: false
		},{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigType,{
						xtype: 'displayfield',
						name: 'mtype',
						margins: '3 0 0 5',
						width:236
                }]
            }];
            
       // event trigType//
		this.trigType.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'asset/load_type',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.mtart);
							//_this.trigType.setValue(r.data.mtart);
			                _this.getForm().findField('mtype').setValue(r.data.matxt);

						}else{
							o.setValue('');
							_this.getForm().findField('mtype').setValue('');
							o.markInvalid('Could not find asset type : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.typeDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigType.setValue(record.data.mtart);
			_this.getForm().findField('mtype').setValue(record.data.matxt);

			grid.getSelectionModel().deselectAll();
			_this.typeDialog.hide();
		});

		this.trigType.onTriggerClick = function(){
			_this.typeDialog.grid.load();
			_this.typeDialog.show();
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
			url:__site_url+'asset/load_grp'

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
			url:__site_url+'asset/remove_grp',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
Ext.define('Account.Position.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'sposition/save',
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

        // INIT GL search popup ///////////////////////////////////////////////
           this.depnoDialog = Ext.create('Account.SDepartment.MainWindow');
		// END GL search popup ///////////////////////////////////////////////
		
		this.trigDepno = Ext.create('Ext.form.field.Trigger', {
			name: 'depnr',
			fieldLabel: 'Department Code',
			triggerCls: 'x-form-search-trigger',
			labelStyle: 'font-weight:bold',
			labelWidth: 120,
			allowBlank: false,
			enableKeyEvents: true
		});
		
/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id',
		},{
                xtype: 'container',
                layout: 'hbox',
                items :[this.trigDepno,{
						xtype: 'displayfield',
						name: 'deptx',
						margins: '4 0 0 6',
						width:150//,
						//allowBlank: false
                }]
            },{
			xtype: 'textfield',
			fieldLabel: 'Position Code',
			name: 'posnr',
			labelWidth: 120,
			labelStyle: 'font-weight:bold',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: 'Position',
			name: 'postx',
			width: 350,
			labelWidth: 120,
			allowBlank: false
		}];
		
		// event trigGlno//
		this.trigDepno.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'sposition/load_dep',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.depnr);
							//_this.trigType.setValue(r.data.mtart);
			_this.getForm().findField('deptx').setValue(r.data.deptx);

						}else{
							o.setValue('');
			_this.getForm().findField('deptx').setValue('');
							o.markInvalid('Could not find Department no : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.depnoDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDepno.setValue(record.data.depnr);
			_this.getForm().findField('deptx').setValue(record.data.deptx);

			grid.getSelectionModel().deselectAll();
			_this.depnoDialog.hide();
		});

		this.trigDepno.onTriggerClick = function(){
			_this.depnoDialog.grid.load();
			_this.depnoDialog.show();
		};
            	

/*(4)---Buttons-------------------------------*/
		this.buttons = [{
			text: 'Save',
			disabled: !UMS.CAN.EDIT('PS'),
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
			url:__site_url+'sposition/load'

		});
	},
	reset: function(){
		this.getForm().reset();

	},
	remove : function(ktype){
		var _this=this;
		this.getForm().load({
			params: { id: depnr,id2: posnr },
			url:__site_url+'sposition/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
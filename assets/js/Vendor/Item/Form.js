Ext.define('Account.Vendor.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'vendor/save',
			border: false,
			//bodyPadding: 10,
			fieldDefaults: {
            	msgTarget: 'side',
				labelWidth: 120,
				//labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:15px;'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

//---Create Selection--------------------------------------------
        this.distrDialog = Ext.create('Account.SDistrict.MainWindow');
		
		this.trigDistr = Ext.create('Ext.form.field.Trigger', {
			name: 'distx',
			fieldLabel: 'Province',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelWidth:110,
			width:290,
		});
//---event triger----------------------------------------------------------------	
		// event trigDistr//
		this.trigDistr.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'sdistrict/loads',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.trigDistr.setValue(record.data.distx);

						}else{
							o.markInvalid('Could not find Province : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.distrDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDistr.setValue(record.data.distx);

			grid.getSelectionModel().deselectAll();
			_this.distrDialog.hide();
		});

		this.trigDistr.onTriggerClick = function(){
			_this.distrDialog.show();
		};	
//---Create Selection--------------------------------------------
        this.vtypDialog = Ext.create('Account.Vendortype.Window');
		
		this.trigVtyp = Ext.create('Ext.form.field.Trigger', {
			name: 'ventx',
			fieldLabel: 'Vendor Type',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			width:290,
		});
//---event triger----------------------------------------------------------------	
		// event trigVtyp//
		this.trigVtyp.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'vendortype/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							_this.trigVtyp.setValue(record.data.ventx);
							_this.getForm().findField('vtype').setValue(record.data.vtype);
							_this.getForm().findField('saknr').setValue(record.data.saknr);
							_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

						}else{
							o.markInvalid('Could not find vendor type : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vtypDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVtyp.setValue(record.data.ventx);
			_this.getForm().findField('vtype').setValue(record.data.vtype);
			_this.getForm().findField('saknr').setValue(record.data.saknr);
			_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

			grid.getSelectionModel().deselectAll();
			_this.vtypDialog.hide();
		});

		this.trigVtyp.onTriggerClick = function(){
			_this.vtypDialog.grid.load();
			_this.vtypDialog.show();
		};

//---Create Selection--------------------------------------------
        this.glnoDialog = Ext.create('Account.GL.MainWindow');
		
		this.trigGlno = Ext.create('Ext.form.field.Trigger', {
			name: 'saknr',
			fieldLabel: 'GL Account',
			triggerCls: 'x-form-search-trigger',
			allowBlank: false,
			enableKeyEvents: true,
			width:290
		});
	
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('VD'),
			fieldLabel: 'Vendor Status',
			name : 'statu',
			labelAlign: 'right',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			margin: '0 0 0 56',
			clearFilterOnReset: true,
			emptyText: '-- Select Status --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'customer/loads_acombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'statu'
					}
				},
				fields: [
					'statu',
					'statx'
				],
				remoteSort: true,
				sorters: 'statu ASC'
			}),
			queryMode: 'remote',
			displayField: 'statx',
			valueField: 'statu'
		});	
		
		this.comboPay = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Payments',
			name : 'ptype',
			width: 290,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Payments --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'customer/loads_tcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'ptype'
					}
				},
				fields: [
					'ptype',
					'paytx'
				],
				remoteSort: true,
				sorters: 'ptype ASC'
			}),
			queryMode: 'remote',
			displayField: 'paytx',
			valueField: 'ptype'
		});

/*---ComboBox Vat Type----------------------------*/
		this.comboTax = Ext.create('Ext.form.ComboBox', {			
			fieldLabel: 'Vat Type',
			name: 'taxnr',
			width:290,
			labelWidth: 120,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select Type --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'vendor/loads_combo/tax1/taxnr/taxtx',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'taxnr'
					}
				},
				fields: [
					'taxnr',
					'taxtx'
				],
				remoteSort: true,
				sorters: 'taxnr ASC'
			}),
			queryMode: 'remote',
			displayField: 'taxtx',
			valueField: 'taxnr'
		});	
		
		this.numberCredit = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Credit Terms',
			name: 'terms',
			labelAlign: 'right',
			width:200,
			hideTrigger:false,
			align: 'right',
			margin: '0 0 0 56'
         });
         
         this.numberDiscount = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Discount Amount',
			name: 'disct',
			labelAlign: 'left',
			width:290,
			hideTrigger:false
         });
         
         this.numberLimit = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Credit Limit Amt',
			name: 'apamt',
			labelAlign: 'right',
			hideTrigger:false,
			allowBlank: false,
			align: 'right',
			margin: '0 0 0 56'
         });
         
         this.numberMin = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Minimum Amount',
			name: 'begin',
			labelAlign: 'left',
			width:290,
			hideTrigger:false
         });
         
         this.numberMax = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Maximum Amount',
			name: 'endin',
			labelAlign: 'right',
			//width:200,
			hideTrigger:false,
			align: 'right',
			margin: '0 0 0 56'
         });
         
         this.numberVat = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Vat Value',
			name: 'vat01',
			labelAlign: 'right',
			hideTrigger:false,
			align: 'right',
			margin: '0 0 0 56'
         });

/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id'
		},{
			xtype: 'hidden',
			name: 'vtype'
		},{
			
/*(3)---Start Form-------------------------------*/	
/*---Vendor Head fieldset 1 --------------------------*/
/*------------------------------------------------------*/
		items: [{
            xtype: 'container',
            layout: 'anchor',
            margin: '10',
            items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                 items :[this.trigVtyp,{
                }, {
                    xtype:'displayfield',
					fieldLabel: 'Vendor Code',
					name: 'lifnr',
                    emptyText: 'XXXXX',
					labelAlign: 'right',
					readOnly: true,
					width:160,
            		margin: '0 0 0 60',
					value: 'XXXXX',
					labelStyle: 'font-weight:bold'
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Vendor Name',
					name: 'name1',
					allowBlank: false,
					width:470
                }]
            },{
            xtype:'fieldset',
            title: 'Address',
            items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
					xtype: 'textarea',
					fieldLabel: 'Address',
					name: 'adr01',
					labelWidth:110,
					width:460
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.trigDistr,{
                }, {
					xtype: 'textfield',
					fieldLabel: 'Post Code',
		            name: 'pstlz',
		            emptyText: 'xxxxx',
		            labelAlign: 'right',
		            maskRe: /[\d\-]/,
		            regex: /^\d{5}$/,
		            regexText: 'Must be in the format xxxxx',
            		margin: '0 0 0 43'
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Phone Number',
		            name: 'telf1',
		            labelWidth:110,
		            width: 290,
		            emptyText: 'xxx-xxxxxxx',
		            maskRe: /[\d\-]/,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Fax Number',
		            name: 'telfx',
		            labelAlign: 'right',
		            margin: '0 0 0 46'
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
                		xtype: 'textfield',
					fieldLabel: 'Email',
					name: 'email',
					labelWidth:110,
		            width: 460
                }, {
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
                	xtype: 'textfield',
					fieldLabel: 'Contact Person',
					name: 'pson1',
					labelWidth:110,
		            width: 460
                }, {
					
                }]
                }],
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.numberDiscount, this.numberLimit]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.numberMin, this.numberMax]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboPay, this.numberCredit,{
						xtype: 'displayfield',
						margin: '0 0 0 5',
						width:25,
						value: 'Days'
					}]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboTax,this.numberVat]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{    	
					xtype: 'textfield',
					fieldLabel: 'Tax ID',
					name: 'taxid',
		            allowBlank: false,
		            emptyText: 'xxxxxxxxxxxxx',
		            maskRe: /[\d\-]/,
		            regex: /^\d{13}$/,
		            width: 290
                }, this.comboQStatus]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.trigGlno,{
						xtype: 'displayfield',
						name: 'sgtxt',
						margins: '0 0 0 6',
						width:286
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
					xtype: 'textarea',
					fieldLabel: 'Text Note',
					name: 'note1',
					allowBlank: true,
					width:470
                }]
            }]
        }]
              
/*---End Form--------------------------*/	
}];

//---event triger----------------------------------------------------------------	
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
							_this.getForm().findField('sgtxt').setValue(r.data.sgtxt);
						}else{
							o.markInvalid('Could not find GL Account : '+o.getValue());
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
			_this.glnoDialog.show();
		};	
		
		this.comboTax.on('select', this.selectTax, this);

		return this.callParent(arguments);
	},

/*(5)---Call Function-------------------------------*/	
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'vendor/load'
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
	
	reset: function(){
		this.getForm().reset();

		// default status = wait for approve
		this.comboQStatus.setValue('01');
	},
	
	remove : function(lifnr){
		var _this=this;
		this.getForm().load({
			params: { lifnr: lifnr },
			url:__site_url+'vendor/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	// Tax Value
	selectTax: function(combo, record, index){
		var _this=this;
		if(combo.getValue()=='03' || combo.getValue()=='04'){
			this.numberVat.setValue(0);
			this.numberVat.disable();
		}else{this.numberVat.enable();}
	}
});
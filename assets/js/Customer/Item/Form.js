Ext.define('Account.Customer.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'customer/save',
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

/*(1)---ComboBox-------------------------------*/
/*---ComboBox Price Level----------------------------*/
var myStorecomboPleve = Ext.create('Ext.data.Store', {
    fields: ['idPleve', 'name'],
    data : [
        {"idPleve":"01", "name":"Level 1"},
        {"idPleve":"02", "name":"Level 2"},
        {"idPleve":"03", "name":"Level 3"}
        //...
    ]
});

this.comboPleve2 = Ext.create('Ext.form.ComboBox', {
    fieldLabel: 'Price Level',
	name: 'pleve',
	triggerAction : 'all',
	clearFilterOnReset: true,
	emptyText: '-- Select Level --',
	//labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:55px;',
    margin: '0 0 0 56',
    store: myStorecomboPleve,
    labelAlign: 'right',
    queryMode: 'local',
    displayField: 'name',
    valueField: 'idPleve'
});

/*---ComboBox Tax Type----------------------------*/
		this.comboTaxnr = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Vat Type',
			name: 'taxnr',
			width:290,
			labelWidth: 105,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select Type --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_taxcombo',
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

//---Create Selection--------------------------------------------
        this.distrDialog = Ext.create('Account.SDistrict.MainWindow');

		this.trigDistr = Ext.create('Ext.form.field.Trigger', {
			name: 'distx',
			fieldLabel: 'Province',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelWidth:93,
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
							//o.setValue(r.data.ktype);
							_this.trigDistr.setValue(record.data.distx);
							//_this.getForm().findField('distr').setValue(record.data.distr);

						}else{
							o.markInvalid('Could not find Province : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.distrDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDistr.setValue(record.data.distx);
			//_this.getForm().findField('distr').setValue(record.data.distr);

			grid.getSelectionModel().deselectAll();
			_this.distrDialog.hide();
		});

		this.trigDistr.onTriggerClick = function(){
			_this.distrDialog.show();
		};

//---Create Selection--------------------------------------------
        this.distrDialog2 = Ext.create('Account.SDistrict.MainWindow');

		this.trigDistr2 = Ext.create('Ext.form.field.Trigger', {
			name: 'dis02',
			fieldLabel: 'Province',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelWidth:93,
			width:290,
		});
//---event triger----------------------------------------------------------------
		// event trigDis02//
		this.trigDistr2.on('keyup',function(o, e){
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
							//o.setValue(r.data.ktype);
							_this.trigDistr2.setValue(record.data.distx);
							//_this.getForm().findField('dis02').setValue(record.data.distx);

						}else{
							o.markInvalid('Could not find Province : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.distrDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDistr2.setValue(record.data.distx);
			//_this.getForm().findField('dis02').setValue(record.data.distx);

			grid.getSelectionModel().deselectAll();
			_this.distrDialog2.hide();
		});

		this.trigDistr2.onTriggerClick = function(){
			_this.distrDialog2.show();
		};
//---Create Selection--------------------------------------------
        this.ktypDialog = Ext.create('Account.Customertype.Window');

		this.trigKtyp = Ext.create('Ext.form.field.Trigger', {
			name: 'custx',
			fieldLabel: 'Customer Type',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			width:290,
		});
//---event triger----------------------------------------------------------------
		// event trigKtyp//
		this.trigKtyp.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'customertype/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							//o.setValue(r.data.ktype);
							_this.trigKtyp.setValue(r.data.custx);
							_this.getForm().findField('ktype').setValue(r.data.ktype);
							_this.getForm().findField('saknr').setValue(r.data.saknr);
							_this.getForm().findField('sgtxt').setValue(r.data.sgtxt);

						}else{
							o.markInvalid('Could not find customer type : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.ktypDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigKtyp.setValue(record.data.custx);
			_this.getForm().findField('ktype').setValue(record.data.ktype);
			_this.getForm().findField('saknr').setValue(record.data.saknr);
			_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

			grid.getSelectionModel().deselectAll();
			_this.ktypDialog.hide();
		});

		this.trigKtyp.onTriggerClick = function(){
			_this.ktypDialog.grid.load();
			_this.ktypDialog.show();
		};

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

         this.numberLimit = Ext.create('Ext.ux.form.NumericField', {
            //xtype: 'numberfield',
			fieldLabel: 'Credit Limit Amt',
			name: 'apamt',
			//labelAlign: 'right',
			hideTrigger:false,
			allowBlank: false,
			width:290
         });

         this.numberVat = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Vat Value',
			name: 'vat01',
			labelAlign: 'right',
			hideTrigger:false,
			align: 'right',
			margin: '0 0 0 56'
         });
//---Create Selection--------------------------------------------
        this.glnoDialog = Ext.create('Account.GL.MainWindow');

		this.trigGlno = Ext.create('Ext.form.field.Trigger', {
			name: 'saknr',
			fieldLabel: 'GL Account',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			width:290,
		});
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
							_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

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

		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			readOnly: !UMS.CAN.APPROVE('CS'),
			fieldLabel: 'Customer Status',
			name : 'statu',
			labelAlign: 'right',
			//width: 286,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			margin: '0 0 0 54',
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
			emptyText: '-- Please Select Payments --',
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

/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id',
		},{
			xtype: 'hidden',
			name: 'ktype'
		},{
			//xtype: 'hidden',
			//name: 'distr'
		//},{

/*(3)---Start Form-------------------------------*/
/*---Customer Head fieldset 1 --------------------------*/
/*------------------------------------------------------*/

		items: [{
            xtype: 'container',
            layout: 'anchor',
            margin: '15',
            items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
		 			items :[this.trigKtyp,{
                }, {
                    xtype:'displayfield',
                    fieldLabel: 'Customer Code',
                    name: 'kunnr',
					labelAlign: 'right',
					readOnly: true,
					//disabled: true,
					width:150,
            		margin: '0 0 0 64',
					value: 'XXXXX',
					labelStyle: 'font-weight:bold',
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Customer Name',
					name: 'name1',
					allowBlank: false,
					width:460,
                }]
            },{
xtype:'fieldset',
title: 'Address Bill To',
items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
					xtype: 'textfield',
					fieldLabel: 'Address',
					name: 'adr01',
					labelWidth: 93,
					width:450,
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.trigDistr,{
                }, {
					xtype: 'textfield',
					fieldLabel: 'Country',
		            name: 'cunt1',
		            labelAlign: 'right',
            		margin: '0 0 0 48',
                }]

            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
                	xtype: 'textfield',
					fieldLabel: 'Post Code',
		            name: 'pstlz',
		            emptyText: 'xxxxx',
		            maskRe: /[\d\-]/,
		            regex: /^\d{5}$/,
		            regexText: 'Must be in the format xxxxx',
					labelWidth: 93,
		            width: 290,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Email',
					name: 'email',
					labelAlign: 'right',
            		margin: '0 0 0 50',
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
		            labelWidth: 93,
		            width: 290,
		            emptyText: 'xxx-xxxxxxx',
		            maskRe: /[\d\-]/,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Fax Number',
		            name: 'telfx',
		            labelAlign: 'right',
		            maskRe: /[\d\-]/,
		            //regexText: 'Must be in the format xxx-xxxxxx',
            		margin: '0 0 0 50',
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
					labelWidth: 93,
		            width: 450,
                }, {
					xtype: 'displayfield',
            		margin: '0 0 0 5',
            }]
}],
            },{
xtype:'fieldset',
title: 'Address Ship To',
items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
					xtype: 'textfield',
					fieldLabel: 'Address',
					name: 'adr02',
					labelWidth: 93,
					width:450,
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.trigDistr2,{
                }, {
					xtype: 'textfield',
					fieldLabel: 'Country',
		            name: 'cunt2',
		            labelAlign: 'right',
            		margin: '0 0 0 48',
                }]

            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
                	xtype: 'textfield',
					fieldLabel: 'Post Code',
		            name: 'pst02',
		            emptyText: 'xxxxx',
		            maskRe: /[\d\-]/,
		            regex: /^\d{5}$/,
		            regexText: 'Must be in the format xxxxx',
					labelWidth: 93,
		            width: 290,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Email',
					name: 'emai2',
					labelAlign: 'right',
            		margin: '0 0 0 50',
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Phone Number',
		            name: 'tel02',
		            labelWidth: 93,
		            width: 290,
		            emptyText: 'xxx-xxxxxxx',
		            maskRe: /[\d\-]/,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Fax Number',
		            name: 'telf02',
		            labelAlign: 'right',
		            maskRe: /[\d\-]/,
		            //regex: /^\d{2}-\d{6}$/,
		            //regexText: 'Must be in the format xxx-xxxxxx',
            		margin: '0 0 0 50',
                }]

            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
				margin: '0 0 5 0',
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Contact Person',
					name: 'pson2',
					labelWidth: 93,
		            width: 450,
                }, {
					xtype: 'displayfield',
            		margin: '0 0 0 5',
            }]
            }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboPay,
					    this.numberCredit,
					{
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
                items :[this.numberLimit,this.comboPleve2]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboTaxnr,this.numberVat]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.numberMin,this.numberMax]
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
		            //regexText: 'Must be in the format xxxxx',
		            width: 290
               	},{
                }],
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.trigGlno,{
						xtype: 'displayfield',
						name: 'sgtxt',
						margins: '0 0 0 6',
						width:286,
						allowBlank: false
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
					rows:2,
					width:290
                },this.comboQStatus]
            }]
        }]
//---address01 02
//---end form------------------------------------------------------
}]; //end form

/*(4)---Buttons-------------------------------*/
		this.buttons = [{
			text: 'Save',
			disabled: !UMS.CAN.EDIT('CS'),
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
		
	    this.comboTaxnr.on('select', this.selectTax, this);

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
			url:__site_url+'customer/load'

		});
	},
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		//this.gridItem.load({ vbeln: 0 });
		//this.gridPayment.load({ vbeln: 0 });
		//this.gridPrice.load();

		// default status = wait for approve
		this.comboQStatus.setValue('01');
	},
	remove : function(kunnr){
		var _this=this;
		this.getForm().load({
			params: { kunnr: kunnr },
			url:__site_url+'customer/remove',
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
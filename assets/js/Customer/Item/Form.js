Ext.define('Account.Customer.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'customer2/save',
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
	width:293,
	labelWidth: 160,
	//editable: false,
	triggerAction : 'all',
	clearFilterOnReset: true,
	emptyText: '-- Please select Level --',
	labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:55px;',	
    store: myStorecomboPleve,
    queryMode: 'local',
    displayField: 'name',
    valueField: 'idPleve'
    //renderTo: Ext.getBody()
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
					url: __site_url+'customer2/loads_combo/tax1/taxnr/taxtx',  //loads_tycombo($tb,$pk,$like)
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
			fieldLabel: 'District',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
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
							_this.getForm().findField('distr').setValue(record.data.distr);

						}else{
							o.markInvalid('Could not find District : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.distrDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDistr.setValue(record.data.distx);
			_this.getForm().findField('distr').setValue(record.data.distr);

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
			fieldLabel: 'District',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
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
							_this.getForm().findField('dis02').setValue(record.data.distx);

						}else{
							o.markInvalid('Could not find District : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.distrDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigDistr2.setValue(record.data.distx);
			_this.getForm().findField('dis02').setValue(record.data.distx);

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
			fieldLabel: 'Type',
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
					url: __site_url+'Ktyp/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							//o.setValue(r.data.ktype);
							_this.trigKtyp.setValue(record.data.custx);
							_this.getForm().findField('ktype').setValue(record.data.ktype);
							_this.getForm().findField('saknr').setValue(record.data.saknr);
							_this.getForm().findField('sgtxt_gl').setValue(record.data.sgtxt);

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
			_this.getForm().findField('sgtxt_gl').setValue(record.data.sgtxt);

			grid.getSelectionModel().deselectAll();
			_this.ktypDialog.hide();
		});

		this.trigKtyp.onTriggerClick = function(){
			_this.ktypDialog.show();
		};	

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
					url: __site_url+'sglAccount/loads',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							//o.setValue(r.data.ktype);
							//glno/saknr/sgtxt'
							_this.trigGlno.setValue(record.data.sgtxt);
							//_this.getForm().findField('ktype').setValue(record.data.ktype);
							_this.getForm().findField('saknr').setValue(record.data.saknr);
							_this.getForm().findField('sgtxt_gl').setValue(record.data.sgtxt);

						}else{
							o.markInvalid('Could not find GL Account : '+o.getValue());
						}
					}
				});
			}
		}, this);

			_this.glnoDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGlno.setValue(record.data.saknr);
			_this.getForm().findField('sgtxt_gl').setValue(record.data.sgtxt);
			//_this.getForm().findField('ktype').setValue(record.data.ktype);
			//_this.getForm().findField('saknr').setValue(record.data.saknr);

			grid.getSelectionModel().deselectAll();
			_this.glnoDialog.hide();
		});

		this.trigGlno.onTriggerClick = function(){
			//alert(_this.comboVtype.getValue());
			_this.glnoDialog.show();
		};		
				
/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id',
		},{
			xtype: 'hidden',
			name: 'ktype'
		},{
			xtype: 'hidden',
			name: 'distr'
		},{
			
/*(3)---Start Form-------------------------------*/	
/*---Customer Head fieldset 1 --------------------------*/
/*------------------------------------------------------*/

		items: [{
            xtype: 'container',
            anchor: '100%',
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
					anchor:'95%',
					width:150,
            		margin: '0 0 0 90',
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
					anchor:'100%',
					width:583,
                }]
            },{
xtype:'fieldset',
title: 'Address Bill',
items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
					xtype: 'textarea',
					fieldLabel: 'Address',
					name: 'adr01',
					//anchor:'95%',
					rows:1,
					allowBlank: true,
					width:583,
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
		            maskRe: /[\d\-]/,
		            regex: /^\d{5}$/,
		            regexText: 'Must be in the format xxxxx',
            		margin: '0 0 0 54',
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
		            width: 290,
		            emptyText: 'xxx-xxx-xxxx',
		            maskRe: /[\d\-]/,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Fax Number',
		            name: 'telfx',
		            //emptyText: 'xx-xxxxxx',
		            maskRe: /[\d\-]/,
		            //regex: /^\d{2}-\d{6}$/,
		            regexText: 'Must be in the format xxx-xxxxxx',
            		margin: '0 0 0 56',
                }]
                
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
				margin: '0 0 5 0',
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Email',
					name: 'email',
		            width: 290,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Contact Person',
					name: 'pson1',
            		margin: '0 0 0 56',
                }]
}],                
            },{
xtype:'fieldset',
title: 'Address Ship',
items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
					xtype: 'textarea',
					fieldLabel: 'Address',
					name: 'adr02',
					//anchor:'95%',
					rows:1,
					allowBlank: true,
					width:583,
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.trigDistr2,{
                }, {
					xtype: 'textfield',
					fieldLabel: 'Post Code',
		            name: 'pst02',
		            emptyText: 'xxxxx',
		            maskRe: /[\d\-]/,
		            regex: /^\d{5}$/,
		            regexText: 'Must be in the format xxxxx',
            		margin: '0 0 0 54',
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
		            width: 290,
		            emptyText: 'xxx-xxx-xxxx',
		            maskRe: /[\d\-]/,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Fax Number',
		            name: 'telf02',
		            //emptyText: 'xx-xxxxxx',
		            maskRe: /[\d\-]/,
		            //regex: /^\d{2}-\d{6}$/,
		            regexText: 'Must be in the format xxx-xxxxxx',
            		margin: '0 0 0 56',
                }]
                
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
				margin: '0 0 5 0',
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Email',
					name: 'emai2',
		            width: 290,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Contact Person',
					name: 'pson2',
            		margin: '0 0 0 56',
                }]
}],                
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
                	
					xtype: 'textfield',
					fieldLabel: 'Discount',
		            name: 'disct',
		            width: 290,
		            maskRe: /[\d\-]/,
		            regexText: 'Must be in the format Number',
                }, {
					xtype: 'numberfield',
					fieldLabel: 'Crdit',
		            name: 'crdit',
		            maskRe: /[\d\-]/,
            		margin: '0 0 0 56',
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Tax ID',
					name: 'taxid',
		            maskRe: /[\d]/,
		            width: 290,
               	},this.comboPleve2,{
                }],
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboTaxnr,{
					xtype: 'textfield',
					fieldLabel: 'Approve Amount',
		            name: 'apamt',
		            maskRe: /[\d\.]/,
            		margin: '0 0 0 56',
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
					xtype: 'textfield',
					fieldLabel: 'Beginning Amount',
		            name: 'begin',
		            maskRe: /[\d\.]/,
		            width: 290,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Ending Amount',
		            name: 'endin',
		            maskRe: /[\d\.]/,
            		margin: '0 0 0 56',
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.trigGlno,{
						xtype: 'displayfield',
						//fieldLabel: '',
						//flex: 3,
						//value: '<span style="color:green;"></span>'
						name: 'sgtxt_gl',
						//labelAlign: 'l',
						margins: '0 0 0 6',
						width:286,
						//emptyText: 'Customer',
						allowBlank: true,
						//value:'test'
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
					xtype: 'textarea',
					fieldLabel: 'Text Note',
					name: 'sgtxt',
					rows:1,
					anchor:'95%',
					allowBlank: true,
					width:583,
                }]
            }]
        }]
//---address01 02
//---end form------------------------------------------------------                
}] //end form

/*(4)---Buttons-------------------------------*/
		this.buttons = [{
			text: 'Save',
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
			url:__site_url+'customer2/load'
			
		});
	},
	remove : function(kunnr){
		var _this=this;
		this.getForm().load({
			params: { kunnr: kunnr },
			url:__site_url+'customer2/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
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

/*(1)---ComboBox-------------------------------*/
/*---ComboBox Type-------------------------------*/
		this.comboVtype = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Type',
			name: 'vtype',
			width:290,
			//labelWidth: 120,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'vendor/loads_combo/vtyp/vtype/ventx',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'vtype'
					}
				},
				fields: [
					'vtype',
					'ventx'
				],
				remoteSort: true,
				sorters: 'vtype ASC'
			}),
			queryMode: 'remote',
			displayField: 'ventx',
			valueField: 'vtype'
		});
/*---ComboBox Price Level----------------------------*/
		this.comboPleve = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Price Level',
			name: 'pleve',
			width:307,
			labelWidth: 176,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:55px;',				    
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'vendor/loads_combo/plev/pleve/cost',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'pleve'
					}
				},
				fields: [
					'pleve',
					'cost'
				],
				remoteSort: true,
				sorters: 'pleve ASC'
			}),
			queryMode: 'remote',
			displayField: 'cost',
			valueField: 'pleve'
		});
/*---ComboBox District----------------------------*/
		
		this.comboDistr = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'District',
			name: 'distx',
			width:290,
			labelWidth: 120,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',  
					url: __site_url+'vendor/loads_combo/dist/distr/distx',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'distr'
					}
				},
				fields: [
					'distr',
					'distx'
				],
				remoteSort: true,
				sorters: 'distr ASC'
			}),
			queryMode: 'remote',
			displayField: 'distx',
			valueField: 'distx'
		});

/*---ComboBox GL Account----------------------------*/
		this.comboSaknr = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'GL Account',
			name: 'saknr',
			width:290,
			labelWidth: 120,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'vendor/loads_combo/glno/saknr/sgtxt',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'saknr'
					}
				},
				fields: [
					'saknr',
					'sgtxt'
				],
				remoteSort: true,
				sorters: 'saknr ASC'
			}),
			queryMode: 'remote',
			displayField: 'sgtxt',
			valueField: 'saknr'
		});

/*---ComboBox Tax Type----------------------------*/
		this.comboTaxnr = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Tax Type',
			name: 'taxnr',
			width:290,
			labelWidth: 120,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
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

/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id'
		},{
			

/*(3)---Start Form-------------------------------*/	
/*---Vendor Head fieldset 1 --------------------------*/
/*------------------------------------------------------*/


		items: [{
            xtype: 'container',
            anchor: '100%',
            layout: 'anchor',
            margin: '10',
            items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
                    xtype:'textfield',
					fieldLabel: 'Vendor Code',
					name: 'lifnr',
                    emptyText: 'XXXXX',
					readOnly: true,
					//disabled: true,
					anchor:'95%',
					width:200,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Vendor Name',
					name: 'name1',
					allowBlank: false,
					anchor:'100%',
					width:350,
            		margin: '0 0 0 50',
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboVtype,{
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items: [{
					xtype: 'textarea',
					fieldLabel: 'Address',
					name: 'adr01',
					anchor:'95%',
					allowBlank: true,
					width:600,
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboDistr,{
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
					fieldLabel: 'Fax Number',
		            name: 'telfx',
		            width: 290,
		            emptyText: 'xxx-xxxxxx',
		            maskRe: /[\d\-]/,
		            regex: /^\d{3}-\d{6}$/,
		            regexText: 'Must be in the format xxx-xxxxxx'
                }, {
                	
					xtype: 'textfield',
					fieldLabel: 'Discount',
		            name: 'disct',
		            maskRe: /[\d\-]/,
		            regexText: 'Must be in the format Number',
            		margin: '0 0 0 56',
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
		            width: 290,
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
		            width: 290,
                }, {
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
					fieldLabel: 'Tax ID',
					name: 'taxid',
		            maskRe: /[\d]/,
		            width: 290,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Beginning Amount',
		            name: 'begin',
		            maskRe: /[\d\.]/,
            		margin: '0 0 0 56',
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboSaknr,{
                }, {
					xtype: 'textfield',
					fieldLabel: 'Ending Amount',
		            name: 'endin',
		            maskRe: /[\d\.]/,
            		margin: '0 0 0 54',
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[this.comboTaxnr,{
				},{
		            xtype: 'checkboxfield',
		            name: 'retax',
		            fieldLabel: '',
                	inputValue: '1',
                	//checked: true,
		            boxLabel: 'ขอคืนภาษี',	
            		margin: '0 0 0 54',
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
					anchor:'95%',
					allowBlank: true,
					width:600,
                }]
            }]
        }]
              

/*---End Form--------------------------*/	
}]
/*(4)---Buttons-------------------------------*/
		this.buttons = [{
			text: 'Cancel',
			handler: function() {
				this.up('form').getForm().reset();
				this.up('window').hide();
			}
		}, {
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
		}];

		return this.callParent(arguments);
	},

/*(5)---Call Function-------------------------------*/	
	load : function(lifnr){
		this.getForm().load({
			params: { lifnr: lifnr },
			url:__site_url+'vendor/load'
		});
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
	}
});
Ext.define('Account.PR2.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'pr2/save',
			/*
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
				labelWidth: 100,
				width:300,
				labelStyle: 'font-weight:bold'
			}
			*/
			border: false,
			bodyPadding: 5,
			fieldDefaults: {
				labelAlign: 'left',
				labelWidth: 100,
				//width:300,
				labelStyle: 'font-weight:normal'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.hdnPrItem = Ext.create('Ext.form.Hidden', {
			name: 'ebpo'
		});
/*---ComboBox PR Status-------------------------------*/
		this.comboApov = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Choose Status',
			//hiddenName : 'mat',
			name: 'statu',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select data --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'pr2/loads_combo/apov/statu/statx',  //loads_tycombo($tb,$pk,$like)
					//url: __site_url+'pr2/loads_combo',
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

/*---ComboBox Vendor-------------------------------*/
		this.comboLifnr = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Vendor Code',
			name: 'lifnr',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',	    
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'pr2/loads_combo/lfa1/lifnr/lifnr',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'lifnr'
					}
				},
				fields: [
					'lifnr',
					'lifnr'
				],
				remoteSort: true,
				sorters: 'lifnr ASC'
			}),
			queryMode: 'remote',
			displayField: 'lifnr',
			valueField: 'lifnr'
		});
/*---ComboBox Tax Type----------------------------*/
		this.comboTaxnr = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Tax Type',
			name: 'taxnr',
			//width:185,
			//labelWidth: 80,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'pr2/loads_combo/tax1/taxnr/taxtx',  //loads_tycombo($tb,$pk,$like)
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
		
/*---hidden field-------------------------------*/
		this.items = [
			this.hdnPrItem,
		{
			xtype: 'hidden',
			name: 'id'
		},{
/*----------------------------------*/		

/*---end hidden field-------------------------------*/	


		xtype: 'fieldset',
		title: 'Header Data',

		items: [{
            xtype: 'container',
            anchor: '100%',
            layout: 'hbox',
            margin: '10',
            items:[{
                xtype: 'container',
                flex: 0,
                layout: 'anchor',
                items :[ this.comboLifnr,{
                }, {
					xtype: 'textarea',
					fieldLabel: 'Address',
					name: 'adr01',
					anchor:'95%',
					width: 455, 
					rows:4,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Reference No',
					name: 'refnr',
					anchor:'95%',
					//margin: '20 0 0 0',
                }]
            },{
                xtype: 'container',
                flex: 0,
                layout: 'anchor',
            	margin: '0 0 0 70',
                items: [{
					xtype: 'textfield',
					fieldLabel: 'PR No',
					name: 'purnr',
					anchor:'100%',
					emptyText: 'PRxxxx-xxxx',
                }, {
					xtype: 'datefield',
					fieldLabel: 'PR Date',
					name: 'bldat',
					anchor:'100%',
                }, {
					xtype: 'datefield',
					fieldLabel: 'Delivery Date',
					name: 'lfdat',
					anchor:'100%',
                }, {
					xtype: 'numberfield',
					fieldLabel: 'Credit',
					name: 'crdat',
					anchor:'100%', 
                }, this.comboTaxnr,{
                }]
            }]
        }]
	             
//---end form------------------------------------------------------                
}] //end form
	
/*--------------------------------------------------*/
/*----------------------------------*/			
/*
			xtype: 'textfield',
			fieldLabel: 'PR No',
			name: 'purnr',
			allowBlank: false
		},
		this.comboApov,
		this.comboLifnr,
		{
			xtype: 'datefield',
			fieldLabel: 'PR Date',
			name: 'bldat',
			allowBlank: false,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
		}];
/*----------------------------------*/
		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'pr2/load'
		});
	},
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
			url:__site_url+'pr2/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
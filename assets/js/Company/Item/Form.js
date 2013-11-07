Ext.define('Account.Company.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'company/save',
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
        this.currencyDialog = Ext.create('Account.SCurrency.MainWindow');
	
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Company Status',
			name : 'statu',
			labelWidth:110,
			width: 290,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
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
		
/*---ComboBox Language----------------------------*/	
var myStorecomboLang = Ext.create('Ext.data.Store', {
    fields: ['idLang', 'name'],
    data : [
        {"idLang":"01", "name":"TH"},
        {"idLang":"02", "name":"EN"}
        //...
    ]
});

this.comboLang = Ext.create('Ext.form.ComboBox', {
    fieldLabel: 'Language',
	name: 'langu',
	triggerAction : 'all',
	clearFilterOnReset: true,
	emptyText: '-- Please select Language --',	
    labelWidth:110,
    width:290,
    store: myStorecomboLang,
    queryMode: 'local',
    displayField: 'name',
    valueField: 'idLang'
});

var myStorecomboCO = Ext.create('Ext.data.Store', {
    fields: ['idCO', 'name'],
    data : [
        {"idCO":"01", "name":"First Come First Out"},
        {"idCO":"02", "name":"Average"}
        //...
    ]
});

this.comboCO = Ext.create('Ext.form.ComboBox', {
    fieldLabel: 'Cost of Goods Sold',
	name: 'cotyp',
	triggerAction : 'all',
	clearFilterOnReset: true,
	emptyText: '-- Please select Cost --',	
    labelWidth:110,
    width:290,
    store: myStorecomboCO,
    queryMode: 'local',
    displayField: 'name',
    valueField: 'idCO'
});

var myStorecomboPost = Ext.create('Ext.data.Store', {
    fields: ['idPost', 'name'],
    data : [
        {"idPost":"01", "name":"Periodic"},
        {"idPost":"02", "name":"Perpetual"}
        //...
    ]
});

this.comboPost = Ext.create('Ext.form.ComboBox', {
    fieldLabel: 'Meditation',
	name: 'recty',
	triggerAction : 'all',
	clearFilterOnReset: true,
	emptyText: '-- Please select Post --',	
    labelWidth:110,
    width:290,
    store: myStorecomboPost,
    queryMode: 'local',
    displayField: 'name',
    valueField: 'idPost'
});

/*---ComboBox Vat Type----------------------------*/
		this.comboTax = Ext.create('Ext.form.ComboBox', {			
			fieldLabel: 'Vat Type',
			name: 'taxnr',
			width:290,
			labelWidth: 110,
			editable: false,
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

         this.numberVat = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Vat Value',
			name: 'vat01',
			labelWidth:110,
			width:290,
			hideTrigger:false
         });
         
         this.trigCurrency = Ext.create('Ext.form.field.Trigger', {
			name: 'ctype',
			fieldLabel: 'Currency',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			width: 290,
			labelWidth:110
		});
		
		this.trigDistr = Ext.create('Ext.form.field.Trigger', {
			name: 'distx',
			fieldLabel: 'Province',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			labelWidth:100,
			width:290
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
            layout: 'anchor',
            margin: '10',
            items:[{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                 items :[{
                }, {
                    xtype:'displayfield',
					fieldLabel: 'Company Code',
					name: 'comid',
                    emptyText: 'XXXXX',
					readOnly: true,
					width:200,
					labelWidth:110,
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
					fieldLabel: 'Company Name',
					name: 'name1',
					labelWidth:110,
					allowBlank: false,
					width:470
                }]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'hbox',
                padding:2,
                items :[{
					xtype: 'textfield',
					fieldLabel: 'English Name',
					name: 'name2',
					//allowBlank: false,
					labelWidth:110,
					width:470
                }]
            },{
            xtype:'fieldset',
            title: 'Address',
            items:[{
                
					xtype: 'textarea',
					fieldLabel: 'Address',
					name: 'adr01',
					labelWidth:100,
					width:460
            },this.trigDistr, 
            {
					xtype: 'textfield',
					fieldLabel: 'Post Code',
		            name: 'pstlz',
		            emptyText: 'xxxxx',
		            width: 290,
		            labelWidth:100,
		            maskRe: /[\d\-]/,
		            regex: /^\d{5}$/,
		            regexText: 'Must be in the format xxxxx'
            },{
					xtype: 'textfield',
					fieldLabel: 'Phone Number',
		            name: 'telf1',
		            labelWidth:100,
		            width: 290,
		            emptyText: 'xxx-xxxxxxx',
		            maskRe: /[\d\-]/,
                }, {
					xtype: 'textfield',
					fieldLabel: 'Fax Number',
		            name: 'telfx',
		            width: 290,
		            labelWidth:100
            },{
                    xtype: 'textfield',
					fieldLabel: 'Email',
					name: 'email',
					labelWidth:100,
		            width: 460
            },{
                	xtype: 'textfield',
					fieldLabel: 'Tax ID',
					name: 'taxid',
		            maskRe: /[\d]/,
		            labelWidth:100,
		            width: 290
                }, {
                	xtype: 'textfield',
					fieldLabel: 'Business Register',
					name: 'regno',
		            maskRe: /[\d]/,
		            labelWidth:100,
		            width: 290
            }]
        },this.comboCO, this.comboPost
         ,this.comboTax,this.numberVat
         ,this.trigCurrency,this.comboLang
         ,this.comboQStatus]
            //}] 
    }]
              
/*---End Form--------------------------*/	
}];

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
		
// event trigCurrency///
		this.trigCurrency.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'currency/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.ctype);

		                    //_this.gridItem.curValue = r.data.ctype;
						}else{
							o.markInvalid('Could not find currency code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.currencyDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCurrency.setValue(record.data.ctype);

		    //_this.gridItem.curValue = record.data.ctype;
			grid.getSelectionModel().deselectAll();
			_this.currencyDialog.hide();
		});

		this.trigCurrency.onTriggerClick = function(){
			_this.currencyDialog.show();
		};	

		return this.callParent(arguments);
	},

/*(5)---Call Function-------------------------------*/	
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'company/load'
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
			url:__site_url+'company/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
Ext.define('Account.Quotation.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'quotation/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 105
				//width:300,
				//labelStyle: 'font-weight:bold'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [{
			xtype:'fieldset',
            title: 'Header Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
     items:[{
// Project Code
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},{
			xtype: 'textfield',
			fieldLabel: 'Project Code',
			name: 'jobnr',
			//flex: 2,
			//anchor:'90%',
			labelAlign: 'top',
			width:350,
			allowBlank: false
		},{
			xtype: 'datefield',
			fieldLabel: 'Date',
			name: 'bldat',
			anchor:'90%',
			labelAlign: 'right',
			//width:450,
			allowBlank: true
		},{
			xtype: 'displayfield',
            //fieldLabel: 'jobtx',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		}]
// Customer Code
		},{
                xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'textfield',
			fieldLabel: 'Customer Code',
			name: 'kunnr',
			//flex: 2,
			//anchor:'90%',
			width:350,
			labelAlign: 'top',
			allowBlank: false
		},{
            xtype: 'textfield',
			fieldLabel: 'Terms:',
			name: 'ptype',
			anchor:'90%',
			labelAlign: 'right',
			//width:450,
			allowBlank: true
         
         },{
			xtype: 'displayfield',
            fieldLabel: '',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			labelAlign: 'top',
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		}]
// Address Bill&Ship
		},{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
			xtype: 'textarea',
			fieldLabel: 'Bill To',
			name: 'adr01',
			anchor:'90%',
			width:350,
			labelAlign: 'top',
			allowBlank: true
		},{
            xtype: 'textarea',
			fieldLabel: 'Ship To',
			name: 'adr01',
			anchor:'90%',
			width:350,
			labelAlign: 'right',
			labelAlign: 'top',
			margin: '0 0 0 110',
			allowBlank: true
         }]
// Sale Person         
         },{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
			xtype: 'textfield',
			fieldLabel: 'Sale Person',
			name: 'taxnr',
			anchor:'90%',
			width:350,
			allowBlank: true
		},{
            xtype: 'checkboxfield',
			//fieldLabel: 'Same as Billing To',
			//name: 'refnr',
			anchor:'90%',
			//labelAlign: 'right',
			//width:450,
			margin: '0 0 0 110',
			boxLabel: 'Same as Bill To',
			//allowBlank: true
         
         }]
// Tax&Ref no.
         },{
         xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
			xtype: 'textfield',
			fieldLabel: 'Tax',
			name: 'taxnr',
			anchor:'90%',
			width:350,
			allowBlank: true
		},{
            xtype: 'textfield',
			fieldLabel: 'Ref.no:',
			name: 'refnr',
			anchor:'90%',
			labelAlign: 'right',
			//width:450,
			allowBlank: true
         
         }]
         }]

		//}]
		}];

		return this.callParent(arguments);
	},
	load : function(id){
		this.getForm().load({
			params: { id: id },
			url:__site_url+'project/load'
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
			url:__site_url+'project/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	}
});
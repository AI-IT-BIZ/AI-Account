Ext.define('Account.Quotation.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'quotation/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
				msgTarget: 'qtip',//'side',
				labelWidth: 105,
				//width:300,
				labelStyle: 'font-weight:bold'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [{
			xtype:'fieldset',
            title: 'Header Data',
            //collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
     items:[{
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
			width:300,
			allowBlank: false
		},{
			xtype: 'displayfield',
            fieldLabel: '',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		}]
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
			width:300,
			allowBlank: false
		},{
			xtype: 'displayfield',
            fieldLabel: '',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		}]
		},{
			xtype: 'container',
                    layout: 'hbox',
                    defaultType: 'textfield',
                    margin: '0 0 5 0',
   items: [{
			xtype: 'textarea',
			fieldLabel: 'Address',
			name: 'adr01',
			anchor:'90%',
			width:450,
			allowBlank: true
		},{
            fieldLabel: 'Phone Number',
            labelWidth: 110,
            name: 'telf1',
            width: 200,
            emptyText: 'xxx-xxx-xxxx',
            maskRe: /[\d\-]/,
            regex: /^\d{3}-\d{3}-\d{4}$/,
            regexText: 'Must be in the format xxx-xxx-xxxx'
         
         }]
         }]
        },{
         xtype: 'fieldset',
         title: 'Project Detail',
         defaultType: 'textfield',
         layout: 'anchor',
         defaults: {
                  anchor: '100%'
                },
     items: [{
     	xtype: 'container',
        layout: 'hbox',
        margin: '0 0 5 0',
     items: [{
			xtype: 'textfield',
			fieldLabel: 'Project No',
			name: 'jobnr',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: false
		},{
			xtype: 'datefield',
			fieldLabel: 'Project Date',
			name: 'bldat',
			anchor:'100%',
			labelWidth: 100,
			allowBlank: false
	    }]
	   },{
			xtype: 'textfield',
			fieldLabel: 'Project Name',
			name: 'jobtx',
			width: 550,
			labelWidth: 90,
			allowBlank: false
	
	    },{
			xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'textfield',
			fieldLabel: 'Project Owner',
			name: 'salnr',
			//flex: 2,
			//anchor:'90%',
			//width:300,
			allowBlank: false
		},{
			xtype: 'displayfield',
            fieldLabel: '',
            //flex: 3,
            //value: '<span style="color:green;"></span>'
			name: 'name1',
			margins: '0 0 0 6',
            //emptyText: 'Customer',
            allowBlank: true
		}]
	
	    },{
	    	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [{
			xtype: 'textfield',
			fieldLabel: 'Project Amt',
			name: 'pramt',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
	    },{
			xtype: 'textfield',
			fieldLabel: 'Estimate Cost',
			name: 'esamt',
			anchor:'100%',
			labelWidth: 100,
			allowBlank: true
	    }]
	   },{
	   	xtype: 'container',
                    layout: 'hbox',
                    margin: '0 0 5 0',
     items: [{
			xtype: 'datefield',
			fieldLabel: 'Start Date',
			name: 'stdat',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
	    },{
			xtype: 'datefield',
			fieldLabel: 'End Date',
			name: 'endat',
			anchor:'100%',
			labelWidth: 100,
			allowBlank: true
	    },{
			xtype: 'displayfield',
			fieldLabel: '',
			name: 'datam',
			anchor:'100%',
			Width: 30,
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
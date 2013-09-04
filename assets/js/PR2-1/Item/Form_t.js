Ext.define('Account.PR2.Item.Form_t', {
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
			//bodyPadding: 10,
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

/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id'
		},{
			
		
		items: [{
            xtype: 'container',
            anchor: '100%',
            layout: 'hbox',
            margin: '20',
            items:[{
                xtype: 'container',
                flex: 0,
                layout: 'anchor',
            	margin: '60 0 0 0',
                items: [{
					xtype: 'textarea',
					fieldLabel: 'Comment',
					name: 'sgtxt',
					anchor:'100%',
					width: 455, 
					rows:3,
					allowBlank: true
                }]
            },{
                xtype: 'container',
                flex: 0,
                layout: 'anchor',
            	margin: '0 0 0 70',
                items: [{
		            xtype: 'container',
		            anchor: '100%',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [{
						xtype: 'textfield',
						fieldLabel: 'Total',
						name: 'beamt',
						labelWidth: 150,
						width:240,
                	}]
                },{
		            xtype: 'container',
		            anchor: '100%',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [{
						xtype: 'textfield',
						fieldLabel: 'Discount',
						name: 'dismt',
						labelWidth: 80,
						width:150,
					},{
			            xtype: 'textfield',
						name: '',
						width:85,
						allowBlank: true,
						margin: '0 0 0 5',
                	}]
             	},{
		            xtype: 'container',
		            anchor: '100%',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [{
			         	xtype: 'textfield',
						fieldLabel: 'After Discount',
						name: '',
						labelWidth: 150,
						width:240,
                	}]
             	},{
		            xtype: 'container',
		            anchor: '100%',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [{
						xtype: 'textfield',
						fieldLabel: 'Tax',
						name: 'taxpr',
						labelWidth: 80,
						width:120,
					},{
						xtype: 'displayfield',
						width:10,
						value: '%',
					},{
			            xtype: 'textfield',
						name: '',
						margin: '0 0 0 25',
						width:85,
                	}]
             	},{
		            xtype: 'container',
		            anchor: '100%',
		            layout: 'hbox',
            		margin: '0 0 5 0',
                	items: [{
			         	xtype: 'textfield',
						fieldLabel: 'Net Amount',
						name: 'netwr',
						labelWidth: 150,
						width:240,
						labelStyle: 'font-weight:bold',
                	}]
                }]
            }]
        }],
//---end form------------------------------------------------------  
}];

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
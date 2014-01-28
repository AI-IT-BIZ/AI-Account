Ext.define('Account.RIncome.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 105
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [{
// Doc Date
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Selection Period',
			name: 'start_date',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
			},{
			xtype: 'displayfield',
		    value: 'To',
		    width:40,
		    margins: '0 0 0 25'
		   	},{
			xtype: 'datefield',
			name: 'end_date',
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			}]
		}
////////////////////////////////////////////////		
		];
		return this.callParent(arguments);
	},

	});

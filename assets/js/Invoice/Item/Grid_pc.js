Ext.define('Account.Invoice.Item.Grid_pc', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;
        
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"quotation/loads_conp_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'conty'
				}
			},
			fields: [
				'conty',
			    'contx',
			    'vtamt',
			    'ttamt'
			],
			remoteSort: true,
			sorters: ['conty ASC']
		});

		this.columns = [{
			text: "Condition type",
			width: 180,
			dataIndex: 'contx',
			sortable: true
			},
			{text: "Amount",
			xtype: 'numbercolumn',
			width: 100,
			xtype: 'numbercolumn',
			dataIndex: 'vtamt',
			sortable: true,
			align: 'right'
			},
			{text: "Condition Amount",
			xtype: 'numbercolumn',
			width: 120,
			dataIndex: 'ttamt',
			align: 'right'
			}
		];

		return this.callParent(arguments);
	},

	load: function(options){
		this.store.load({
			params: options
		});
	}
});
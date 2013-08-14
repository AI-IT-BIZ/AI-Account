Ext.define('Account.Invoice.Item.Grid_i', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"Invoice/loads_it",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vbeln'
				}
			},
			fields: [
				'vbelp',
				'matnr',
				'menge',
				'meins',
				'unitp',
				'dismt',
				'pramt',
				'ctype'
			],
			remoteSort: true,
			sorters: ['vbeln ASC']
		});

		this.columns = [
		    {text: "Items", width: 70, dataIndex: 'vbelp', sortable: true},
			{text: "Description", width: 250, dataIndex: 'matnr', sortable: true},
		    //{text: "Description", width: 200, dataIndex: 'kunnr', sortable: true},
			{text: "Qty", width: 100, dataIndex: 'menge', sortable: true},
			{text: "Unit", width: 50, dataIndex: 'meins', sortable: true},
			{text: "Price/Unit", width: 120, dataIndex: 'unitp', sortable: true},
			{text: "Discount", width: 100, dataIndex: 'dismt', sortable: true},
			{text: "Amount", width: 120, dataIndex: 'pramt', sortable: true},
			{text: "Currency", width: 100, dataIndex: 'ctype', sortable: true}
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: this.store,
			displayInfo: true
		};

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
	}
});
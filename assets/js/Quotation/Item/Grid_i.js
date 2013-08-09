Ext.define('Account.Quotation.Item.Grid_i', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"Quotation/loads_it",
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
		    {text: "Item", width: 100, dataIndex: 'vbelp', sortable: true},
			{text: "Material", width: 150, dataIndex: 'matnr', sortable: true},
		    //{text: "Description", width: 100, dataIndex: 'kunnr', sortable: true},
			{text: "Qty", width: 150, dataIndex: 'menge', sortable: true},
			{text: "Unit", width: 100, dataIndex: 'meins', sortable: true},
			{text: "Price/Unit", width: 150, dataIndex: 'unitp', sortable: true},
			{text: "Discount", width: 100, dataIndex: 'dismt', sortable: true},
			{text: "Amount", width: 100, dataIndex: 'pramt', sortable: true},
			{text: "Currency", width: 150, dataIndex: 'ctype', sortable: true}
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
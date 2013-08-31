Ext.define('Account.Invoice.Item.Grid_gl', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"Invoice/loads_gl_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'belnr'
				}
			},
			fields: [
				'belnr',
				'gjahr',
				'bldat',
				'saknr',
				'invnr'
			],
			remoteSort: true,
			sorters: ['saknr ASC']
		});

		this.columns = [
		    {text: "Account No", width: 80, dataIndex: 'belnr', sortable: true},
			{text: "Account Name", width: 300, dataIndex: 'gjahr', sortable: true},
		    {text: "Debit", width: 100, dataIndex: 'bldat', sortable: true},
			{text: "Credit", width: 100, dataIndex: 'saknr', sortable: true},
			{text: "Amount", width: 150, dataIndex: 'invnr', sortable: true}
			//{text: "Currency", width: 100, dataIndex: 'jobtx', sortable: true}
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
Ext.define('Account.Warehouse.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"warehouse/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'warnr'
				}
			},
			fields: [
				'warnr',
				'watxt'
			],
			remoteSort: true,
			sorters: ['warnr ASC']
		});

		this.columns = [
			{text: "Warehouse Code", width: 120, dataIndex: 'warnr', sortable: true},
			{text: "Warehouse Name", width: 120, dataIndex: 'watxt', sortable: true}
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
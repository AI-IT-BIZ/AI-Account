Ext.define('Account.SCurrency.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"currency/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'ctype'
				},
				simpleSortMode: true
			},
			fields: [
			    'ctype',
				'curtx'
			],
			remoteSort: true,
			sorters: [{property: 'ctype', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Currency Code", 
		    width: 80, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "Currency Name", 
			width: 250, dataIndex: 'curtx', sortable: true}
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
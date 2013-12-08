Ext.define('Account.SAp.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"ap/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'invnr'
				},
				simpleSortMode: true
			},
			fields: [
			    'invnr',
				'bldat',
				'lifnr',
				'name1',
				'netwr',
				'statx',
				'refnr',
				'sgtxt'
				
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "AP Doc", flex: true, dataIndex: 'invnr', sortable: true},
			{text: "AP Date", width: 125, dataIndex: 'bldat', sortable: true},
			{text: "Vendor Code", flex: true, dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", flex: true, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", flex: true, dataIndex: 'netwr', sortable: true},
			{text: "AP Status", flex: true, dataIndex: 'statx', sortable: true},
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
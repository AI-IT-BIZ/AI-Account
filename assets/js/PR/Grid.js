Ext.define('Account.PR.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"pr/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'purnr'
				}
			},
			fields: [
			    'purnr',
				'bldat',
				'lifnr',
				'name1',
				'netwr',
				'statx',
				'adr01',
				'distx',
				'pstlz',
				'telf1',
				'telfx',
				'email'
			],
			remoteSort: true,
			sorters: ['purnr ASC']
		});

		this.columns = [
			{text: "PR No", flex: true, dataIndex: 'purnr', sortable: true},
			{text: "PR Date", width: 125, dataIndex: 'bldat', sortable: true},
			{text: "Vendor Code", flex: true, dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", flex: true, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", xtype: 'numbercolumn',
			flex: true, dataIndex: 'netwr', sortable: true},
			{text: "PR Status", flex: true, dataIndex: 'statx', sortable: true},
			{text: "", width: 0, dataIndex: 'adr01', sortable: true},
			{text: "", width: 0, dataIndex: 'distx', sortable: true},
			{text: "", width: 0, dataIndex: 'pstlz', sortable: true},
			{text: "", width: 0, dataIndex: 'telf1', sortable: true},
			{text: "", width: 0, dataIndex: 'telfx', sortable: true},
			{text: "", width: 0, dataIndex: 'email', sortable: true}
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
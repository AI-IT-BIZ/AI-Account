Ext.define('Account.SCustomer.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"customer/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'kunnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
				'kunnr',
				'name1',
				'adr01',
				'distx',
				'pstlz',
				'telf1',
				'telfx',
				'email',
				'pson1',
				'statx',
				'erdat',
				'ernam'
			],
			remoteSort: true,
			sorters: [{property: 'kunnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Customer Code", width: 100, dataIndex: 'kunnr', sortable: true},
			{text: "Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Address", width: 200, dataIndex: 'adr01', sortable: true},
			{text: "District", flex: true, dataIndex: 'distx', sortable: true},
			{text: "Post Code", width: 60, dataIndex: 'pstlz', sortable: true},
			{text: "Telephon", flex: true, dataIndex: 'telf1', sortable: true},
			{text: "Fax No", flex: true, dataIndex: 'telfx', sortable: true},
			{text: "Email", width: 120, dataIndex: 'email', sortable: true},
			{text: "Contact Person", flex: true, dataIndex: 'pson1', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "Create Name",
			width: 100, dataIndex: 'ernam', sortable: true},
			{text: "Create Date",
			width: 120, dataIndex: 'erdat', sortable: true},
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
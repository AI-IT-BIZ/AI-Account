Ext.define('Account.SVendor.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"vendor/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'lifnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
				'lifnr',
				'name1',
				'brach',
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
			sorters: [{property: 'lifnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Vendor Code", width: 90, dataIndex: 'lifnr', sortable: true},
			{text: "Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Branch No", width: 60, dataIndex: 'brach', sortable: true},
			{text: "Address", width: 200, dataIndex: 'adr01', sortable: true},
			{text: "Province", width: 100, dataIndex: 'distx', sortable: true},
			{text: "Postcode", width: 60, dataIndex: 'pstlz', sortable: true},
			{text: "Telephone", width: 100, dataIndex: 'telf1', sortable: true},
			{text: "Fax No", width: 100, dataIndex: 'telfx', sortable: true},
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
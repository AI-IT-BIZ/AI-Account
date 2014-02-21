Ext.define('Account.OtherExpense.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"otexpense/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'invnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'invnr',
				'bldat',
				'mbeln',
				'lifnr',
				'name1',
				'netwr',
				'statx'
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "AP Doc", width: 100, dataIndex: 'invnr', 
			align: 'center', sortable: true},
			{text: "AP Date", width: 85, 
			xtype: 'datecolumn',align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			{text: "GR Doc", width: 100,dataIndex: 'mbeln', 
			align: 'center', sortable: true},
			{text: "Vendor Code", width: 100, dataIndex: 'lifnr', 
			align: 'center', sortable: true},
			{text: "Vendor Name", width: 140, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", width: 100, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'netwr', sortable: true},
			{text: "AP Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "Create Name",
			width: 100, dataIndex: 'ernam', sortable: true},
			{text: "Create Date",
			width: 120, dataIndex: 'erdat', sortable: true},
			{text: "Update Name",
			width: 100, dataIndex: 'upnam', sortable: true},
			{text: "Update Date",
			width: 120, dataIndex: 'updat', sortable: true}
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
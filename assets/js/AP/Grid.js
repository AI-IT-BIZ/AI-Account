Ext.define('Account.AP.Grid', {
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
				'statx',
				'erdat',
				'ernam',
				'updat',
				'upnam'
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "AP Doc", flex: true, dataIndex: 'invnr', 
			align: 'center', sortable: true},
			{text: "AP Date", width: 125, 
			xtype: 'datecolumn',
			align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			{text: "GR Doc", flex: true, dataIndex: 'mbeln', 
			align: 'center', sortable: true},
			{text: "Vendor Code", flex: true, dataIndex: 'lifnr', 
			align: 'center', sortable: true},
			{text: "Vendor Name", flex: true, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'netwr', sortable: true},
			{text: "AP Status", flex: true, dataIndex: 'statx', sortable: true},
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
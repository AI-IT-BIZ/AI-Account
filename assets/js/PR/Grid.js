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
					idProperty: 'purnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'purnr',
				'bldat',
				'lifnr',
				'name1',
				'netwr',
				'statx',
				'ctype',
				'deptx',
				'erdat',
				'ernam',
				'updat',
				'upnam'
			],
			remoteSort: true,
			sorters: [{property: 'purnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "PR No", width: 100, dataIndex: 'purnr', 
			align: 'center',sortable: true},
			{text: "PR Date", width: 85, xtype: 'datecolumn',
			align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			{text: "Vendor Code", width: 80, dataIndex: 'lifnr',
			align: 'center', sortable: true},
			{text: "Vendor Name", width: 140, dataIndex: 'name1', sortable: true},
			{text: "PR Status", width: 100, dataIndex: 'statx',
			align: 'center', sortable: true},
			{text: "Net Amount", width: 100, xtype: 'numbercolumn',align: 'right',
			dataIndex: 'netwr', sortable: true},
			{text: "Currency", width: 55, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "Department", width: 100, dataIndex: 'deptx', sortable: true},
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
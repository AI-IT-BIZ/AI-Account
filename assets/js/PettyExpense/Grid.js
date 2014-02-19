Ext.define('Account.PettyExpense.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"pettyexpense/loads",
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
				'remnr',
				'lifnr',
				'name1',
				'deamt',
				'netwr',
				'dispc',
				'ctype',
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
			{text: "Petty Cash No.", width: 100, dataIndex: 'invnr', 
			align: 'center', sortable: true},
			{text: "Petty Cash Date", width: 85, xtype: 'datecolumn',
			align: 'center', format:'d/m/Y', dataIndex: 'bldat', sortable: true},
			{text: "CPV No.", width: 100, dataIndex: 'remnr', 
			align: 'center', sortable: true},
			{text: "Vendor Code", width: 100, dataIndex: 'lifnr', 
			align: 'center', sortable: true},
			{text: "Vendor Name", width: 140, dataIndex: 'name1', sortable: true},
			{text: "PC Net Amount", width: 100, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'netwr', sortable: true},
			{text: "CPV Amount", width: 100,
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'deamt', sortable: true},
			{text: "CPV Amt Remain", width: 100, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'dispc', sortable: true},
			{text: "Currency", width: 55, align: 'center', 
			dataIndex: 'ctype', sortable: true},
			{text: "Petty Cash Status", width: 100, dataIndex: 'statx', sortable: true},
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
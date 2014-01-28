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
				'statx'
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Petty Cash No.", flex: true, dataIndex: 'invnr', 
			align: 'center', sortable: true},
			{text: "Petty Cash Date", width: 125, 
			xtype: 'datecolumn',
			align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			{text: "CPV No.", flex: true, dataIndex: 'remnr', 
			align: 'center', sortable: true},
			{text: "Vendor Code", flex: true, dataIndex: 'lifnr', 
			align: 'center', sortable: true},
			{text: "Vendor Name", flex: true, dataIndex: 'name1', sortable: true},
			{text: "PC Net Amount", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'netwr', sortable: true},
			{text: "CPV Amount", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'deamt', sortable: true},
			{text: "CPV Amt Remain", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'dispc', sortable: true},
			{text: "Petty Cash Status", flex: true, dataIndex: 'statx', sortable: true}
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
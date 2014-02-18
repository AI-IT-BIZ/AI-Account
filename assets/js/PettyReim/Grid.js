Ext.define('Account.PettyReim.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"pettyreim/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'remnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'remnr',
				'bldat',
				'lifnr',
				'name1',
				'netwr',
				'ctype',
				'deamt',
				'reman',
				'dispc',
				'upamt',
				'statx',
				'erdat',
				'ernam',
				'updat',
				'upnam'
			],
			remoteSort: true,
			sorters: [{property: 'remnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "CPV No.", flex: true, dataIndex: 'remnr', 
			align: 'center', sortable: true},
			{text: "CPV Date", width: 125, 
			xtype: 'datecolumn',
			align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			{text: "Vendor Code", flex: true, dataIndex: 'lifnr', 
			align: 'center', sortable: true},
			{text: "Vendor Name", flex: true, dataIndex: 'name1', sortable: true},
			
			{text: "Limit Amount", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'deamt', sortable: true},
			
			{text: "Limit Remain Amt", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'reman', sortable: true},
			
			{text: "CPV Amount", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'netwr', sortable: true},
			
			{text: "CPV Remain Amt", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'dispc', sortable: true},
			
			{text: "Currency", flex: true, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "CPV Status", flex: true, dataIndex: 'statx', sortable: true},
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
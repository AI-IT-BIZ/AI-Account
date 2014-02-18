Ext.define('Account.SGR.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"gr/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'mbeln',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'mbeln',
				'bldat',
				'lifnr',
				'name1',
				'ebeln',
				'netwr',
				'ctype',
				'statx',
				'erdat',
				'ernam',
				'updat',
				'upnam'
			],
			remoteSort: true,
			sorters: [{property: 'mbeln', direction: 'ASC'}]
		});

		this.columns = [
			{text: "GR No", width: 100, align: 'center', dataIndex: 'mbeln', sortable: true},
			{text: "GR Date", width: 120, align: 'center', xtype: 'datecolumn',
			 format:'d/m/Y',dataIndex: 'bldat', sortable: true},
			{text: "Vendor Code", width: 100, align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", width: 200, dataIndex: 'name1', sortable: true},
			{text: "PO No", width: 100, align: 'center', dataIndex: 'ebeln', sortable: true},
			{text: "Net Amount", width: 150, align: 'right',
			xtype: 'numbercolumn',dataIndex: 'netwr', sortable: true},
			{text: "Currency", width: 50, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "GR Status", width: 150, align: 'center', dataIndex: 'statx', sortable: true},
			{text: "Create Name",
			width: 100, dataIndex: 'ernam', sortable: true},
			{text: "Create Date",
			width: 120, dataIndex: 'erdat', sortable: true},
			{text: "Update Name",
			width: 100, dataIndex: 'upnam', sortable: true},
			{text: "Update Date",
			width: 120, dataIndex: 'updat', sortable: true},
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
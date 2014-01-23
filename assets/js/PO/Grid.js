Ext.define('Account.PO.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"po/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'ebeln',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'ebeln',
				'bldat',
				'lifnr',
				'name1',
				'purnr',
				'netwr',
				'ctype',
				'statx'
			],
			remoteSort: true,
			sorters: [{property: 'ebeln', direction: 'ASC'}]
		});

		this.columns = [
			{text: "PO No", width: 100,align: 'center', dataIndex: 'ebeln', sortable: true},
			{text: "PO Date", width: 100, xtype: 'datecolumn',align: 'center', 
			format:'d/m/Y', dataIndex: 'bldat', sortable: true},
			{text: "Vendor Code", width: 100,align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", width: 250, dataIndex: 'name1', sortable: true},
			{text: "PR No", width: 100, dataIndex: 'purnr',align: 'center', sortable: true},
			{text: "Net Amount", width: 150,xtype: 'numbercolumn',align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Currency", width: 50, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "PO Status", width: 150, align: 'center', dataIndex: 'statx', sortable: true}
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 25,
			store: this.store,
			displayInfo: true
		};

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
	}
});
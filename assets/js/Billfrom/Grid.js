Ext.define('Account.Billfrom.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"billfrom/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'bilnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'bilnr',
				'bldat',
				'duedt',
				'lifnr',
				'name1',
				'txz01',
				'statu',
				'netwr',
				'ctype'
			],
			remoteSort: true,
			sorters: [{property: 'bilnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Bill From No", 
		    width: 120, align: 'center', dataIndex: 'bilnr', sortable: true},
			{text: "Doc Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'bldat', sortable: true},
			{text: "Receipt Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'duedt', sortable: true},
		    {text: "Vendor No", 
		    width: 80, align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", 
			width: 150, dataIndex: 'name1', sortable: true},
			{text: "Text Note", 
			width: 200, dataIndex: 'txz01', sortable: true},
			{text: "Status", 
			width: 100, dataIndex: 'statx', sortable: true},
			{text: "Amount", 
			xtype: 'numbercolumn',
			width: 80, align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Currency", 
			width: 60, align: 'center', dataIndex: 'ctype', sortable: true}
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
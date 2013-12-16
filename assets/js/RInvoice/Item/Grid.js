Ext.define('Account.RInvoice.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"invoice/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'invnr'
				},
				simpleSortMode: true
			},
			fields: [
			    'invnr',
				'bldat',
				'ordnr',
				'kunnr',
				'name1',
				'jobnr',
				'jobtx',
				'statx',
				'sname',
				'netwr',
				'ctype'
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Invoice No", 
		    width: 80, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "Invoice Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 70, align: 'center', dataIndex: 'bldat', sortable: true},
			{text: "Sale Order No", 
		    width: 80, align: 'center', dataIndex: 'ordnr', sortable: true},
		    {text: "Customer No", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", 
			width: 120, dataIndex: 'name1', sortable: true},
			{text: "Project No", 
			width: 80, align: 'center', dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", 
			width: 120, dataIndex: 'jobtx', sortable: true},
			{text: "Status", 
			width: 60, dataIndex: 'statx', sortable: true},
			{text: "Sale Name", 
			width: 100, dataIndex: 'sname', sortable: true},
			{text: "Amount", 
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
		this.store.load({
			params: options
		});
	}
});
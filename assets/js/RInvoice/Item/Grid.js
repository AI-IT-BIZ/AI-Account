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
				}
			},
			fields: [
			    'invnr',
				'bldat',
				'kunnr',
				'name1',
				'vbeln',
				'jobnr',
				'jobtx',
				'statx',
				'sname',
				'netwr',
				'ctype'
			],
			remoteSort: true,
			sorters: ['vbeln ASC']
		});

		this.columns = [
		    {text: "Quotation No", 
		    width: 90, align: 'center', dataIndex: 'vbeln', sortable: true},
			{text: "Quotation Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", 
			width: 120, dataIndex: 'name1', sortable: true},
			{text: "Quotation No", 
			width: 90, align: 'center', dataIndex: 'vbeln', sortable: true},
			{text: "Project No", 
			width: 90, align: 'center', dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", 
			width: 150, dataIndex: 'jobtx', sortable: true},
			{text: "Status", 
			width: 100, dataIndex: 'statx', sortable: true},
			{text: "Sale Name", 
			width: 120, dataIndex: 'sname', sortable: true},
			{text: "Amount", 
			width: 100, align: 'right', dataIndex: 'netwr', sortable: true},
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
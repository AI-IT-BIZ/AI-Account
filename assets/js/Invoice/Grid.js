Ext.define('Account.Invoice.Grid', {
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
				'jobtx',
				'sname',
				'statu',
				'paytx',
				'netwr',
				'cytpe',
				'beamt'
			],
			remoteSort: true,
			sorters: ['vbeln ASC']
		});

		this.columns = [
		    {text: "Invoice No", width: 100, dataIndex: 'invnr', sortable: true},
			{text: "Invoice Date", width: 80, dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", width: 100, dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Quotation No", width: 100, dataIndex: 'vbeln', sortable: true},
			{text: "Project Name", width: 150, dataIndex: 'jobtx', sortable: true},
			{text: "Sale Person", width: 120, dataIndex: 'sname', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "Payment Method", width: 100, dataIndex: 'paytx', sortable: true},
			{text: "Amount", width: 80, dataIndex: 'netwr', sortable: true},
			{text: "Currency", width: 50, dataIndex: 'ctype', sortable: true}
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
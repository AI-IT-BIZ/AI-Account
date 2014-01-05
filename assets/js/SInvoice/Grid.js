Ext.define('Account.SInvoice.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"invoice/loads_inv",
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
				'kunnr',
				'name1',
				'vbeln',
				'jobtx',
				'sname',
				'statx',
				'paytx',
				'netwr',
				'ctype',
				'refnr',
				'txz01',
				'wht01',
				'vat01',
				'loekz'
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Invoice No", 
		    width: 80, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "Invoice Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", 
			width: 150, dataIndex: 'name1', sortable: true},
			{text: "Quotation No", 
			width: 80, align: 'center', dataIndex: 'vbeln', sortable: true},
			{text: "Project Name", 
			width: 150, dataIndex: 'jobtx', sortable: true},
			{text: "Sale Person", 
			width: 120, dataIndex: 'sname', sortable: true},
			{text: "Status", 
			width: 100, dataIndex: 'statx', sortable: true},
			{text: "Payment Method", 
			width: 100, dataIndex: 'paytx', sortable: true},
			{text: "Amount", xtype: 'numbercolumn',
			width: 80, align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Currency", 
			width: 60, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "1",hidden: true,width: 0, dataIndex: 'refnr', sortable: false},
			{text: "2",hidden: true,width: 0, dataIndex: 'txz01', sortable: false},
			{text: "3",hidden: true,width: 0, dataIndex: 'wht01', sortable: false},
			{text: "4",hidden: true,width: 0, dataIndex: 'vat01', sortable: false},
			{text: "5",hidden: true,width: 0, dataIndex: 'loekz', sortable: false}
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
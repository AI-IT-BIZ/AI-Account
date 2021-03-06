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
					idProperty: 'invnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'invnr',
				'bldat',
				'duedt',
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
				'loekz',
				'erdat',
				'ernam',
				'updat',
				'upnam',
				'dismt',
				'dispc',
				'beamt'
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
			{text: "Create Name",
			width: 100, dataIndex: 'ernam', sortable: true},
			{text: "Create Date",
			width: 120, dataIndex: 'erdat', sortable: true},
			{text: "Update Name",
			width: 100, dataIndex: 'upnam', sortable: true},
			{text: "Update Date",
			width: 120, dataIndex: 'updat', sortable: true},
			{text: "1",hidden: true,width: 0, dataIndex: 'refnr', sortable: false},
			{text: "2",hidden: true,width: 0, dataIndex: 'txz01', sortable: false},
			{text: "3",hidden: true,width: 0, dataIndex: 'wht01', sortable: false},
			{text: "4",hidden: true,width: 0, dataIndex: 'vat01', sortable: false},
			{text: "5",hidden: true,width: 0, dataIndex: 'loekz', sortable: false},
			{text: "6",hidden: true,width: 0, dataIndex: 'duedt', sortable: false},
			{text: "7",hidden: true,width: 0, dataIndex: 'dismt', sortable: false},
			{text: "8",hidden: true,width: 0, dataIndex: 'beamt', sortable: false},
			{text: "9",hidden: true,width: 0, dataIndex: 'dispc', sortable: false}
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
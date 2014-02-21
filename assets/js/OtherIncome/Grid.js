Ext.define('Account.OtherIncome.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"otincome/loads",
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
				'kunnr',
				'name1',
				'jobnr',
				'jobtx',
				'sname',
				'statx',
				'paytx',
				'netwr',
				'ctype',
				'erdat',
				'ernam',
				'updat',
				'upnam'
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Invoice No.", 
		    width: 80, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "Invoice Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", 
			width: 150, dataIndex: 'name1', sortable: true},
			{text: "Project No",
			width: 100, align: 'center', dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", width: 150, dataIndex: 'jobtx', sortable: true},
			{text: "Sale Person", 
			width: 120, dataIndex: 'sname', sortable: true},
			{text: "Status", 
			width: 100, dataIndex: 'statx', sortable: true},
			{text: "Payment Method", 
			width: 100, dataIndex: 'paytx', sortable: true},
			{text: "Amount", 
			xtype: 'numbercolumn',
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
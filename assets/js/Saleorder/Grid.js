Ext.define('Account.Saleorder.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"saleorder/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'ordnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'ordnr',
				'bldat',
				'kunnr',
				'name1',
				'vbeln',
				'statx',
				'salnr',
				'sname',
				'netwr',
				'ctype',
				'ptype',
				'taxnr',
				'terms',
				'erdat',
				'ernam',
				'updat',
				'upnam'
			],
			remoteSort: true,
			sorters: [{property: 'ordnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Sale Order No.", 
		    width: 100, align: 'center', dataIndex: 'ordnr', sortable: true},
			{text: "SO Date", xtype: 'datecolumn',
			width: 100, align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", 
		    width: 100, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Quotation No.", 
			width: 100, align: 'center', dataIndex: 'vbeln', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "1",hidden: true,width: 0, dataIndex: 'salnr', sortable: false},
			{text: "Salesperson", width: 120, dataIndex: 'sname', sortable: true},
			{text: "Amount", 
			xtype: 'numbercolumn',
			width: 100, align: 'right', dataIndex: 'netwr', sortable: true},
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
			{text: "2",hidden: true,width: 0, dataIndex: 'ptype', sortable: false},
			{text: "3",hidden: true,width: 0, dataIndex: 'taxnr', sortable: false},
			{text: "4",hidden: true,width: 0, dataIndex: 'terms', sortable: false}
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
Ext.define('Account.Quotation.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"quotation/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vbeln',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
				'vbeln',
				'bldat',
				'kunnr',
				'name1',
				'jobnr',
				'jobtx',
				'statx',
				'salnr',
				'sname',
				'netwr',
				'ctype',
				'ptype',
				'taxnr',
				'terms'
			],
			remoteSort: true,
			sorters: [{property: 'vbeln', direction: 'ASC'}]

		});

		this.columns = [
			{text: "Quotation No",
			width: 100, align: 'center', dataIndex: 'vbeln', sortable: true},
			{text: "Quotation Date", xtype: 'datecolumn',
			width: 85, align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			{text: "Customer No",
			width: 100, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 100, dataIndex: 'name1', sortable: true},
			{text: "Project No",
			width: 100, align: 'center', dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", width: 150, dataIndex: 'jobtx', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "",hidden: true, width: 0, dataIndex: 'salnr'},
			{text: "Salesperson", width: 120, dataIndex: 'sname', sortable: true},
			{text: "Amount", xtype: 'numbercolumn',
			width: 100, align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Currency",
			width: 60, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "1",hidden: true,width: 0, sortable: false, dataIndex: 'ptype'},
			{text: "2",hidden: true,width: 0, sortable: false, dataIndex: 'taxnr'},
			{text: "3",hidden: true,width: 0, sortable: false, dataIndex: 'terms'}
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
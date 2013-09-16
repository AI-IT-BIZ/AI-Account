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
					idProperty: 'vbeln'
				}
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
			sorters: ['vbeln ASC']
		});

		this.columns = [
		    {text: "Quotation No", 
		    width: 100, align: 'center', dataIndex: 'vbeln', sortable: true},
			{text: "Quotation Date", xtype: 'datecolumn',
			width: 80, align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", 
		    width: 100, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 100, dataIndex: 'name1', sortable: true},
			{text: "Project No", 
			width: 100, align: 'center', dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", width: 150, dataIndex: 'jobtx', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "",xtype: 'hidden',width: 0, dataIndex: 'salnr'},
			{text: "Sale Name", width: 120, dataIndex: 'sname', sortable: true},
			{text: "Amount", 
			width: 100, align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Currency", 
			width: 60, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "",xtype: 'hidden',width: 0, dataIndex: 'ptype'},
			{text: "",xtype: 'hidden',width: 0, dataIndex: 'taxnr'},
			{text: "",xtype: 'hidden',width: 0, dataIndex: 'terms'}
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
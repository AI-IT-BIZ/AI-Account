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
					idProperty: 'ordnr'
				}
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
				'terms'
			],
			remoteSort: true,
			sorters: ['ordnr ASC']
		});

		this.columns = [
		    {text: "Sale Order No.", 
		    width: 100, align: 'center', dataIndex: 'ordnr', sortable: true},
			{text: "SO Date", xtype: 'datecolumn',
			width: 100, align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", 
		    width: 100, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 100, dataIndex: 'name1', sortable: true},
			{text: "Quotation No.", 
			width: 100, align: 'center', dataIndex: 'vbeln', sortable: true},
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
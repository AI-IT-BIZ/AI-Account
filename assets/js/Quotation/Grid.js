Ext.define('Account.Quotation.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"Quotation/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vbeln'
				}
			},
			fields: [
			    'vbeln',
				'bldat',
				'auart',
				'txz01',
				'jobnr',
				'statu',
				'reanr',
				'refnr',
				'ptype',
				'taxnr',
				'lidat',
				'kunnr',
				'netwr',
				'cytpe',
				'beamt',
				'taxpr',
				'exchg'
			],
			remoteSort: true,
			sorters: ['jobnr ASC']
		});

		this.columns = [
		    {text: "Quotation No", width: 100, dataIndex: 'vbeln', sortable: true},
			{text: "Quotation Date", width: 150, dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", width: 100, dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Project No", width: 100, dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", width: 150, dataIndex: 'jobtx', sortable: true},
			{text: "Status", width: 60, dataIndex: 'statu', sortable: true},
			{text: "Amount", width: 100, dataIndex: 'netwr', sortable: true},
			{text: "Currency", width: 80, dataIndex: 'ctype', sortable: true}
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
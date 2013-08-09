Ext.define('Account.Quotation.Item.Grid_p', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"Quotation/loads_pp",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vbeln'
				}
			},
			fields: [
				'paypr',
				'sgtxt',
				'duedt',
				'perct',
				'pramt',
				'ctype'
			],
			remoteSort: true,
			sorters: ['vbeln ASC']
		});

		this.columns = [
		    {text: "Period On", width: 100, dataIndex: 'vbeln', sortable: true},
			{text: "Period Desc.", width: 150, dataIndex: 'bldat', sortable: true},
		    {text: "Period Date", width: 100, dataIndex: 'kunnr', sortable: true},
			{text: "Percent", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Amount", width: 100, dataIndex: 'jobnr', sortable: true},
			{text: "Currency", width: 150, dataIndex: 'jobtx', sortable: true}
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
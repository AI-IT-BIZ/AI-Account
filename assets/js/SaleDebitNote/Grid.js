Ext.define('Account.SaleDebitNote.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"debitnote/loads_dns",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'debnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'debnr',
				'bldat',
				'invnr',
				'kunnr',
				'name1',
				'txz01',
				'statx',
				'netwr',
				'ctype'
			],
			remoteSort: true,
			sorters: [{property: 'debnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Debit Note No", 
		    width: 100, align: 'center', dataIndex: 'debnr', sortable: true},
			{text: "Doc Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'bldat', sortable: true},
            {text: "Invoice No", 
		    width: 80, align: 'center', dataIndex: 'invnr', sortable: true},
		    {text: "Customer No", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", 
			width: 150, dataIndex: 'name1', sortable: true},
			{text: "Text Note", 
			width: 200, dataIndex: 'txz01', sortable: true},
			{text: "Status", 
			width: 100, dataIndex: 'statx', sortable: true},
			{text: "Amount", 
			xtype: 'numbercolumn',
			width: 80, align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Currency", 
			width: 60, align: 'center', dataIndex: 'ctype', sortable: true}
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
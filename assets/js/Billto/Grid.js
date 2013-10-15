Ext.define('Account.Billto.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"billto/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'bilnr'
				}
			},
			fields: [
			    'bilnr',
				'bldat',
				'duedt',
				'kunnr',
				'name1',
				'txz01',
				'statu',
				'netwr'//,
				//'ctype'
			],
			remoteSort: true,
			sorters: ['bilnr ASC']
		});

		this.columns = [
		    {text: "Bill To No", 
		    width: 120, align: 'center', dataIndex: 'bilnr', sortable: true},
			{text: "Doc Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'bldat', sortable: true},
			{text: "Receipt Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'duedt', sortable: true},
		    {text: "Customer No", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", 
			width: 200, dataIndex: 'name1', sortable: true},
			{text: "Text Note", 
			width: 250, dataIndex: 'txz01', sortable: true},
			{text: "Status", 
			width: 100, dataIndex: 'statx', sortable: true},
			{text: "Amount", 
			xtype: 'numbercolumn',
			width: 80, align: 'right', dataIndex: 'netwr', sortable: true}//,
			//{text: "Currency", 
			//width: 60, align: 'center', dataIndex: 'ctype', sortable: true}
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
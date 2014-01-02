Ext.define('Account.RReceipt.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"receipt/loads_report",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.recnr+o.vbelp; }//'invnr'
				},
				simpleSortMode: true
			},
			fields: [
			    'recnr',
			    'vbelp',
			    'bldat',
				//'duedt',
				'kunnr',
				'name1',
				'invnr',
				'invdt',
				'itamt',
				'netwr'//,
				//'jobnr',
				//'vbeln'
			],
			remoteSort: true,
			sorters: [{property: 'recnr', direction: 'ASC'}],
		});

		this.columns = [
		    {text: "Receipt No", 
		    width: 90, align: 'center', dataIndex: 'recnr', sortable: true},
		    //{text: "Items", 
		    //width: 60, align: 'center', dataIndex: 'vbelp', sortable: true},
			{text: "Document Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'bldat', sortable: true},
			//{text: "Receipt Date", xtype: 'datecolumn', format:'d/m/Y',
			//width: 80, align: 'center', dataIndex: 'bldat', sortable: true},
		    {text: "Customer Code", 
		    width: 90, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "Customer Name", 
			width: 160, dataIndex: 'name1', sortable: true},
			
			{text: "Net Amount", 
			width: 90, align: 'right', dataIndex: 'netwr', 
			xtype: 'numbercolumn', sortable: true},
		    
			{text: "Invoice No", 
		    width: 90, align: 'center', dataIndex: 'invnr', sortable: true},
		    {text: "Invoice Date", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: true},
		    
			{text: "Amount", 
			width: 90, align: 'right', dataIndex: 'itamt', 
			xtype: 'numbercolumn', sortable: true}
			
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
		this.store.load({
			params: options
		});
	}
});
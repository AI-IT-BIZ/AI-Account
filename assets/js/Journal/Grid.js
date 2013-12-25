//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Journal.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			pageSize: 25,
			proxy: {
				type: 'ajax',
				url: __site_url+'journal/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'belnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
				'belnr',
				'bldat',
				'typtx',
				'tranr',
				'trantx',
				'refnr',
				'kunnr',
				'txz01',
				'netwr'
				
			],
			remoteSort: true,
			sorters: [{property: 'belnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Journal Code", align: 'center',
			width: 100, dataIndex: 'belnr', sortable: true},
			{text: "Journal Type", align: 'center',
			width: 100, dataIndex: 'typtx', sortable: true},
			{text: "Journal Date", 
			align: 'center',
			width: 80, dataIndex: 'bldat', 
			sortable: true,
			xtype: 'datecolumn',
			format:'d/m/Y'
			},
			{text: "Template Code", align: 'center',
			width: 80, dataIndex: 'tranr', sortable: true},
			{text: "Template Name", align: 'center',
			width: 100, dataIndex: 'trantx', sortable: true},
			{text: "Reference Doc.", 
			width: 100, dataIndex: 'refnr', sortable: true},
			{text: "Custumer Code", 
			width: 100, dataIndex: 'kunnr', sortable: true},
			{text: "Text Note", 
			width: 200, dataIndex: 'txz01', sortable: true},
			{text: "Amount",
			 xtype: 'numbercolumn',
			width: 120, dataIndex: 'netwr', sortable: true}
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			store: this.store,
			displayInfo: true
		};

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
	}
});



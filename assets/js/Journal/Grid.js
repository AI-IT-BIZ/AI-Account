//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Journal.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'journal/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'belnr'
				}
			},
			fields: [
				'belnr',
				'typtx',
				'bldat',
				'txz01'
				
			],
			remoteSort: true,
			sorters: ['belnr ASC']
		});

		this.columns = [
		    {text: "Journal Code", align: 'center',
			width: 100, dataIndex: 'tranr', sortable: true},
			{text: "Journal Type", align: 'center',
			width: 100, dataIndex: 'typtx', sortable: true},
			{text: "Journal Date", align: 'center',
			width: 100, dataIndex: 'bldat', sortable: true},
			{text: "Description", 
			width: 290, dataIndex: 'txz01', sortable: true}
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



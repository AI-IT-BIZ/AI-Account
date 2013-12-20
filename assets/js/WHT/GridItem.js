Ext.define('Account.WHT.GridItem', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'invoice/loads_wht',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'whtnr'
				}
			},
			fields: [
				'whtnr',
				'whtxt'
			],
			remoteSort: true,
			sorters: ['whtnr ASC']
		});

		this.columns = [
			{text: "WHT No",align: 'center', width: 80, dataIndex: 'whtnr', sortable: true},
			{text: "WHT Description", flex: true, dataIndex: 'whtxt', sortable: true},
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
		//if(options){ alert(options); }
	}
});
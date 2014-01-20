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
					idProperty: 'whtnr',
					totalProperty: 'totalCount'
				}
			},
			fields: [
				'whtnr',
				'whtxt',
				'whtgp',
				'whtpr'
			],
			remoteSort: true,
			sorters: ['whtnr ASC']
		});

		this.columns = [
			{text: "WHT No",align: 'center', width: 50, align : 'center',dataIndex: 'whtnr', sortable: true},
			{text: "WHT Description", width: 200, dataIndex: 'whtxt', sortable: true},
			{text: "WHT Group", width: 60, align : 'center',dataIndex: 'whtgp', sortable: true},
			{text: "WHT Value", width: 60, align : 'center',dataIndex: 'whtpr', sortable: true}
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
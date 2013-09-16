//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Bankname.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'bankname/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'bcode'
				}
			},
			fields: [
				'bcode',
				'bname',
				'saknr',
				'addrs'
			],
			remoteSort: true,
			sorters: ['bcode ASC']
		});

		this.columns = [
			{text: "Bank Code", align: 'center',
			width: 100, dataIndex: 'bcode', sortable: true},
			{text: "Bank Name", 
			width: 150, dataIndex: 'bname', sortable: true},
			{text: "GL No", lign: 'center',
			width: 70, dataIndex: 'saknr', sortable: true},
			{text: "Address", 
			width: 125, dataIndex: 'addrs', sortable: true}
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


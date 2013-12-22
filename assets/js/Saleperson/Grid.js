//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Saleperson.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'saleperson/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'salnr'
				}
			},
			fields: [
				'salnr',
				'empnr',
				'emnam',
				'ctype'
			],
			remoteSort: true,
			sorters: ['salnr ASC']
		});

		this.columns = [
			{text: "Sale Person No", width: 100, dataIndex: 'salnr', sortable: true},
			{text: "Employee No", flex: true, dataIndex: 'empnr', sortable: true},
			{text: "Name", flex: true, dataIndex: 'emnam', sortable: true},
			{text: "Commission Type", flex: true, dataIndex: 'ctype', sortable: true}
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


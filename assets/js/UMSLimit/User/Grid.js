Ext.define('Account.UMSLimit.User.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'ums/loads_user',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'empnr'
				},
				simpleSortMode: true
			},
			fields: [
				'empnr',
				'uname',
				'name1'
			],
			remoteSort: true,
			sorters: [{property: 'empnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Code", width: 60, dataIndex: 'empnr', sortable: true},
			{text: "Username", width: 80, dataIndex: 'uname', sortable: true},
			{text: "Name", width: 150, dataIndex: 'name1', sortable: true}
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
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



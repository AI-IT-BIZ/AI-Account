//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Company.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'company/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'comid'
				}
			},
			fields: [
				'comid',
				'name1',
				'name2',
				'adr01',
				'distx',
				'pstlz',
				'telf1',
				'telfx',
				'email'
			],
			remoteSort: true,
			sorters: ['lifnr ASC']
		});

		this.columns = [
			{text: "Code", width: 50, dataIndex: 'comid', sortable: true},
			{text: "Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Eng-Name", width: 150, dataIndex: 'name2', sortable: true},
			{text: "Address", width: 200, dataIndex: 'adr01', sortable: true},
			{text: "District", flex: true, dataIndex: 'distx', sortable: true},
			{text: "Postcode", width: 50, dataIndex: 'pstlz', sortable: true},
			{text: "Telephon", flex: true, dataIndex: 'telf1', sortable: true},
			{text: "Fax No", flex: true, dataIndex: 'telfx', sortable: true},
			{text: "Email", width: 120, dataIndex: 'email', sortable: true}
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



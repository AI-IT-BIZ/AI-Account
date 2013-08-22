//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Vendor.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'vendor/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'lifnr'
				}
			},
			fields: [
				'lifnr',
				'name1',
				'adr01',
				'distr',
				'telf1',
				'telfx',
				'pson1'
			],
			remoteSort: true,
			sorters: ['lifnr ASC']
		});

		this.columns = [
			{text: "Code", width: 80, dataIndex: 'lifnr', sortable: true},
			{text: "Name", flex: true, dataIndex: 'name1', sortable: true},
			{text: "Address", flex: true, dataIndex: 'adr01', sortable: true},
			{text: "District", flex: true, dataIndex: 'distr', sortable: true},
			{text: "Telephon", flex: true, dataIndex: 'telf1', sortable: true},
			{text: "Fax No", flex: true, dataIndex: 'telfx', sortable: true},
			{text: "Contact Person", flex: true, dataIndex: 'pson1', sortable: true}
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



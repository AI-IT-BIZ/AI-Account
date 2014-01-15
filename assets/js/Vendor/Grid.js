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
					idProperty: 'lifnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
				'lifnr',
				'name1',
				'adr01',
				'distx',
				'pstlz',
				'telf1',
				'telfx',
				'email',
				'pson1',
				'statx'
			],
			remoteSort: true,
			sorters: [{property: 'lifnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Vendor Code", width: 90, dataIndex: 'lifnr', sortable: true},
			{text: "Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Address", width: 200, dataIndex: 'adr01', sortable: true},
			{text: "Province", flex: true, dataIndex: 'distx', sortable: true},
			{text: "Postcode", width: 60, dataIndex: 'pstlz', sortable: true},
			{text: "Telephone", flex: true, dataIndex: 'telf1', sortable: true},
			{text: "Fax No", flex: true, dataIndex: 'telfx', sortable: true},
			{text: "Email", width: 120, dataIndex: 'email', sortable: true},
			{text: "Contact Person", flex: true, dataIndex: 'pson1', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true}
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



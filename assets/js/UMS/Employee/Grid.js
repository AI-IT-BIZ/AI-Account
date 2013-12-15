Ext.define('Account.UMS.Employee.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'ums/loads_employee',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'empnr'
				},
				simpleSortMode: true
			},
			fields: [
				'empnr',
				'name1',
				'adr01',
				'distx',
				'pstlz',
				'telf1',
				'cidno',
				'email',
				'pson1'
			],
			remoteSort: true,
			sorters: [{property: 'empnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Code", width: 50, dataIndex: 'empnr', sortable: true},
			{text: "Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Address", width: 200, dataIndex: 'adr01', sortable: true},
			{text: "District", flex: true, dataIndex: 'distx', sortable: true},
			{text: "Post Code", width: 60, dataIndex: 'pstlz', sortable: true},
			{text: "Telephon", flex: true, dataIndex: 'telf1', sortable: true},
			{text: "Email", width: 120, dataIndex: 'email', sortable: true},
			{text: "Contact Person", flex: true, dataIndex: 'pson1', sortable: true}
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



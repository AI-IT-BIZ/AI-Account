//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Customer.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'customer/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'kunnr'
				},
				simpleSortMode: true
			},
			fields: [
				'kunnr',
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
			sorters: [{property: 'kunnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Customer Code", width: 100, dataIndex: 'kunnr', sortable: true},
			{text: "Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Address", width: 200, dataIndex: 'adr01', sortable: true},
			{text: "District", flex: true, dataIndex: 'distx', sortable: true},
			{text: "Post Code", width: 60, dataIndex: 'pstlz', sortable: true},
			{text: "Telephon", flex: true, dataIndex: 'telf1', sortable: true},
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

/*
var store = new Ext.data.JsonStore({
		// store configs
		proxy: {
			type: 'ajax',
			url: '<?= site_url("pr/loads") ?>',
			reader: {
				type: 'json',
				root: 'rows',
				idProperty: 'id'
			}
		},
		fields: [
			{name:'id', type: 'int'},
			'code',
			{name:'create_date'},
			'create_by',
			{name:'update_date'},
			'update_by'
		],
		remoteSort: true,
		sorters: ['id ASC']
	});

	// create the grid
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		columns: [
			{text: "Id", width: 120, dataIndex: 'id', sortable: true},
			{text: "รหัส", flex: true, dataIndex: 'code', sortable: true},
			{text: "create_date", width: 125, dataIndex: 'create_date', sortable: true}
		],
		forceFit: true,
		height:210,
		split: true,
		region: 'center',
		tbar : [
			addAct
		],
		bbar: {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: store,
			displayInfo: true
		}
	});
*/

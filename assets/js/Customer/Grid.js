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
				url: __site_url+'customer2/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'kunnr'
				}
			},
			fields: [
				'kunnr',
				'name1',
				'adr01',
				'distr',
				'telf1',
				'telfx',
				'pson1'
			],
			remoteSort: true,
			sorters: ['kunnr ASC']
		});

		this.columns = [
			{text: "Code", width: 80, dataIndex: 'kunnr', sortable: true},
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

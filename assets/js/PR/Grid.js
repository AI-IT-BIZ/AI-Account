//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.PR.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'pr/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id'
				}
			},
			fields: [
				{name:'id', type: 'int'},
				'code',
				{name:'bldat'},
				{name:'create_date'},
				'create_by',
				{name:'update_date'},
				'update_by'
			],
			remoteSort: true,
			sorters: ['id ASC']
		});

		this.columns = [
			{text: "Id", width: 120, dataIndex: 'id', sortable: true},
			{text: "รหัส", flex: true, dataIndex: 'code', sortable: true},
			{text: "PR date", flex: true, dataIndex: 'bldat', sortable: true},
			{text: "Create date", width: 125, dataIndex: 'create_date', sortable: true}
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

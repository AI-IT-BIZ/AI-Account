Ext.define('Account.SMatAsset.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"asset/load2",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'matnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'matnr',
				'maktx',
				'mtart',
				'mtype',
				'matkl',
				'mgrpp',
				'meins',
				'saknr',
				'sgtxt',
				'statx',
				'erdat'
			],
			remoteSort: true,
			sorters: [{property: 'matnr', direction: 'ASC'}],
			pageSize: 10000000
		});

		this.columns = [
		    {text: "Mat&Asset No", width: 80, dataIndex: 'matnr', sortable: true},
			{text: "Mat&Asset Name", width: 130, dataIndex: 'maktx', sortable: true},
			{text: "Type", width: 50, dataIndex: 'mtart', sortable: true},
			{text: "Type Desc", width: 100, dataIndex: 'mtype', sortable: true},
			{text: "Group", width: 50, dataIndex: 'matkl', sortable: true},
			{text: "Group Desc", width: 100, dataIndex: 'mgrpp', sortable: true},
			{text: "GL No", width: 80, dataIndex: 'saknr', sortable: true},
			{text: "GL Desc", width: 130, dataIndex: 'sgtxt', sortable: true},
			{text: "Unit", width: 50, dataIndex: 'meins', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "Create Date", width: 120, dataIndex: 'erdat', sortable: true}
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
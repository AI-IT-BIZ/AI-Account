Ext.define('Account.SMaterial.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"material/load2",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'matnr'
				},
				simpleSortMode: true
			},
			fields: [
			    'matnr',
				'maktx',
			    'matx2',
				'mtart',
				'matx1',
				'meins',
				'saknr',
				'erdat'
			],
			remoteSort: true,
			sorters: [{property: 'matnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Material No", width: 100, dataIndex: 'matnr', sortable: true},
			{text: "Material Name", width: 150, dataIndex: 'maktx', sortable: true},
		    {text: "Material Grp", width: 150, dataIndex: 'matx2', sortable: true},
			{text: "Material Type", width: 80, dataIndex: 'mtart', sortable: true},
			{text: "Mat Type Description", width: 150, dataIndex: 'matx1', sortable: true},
			{text: "Unit", width: 90, dataIndex: 'meins', sortable: true},
			{text: "GL No", width: 100, dataIndex: 'saknr', sortable: true},
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
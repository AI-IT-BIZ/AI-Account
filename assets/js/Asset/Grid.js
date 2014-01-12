Ext.define('Account.Asset.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"asset/loads",
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
			    'serno',
				'mgrpp',
				'saknr',
				'brand',
				'sgtxt',
				'holds',
				'statx',
				'resid',
				'assnr',
				'depnr'
			],
			remoteSort: true,
			sorters: [{property: 'matnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Asset No", width: 100, dataIndex: 'matnr', sortable: true},
			{text: "Asset Name", width: 150, dataIndex: 'maktx', sortable: true},
			{text: "Serial No", width: 100, dataIndex: 'serno', sortable: true},
		    {text: "Asset Grp", width: 100, dataIndex: 'mgrpp', sortable: true},
		    {text: "Brand", width: 120, dataIndex: 'brand', sortable: true},
			{text: "GL No", width: 80, dataIndex: 'saknr', sortable: true},
			{text: "GL Description", width: 150, dataIndex: 'sgtxt', sortable: true},
			{text: "Asset Holder", width: 80, dataIndex: 'meins', sortable: true},
			{text: "Department", width: 100, dataIndex: 'depnr', sortable: true},
			{text: "Residual Value", width: 100, dataIndex: 'resid', sortable: true},
			{text: "Under Asset", width: 80, dataIndex: 'assnr', sortable: true},
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
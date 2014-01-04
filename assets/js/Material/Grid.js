Ext.define('Account.Material.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"material/loads",
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
			    //'mtype',
				'mgrpp',
				'saknr',
				'meins',
				'sgtxt',
				'erdat',
				'statx',
				'cost1',
				'unit1',
				'cost2',
				'unit2',
				'cost3',
				'unit3'
			],
			remoteSort: true,
			sorters: [{property: 'matnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Material No", width: 100, dataIndex: 'matnr', sortable: true},
			{text: "Material Name", width: 150, dataIndex: 'maktx', sortable: true},
			//{text: "Material Type", width: 120, dataIndex: 'mtype', sortable: true},
		    {text: "Material Grp", width: 100, dataIndex: 'mgrpp', sortable: true},
			{text: "GL No", width: 80, dataIndex: 'saknr', sortable: true},
			{text: "GL Description", width: 150, dataIndex: 'sgtxt', sortable: true},
			{text: "Unit", width: 60, dataIndex: 'meins', sortable: true},
			{text: "Create Date", width: 100, dataIndex: 'erdat', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "Unit 1", width: 50, dataIndex: 'unit1', sortable: true},
			{text: "Cost 1", width: 80, dataIndex: 'cost1', sortable: true},
			{text: "Unit 2", width: 50, dataIndex: 'unit2', sortable: true},
			{text: "Cost 2", width: 80, dataIndex: 'cost2', sortable: true},
			{text: "Unit 3", width: 50, dataIndex: 'unit3', sortable: true},
			{text: "Cost 3", width: 80, dataIndex: 'cost3', sortable: true}
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
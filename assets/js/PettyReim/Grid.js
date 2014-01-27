Ext.define('Account.PettyReim.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"pettyreim/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'remnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'remnr',
				'bldat',
				'lifnr',
				'name1',
				'netwr',
				'statx'
			],
			remoteSort: true,
			sorters: [{property: 'remnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Petty Cash Doc", flex: true, dataIndex: 'invnr', 
			align: 'center', sortable: true},
			{text: "Petty Cash Date", width: 125, 
			xtype: 'datecolumn',
			align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			//{text: "GR Doc", flex: true, dataIndex: 'mbeln', 
			//align: 'center', sortable: true},
			{text: "Vendor Code", flex: true, dataIndex: 'lifnr', 
			align: 'center', sortable: true},
			{text: "Vendor Name", flex: true, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", flex: true, 
			xtype: 'numbercolumn', align: 'right',
			dataIndex: 'netwr', sortable: true},
			{text: "Petty Cash Status", flex: true, dataIndex: 'statx', sortable: true}
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
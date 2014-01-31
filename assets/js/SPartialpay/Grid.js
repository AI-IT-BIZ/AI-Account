Ext.define('Account.SPartialpay.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"po/loads_partial",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vbeln,paypr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'vbeln',
				'paypr',
				'sgtxt',
				'duedt',
				'perct',
				'pramt',
				'ctyp1'
			],
			remoteSort: true,
			sorters: [{property: 'paypr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "Doc No", flex: true, dataIndex: 'vbeln', 
			align: 'center',sortable: true},
			{text: "Periods No.", flex: true, dataIndex: 'paypr', 
			align: 'center',sortable: true},
			{text: "Period Description", flex: true, dataIndex: 'sgtxt', sortable: true},
			{text: "Period Date", width: 125, 
			xtype: 'datecolumn',
			align: 'center', format:'d/m/Y',
			dataIndex: 'duedt', sortable: true},
			{text: "Amount/ %", flex: true, dataIndex: 'perct',
			align: 'center', sortable: true},

			{text: "Partial Amount", xtype: 'numbercolumn',align: 'right',
			flex: true, dataIndex: 'pramt', sortable: true},
			{text: "Currency", dataIndex: 'ctyp1', sortable: true}
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
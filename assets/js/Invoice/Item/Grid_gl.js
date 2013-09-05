Ext.define('Account.Invoice.Item.Grid_gl', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"invoice/loads_gl_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'belnr'
				}
			},
			fields: [
				'saknr',
				'sgtxt',
				'debit',
				'credi'
			],
			remoteSort: true,
			sorters: ['saknr ASC']
		});

		this.columns = [
		    {
			id : 'RowNumber2',
			header : "No.",
			dataIndex : 'paypr',
			width : 90,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
		}
		},
		    {text: "GL No.", width: 120, dataIndex: 'saknr', sortable: true},
			{text: "GL Description", width: 300, dataIndex: 'sgtxt', sortable: true},
		    {text: "Debit", width: 150, dataIndex: 'debit', sortable: true},
			{text: "Credit", width: 150, dataIndex: 'credi', sortable: true}
		];

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
	}
});
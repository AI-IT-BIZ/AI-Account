Ext.define('Account.RJournal.GL.GLGrid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"journal/loads_jv_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'belnr,belpr'
				}
			},
			fields: [
			    'belnr',
			    'belpr',
			    'saknr',
			    'sgtxt',
				'debit',
			    'credi'
			],
			remoteSort: true,
			sorters: ['belnr ASC']
		});

		this.columns = [
		    {text: "Journal No", 
		    width: 100, align: 'center', dataIndex: 'belnr', sortable: true},
		    {text: "Journal Items", 
		    width: 100, align: 'center', dataIndex: 'belpr', sortable: true},
		    {text: "GL No.", 
		    width: 80, align: 'center', dataIndex: 'saknr', sortable: true},
		    {text: "GL Name", 
		    width: 200, dataIndex: 'sgtxt', sortable: true},

			{text: "Debit", 
			width: 90, align: 'right', dataIndex: 'debit', sortable: true},
			{text: "Credit", 
			width: 90, align: 'right', dataIndex: 'credi', sortable: true}
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
		this.store.load({
			params: options
		});
	}
});
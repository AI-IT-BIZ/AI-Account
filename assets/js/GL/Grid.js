Ext.define('Account.GL.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"gl/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'saknr'
				}
			},
			fields: [
			'saknr',
			'sgtxt',
			'gltyp'
			],
			remoteSort: true,
			sorters: ['saknr ASC']
		});

		this.columns = [
		    {text: "GL No", width: 100, dataIndex: 'saknr', sortable: true},
			{text: "GL Name", width: 250, dataIndex: 'sgtxt', sortable: true},
			{xtype: 'hidden',
			width: 0, 
			dataIndex: 'gltyp'}
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
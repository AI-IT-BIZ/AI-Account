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
			'gltyp',
			'glgrp',
			'gllev',
			'under'
			],
			remoteSort: true,
			sorters: ['jobnr ASC']
		});

		this.columns = [
		    {text: "GL No", width: 100, dataIndex: 'saknr', sortable: true},
			{text: "GL Name", width: 150, dataIndex: 'sgtxt', sortable: true},
		    {text: "GL Type", width: 100, dataIndex: 'gltyp', sortable: true},
			{text: "GL Group", width: 150, dataIndex: 'glgrp', sortable: true},
			{text: "GL Level", width: 90, dataIndex: 'gllev', sortable: true},
			{text: "Under GL", width: 100, dataIndex: 'under', sortable: true}
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
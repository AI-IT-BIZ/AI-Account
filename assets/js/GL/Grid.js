Ext.define('Account.GL.Grid', {
	extend	: 'Ext.grid.Panel',
	requires: [
		'Ext.ux.grid.FiltersFeature'
	],
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		var filters = {
			ftype: 'filters',
			encode: false,
			local: true,
			filters: [{
				type: 'boolean',
				dataIndex: 'visible'
			}]
		};
		
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"gl/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'saknr'
				},
				simpleSortMode: true
			},
			fields: [
			'saknr',
			'sgtxt',
			'gltyp'
			],
			remoteSort: true,
			sorters: [{property: 'saknr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "GL No", width: 100, dataIndex: 'saknr',
		     filterable:true, filter: {type: 'string'}, sortable: true},
			{text: "GL Name", width: 250, dataIndex: 'sgtxt',
			 filterable:true, filter: {type: 'string'}, sortable: true},
			{text: "1",hidden: true,
			width: 0, 
			sortable: false, 
			dataIndex: 'gltyp'}
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: this.store,
			displayInfo: true
		};
		
		this.grid = Ext.create('Ext.grid.Panel',{
			store: this.store,
			columns: this.columns,
			forceFit: true,
			features: [{
				id: 'group',
				ftype: 'groupingsummary',
				groupHeaderTpl: '{name}',
				hideGroupedHeader: false,
				enableGroupingMenu: true,
				startCollapsed: true
			},filters]
		});

		return this.callParent(arguments);
	},
	
	load: function(options){
		this.store.load(options);
	}
});
Ext.define('Account.SCurrency.Grid', {
	extend	: 'Ext.grid.Panel',
	requires: [
		'Ext.ux.grid.FiltersFeature'
	],
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		
		Ext.QuickTips.init();
		var filters = {
			ftype: 'filters',
			local: true,
			filters: [{
				type: 'string',
				dataIndex: 'ctype'
			},{
				type: 'string',
				dataIndex: 'curtx'
			}]
		};

		this.store = new Ext.data.JsonStore({
			pageSize: 25,
			proxy: {
				type: 'ajax',
				url: __site_url+"currency/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'ctype',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'ctype',
				'curtx'
			],
			remoteSort: true,
			sorters: [{property: 'ctype', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Currency Code",
		    width: 80, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "Currency Name",
			width: 250, dataIndex: 'curtx', sortable: true}
		];

		this.bbar = Ext.create('Ext.PagingToolbar', {
			store: this.store,
			displayInfo: true
		});
		
		Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});


		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
	}
});
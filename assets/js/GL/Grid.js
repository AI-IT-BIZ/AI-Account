Ext.define('GL', {
    extend: 'Ext.data.Model',
    fields: [{
        name: 'gltyp',
        type: 'int'
    },{
        name: 'saknr',
		type: 'string'
    },{
        name: 'sgtxt',
		type: 'string'
    }]
});

Ext.define('Account.GL.Grid', {
	extend	: 'Ext.grid.Panel',
	requires: [
		'Ext.ux.grid.FiltersFeature'
	],
	
	initComponent : function() {
		Ext.QuickTips.init();
		var filters = {
			ftype: 'filters',
			local: true,
			filters: [{
				type: 'string',
				dataIndex: 'saknr'
			},{
				type: 'string',
				dataIndex: 'sgtxt'
			}]
		};
		this.store = Ext.create('Ext.data.JsonStore', {
			autoDestroy: true,
			autoLoad: true,
			model: 'GL',
			proxy: {
				type: 'ajax',
				url: __site_url+"gl/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'saknr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			remoteSort: true,
			sorters: [{property: 'saknr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "GL No", width: 100, dataIndex: 'saknr', sortable: true},
			{text: "GL Name", width: 250, dataIndex: 'sgtxt', sortable: true},
			{text: "1",hidden: true, width: 0, sortable: false, dataIndex: 'gltyp'}
		];

		Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});
			
		this.callParent(arguments);
	},
	
	load: function(options){
		this.store.load(options);
	}
});
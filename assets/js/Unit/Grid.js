//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Unit.Grid', {
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
				dataIndex: 'meins'
			},{
				type: 'string',
				dataIndex: 'metxt'
			},{
				type: 'string',
				dataIndex: 'ernam'
			},{
				type: 'string',
				dataIndex: 'erdat'
			}]
		};
		
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'unit/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'meins',
					totalProperty: 'totalCount'
				}
			},
			fields: [
			   // { name:'id_depnr2', type:'int'},
			    'meins',
				'metxt',
				'ernam',
				'erdat'
			],
			remoteSort:true,
			sorters: [{property: 'meins', direction: 'ASC'}],
			pageSize: 10000000
		});

		this.columns = [
			{
			text: "Unit Code", 
			width: 100,
			dataIndex: 'meins', 
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
		},{
			text: "Unit", width: 125, 
			dataIndex: 'metxt', 
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			},{text: "Create Name",
			width: 100, dataIndex: 'ernam', sortable: true},
			{text: "Create Date",
			width: 100, dataIndex: 'erdat', sortable: true}];
		
		Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});

		this.bbar = {
			xtype: 'pagingtoolbar',
			//pageSize: 10,
			store: this.store,
			displayInfo: true
		};

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
	}
});



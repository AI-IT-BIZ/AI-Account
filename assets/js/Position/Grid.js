//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Position.Grid', {
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
				dataIndex: 'depnr'
			},{
				type: 'string',
				dataIndex: 'deptx'
			},{
				type: 'string',
				dataIndex: 'posnr'
			},{
				type: 'string',
				dataIndex: 'postx'
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
				url: __site_url+'sposition/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'posnr',
					totalProperty: 'totalCount'
				}
			},
			fields: [
			   // { name:'id_depnr2', type:'int'},
			    'depnr',
				'deptx',
				'posnr',
				'postx',
				'ernam',
				'erdat'
			],
			remoteSort:true,
			sorters: [{property: 'posnr', direction: 'ASC'}],
			pageSize: 10000000
		});

		this.columns = [
			{
			text: "Department Code", 
			width: 100,
			dataIndex: 'depnr', 
			sortable: true
		},{
			text: "Department", width: 125, 
			dataIndex: 'deptx', 
			sortable: true
			},{
			text: "Position Code", width: 100, 
			dataIndex: 'posnr', 
			sortable: true
			},{
			text: "Position", width: 150, 
			dataIndex: 'postx', 
			sortable: true
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



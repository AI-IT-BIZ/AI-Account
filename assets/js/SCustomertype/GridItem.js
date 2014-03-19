Ext.define('Account.SCustomertype.GridItem', {
	extend	: 'Ext.grid.Panel',
	requires: [
		'Ext.ux.grid.FiltersFeature'
	],
	constructor:function(config) {
		
		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		Ext.QuickTips.init();
		var filters = {
			ftype: 'filters',
			local: true,
			filters: [{
				type: 'string',
				dataIndex: 'ktype'
			},{
				type: 'string',
				dataIndex: 'custx'
			},{
				type: 'string',
				dataIndex: 'saknr'
			},{
				type: 'string',
				dataIndex: 'sgtxt'
			}]
		};

		//this.tbar = [this.addAct, this.deleteAct];

		//this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
		//	clicksToEdit: 1
		//});

		this.store = new Ext.data.JsonStore({

			proxy: {
				type: 'ajax',
				url: __site_url+'customertype/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'ktype',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
				//{ name:'id_ktype', type:'int' },
				'ktype',
				'custx',
				'saknr',
				'sgtxt'
			],
			remoteSort: true,
		    sorters: [{property: 'ktype', direction: 'ASC'}],
			pageSize: 10000000
		});

		this.columns = [{
			text: "Customer Type",
		    width: 80,
		    dataIndex: 'ktype',
		    sortable: true,
		    //field: {
			//	type: 'textfield',
			//},
		},{
			text: "Type Description",
		    width: 150,
		    dataIndex: 'custx',
		    sortable: true,
		    //field: {
			//	type: 'textfield',
			//},
		},{
			text: "GL no", 
			width: 100,
			dataIndex: 'saknr', 
			sortable: true
		},{
			text: "GL Description",
			width: 170, 
			dataIndex: 'sgtxt', 
			sortable: true
		}];
		
		this.bbar = {
			xtype: 'pagingtoolbar',
		//	pageSize: 10,
			store: this.store,
			displayInfo: true
		};

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
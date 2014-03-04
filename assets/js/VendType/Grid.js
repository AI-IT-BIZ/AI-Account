//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.VendType.Grid', {
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
				dataIndex: 'vtype'
			},{
				type: 'string',
				dataIndex: 'ventx'
			},{
				type: 'string',
				dataIndex: 'saknr'
			},{
				type: 'string',
				dataIndex: 'sgtxt'
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
				url: __site_url+'vendortype/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vtype',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
				'vtype',
				'ventx',
				'saknr',
				'sgtxt',
				'ernam',
				'erdat'
			],
			remoteSort:true,
			sorters: [{property: 'vtype', direction: 'ASC'}]
		});

		this.columns = [/*{
			//id : 'CSiRowNumber77',
			text: "No",
			dataIndex : 'id_ktype',
			width : 60,
			align : 'center',
			//hidden: true,
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},*/{
			text: "Type Code",
		    width: 80,
		    dataIndex: 'vtype',
		    maxLenges: 4,
		    sortable: true
		},{
			text: "Type Description",
		    width: 150,
		    dataIndex: 'ventx',
		    sortable: true,
		    maxLenges: 100
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


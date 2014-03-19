//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.Bankname.Grid', {
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
				dataIndex: 'bcode'
			},{
				type: 'string',
				dataIndex: 'bname'
			},{
				type: 'string',
				dataIndex: 'addrs'
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
				url: __site_url+'bankname/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'bcode',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
				'bcode',
				'bname',
				'addrs',
				'saknr',
				'sgtxt',
				'ernam',
				'erdat'
			],
			remoteSort:true,
			sorters: [{property: 'bcode', direction: 'ASC'}],
			pageSize: 10000000
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
		},*/{text: "Bank Code", align: 'center',
			width: 100, dataIndex: 'bcode', 
			sortable: true,
			//maxLenges: 4
			},
			{text: "Bank Name", 
			width: 150, dataIndex: 'bname', 
			sortable: true,
			maxLenges: 60
			},
			{text: "Address", 
			width: 125, dataIndex: 'addrs', 
			sortable: true,
			//maxLenges: 100
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



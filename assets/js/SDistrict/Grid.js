//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.SDistrict.Grid', {
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
				dataIndex: 'distr'
			},{
				type: 'string',
				dataIndex: 'distx'
			}]
		};
		
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'sdistrict/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'distr',
					totalProperty: 'totalCount'
				}
			},
			fields: [
				'distr',
				'distx'
			],
			remoteSort: false,
			sorters: ['distr ASC'],
		});

		this.columns = [
			{text: "District no", width: 125, dataIndex: 'distr', sortable: true},
			{text: "District Description", flex: true, dataIndex: 'distx', sortable: true},
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 10,
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
		//if(options){ alert(options); }
	}
});

/*
var store = new Ext.data.JsonStore({
		// store configs
		proxy: {
			type: 'ajax',
			url: '<?= site_url("pr/loads") ?>',
			reader: {
				type: 'json',
				root: 'rows',
				idProperty: 'id'
			}
		},
		fields: [
			{name:'id', type: 'int'},
			'code',
			{name:'create_date'},
			'create_by',
			{name:'update_date'},
			'update_by'
		],
		remoteSort: true,
		sorters: ['id ASC']
	});

	// create the grid
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		columns: [
			{text: "Id", width: 120, dataIndex: 'id', sortable: true},
			{text: "รหัส", flex: true, dataIndex: 'code', sortable: true},
			{text: "create_date", width: 125, dataIndex: 'create_date', sortable: true}
		],
		forceFit: true,
		height:210,
		split: true,
		region: 'center',
		tbar : [
			addAct
		],
		bbar: {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: store,
			displayInfo: true
		}
	});
*/

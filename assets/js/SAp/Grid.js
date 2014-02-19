Ext.define('Account.SAp.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"ap/loads_inp",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'invnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'invnr',
			    'ebeln',
				'bldat',
				'lifnr',
				'name1',
				'netwr',
				'statx',
				'refnr',
				'sgtxt',
				'ctype',
				'wht01',
				'vat01',
				'loekz',
				'beamt',
				'dismt',
				'erdat',
				'ernam',
				'updat',
				'upnam'
				
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "AP Doc", width: 100,  dataIndex: 'invnr',
			align: 'center', sortable: true},
			{text: "AP Date", width: 85, format:'d/m/Y',
			align: 'center',dataIndex: 'bldat', sortable: true},
			{text: "Ref Doc", width: 100, dataIndex: 'ebeln', 
			align: 'center', sortable: true},
			{text: "Vendor Code", width: 100,
			align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", width: 100, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", width: 100, xtype: 'numbercolumn',
			align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "AP Status", width: 80, 
			align: 'center', dataIndex: 'statx', sortable: true},
			{text: "Currency", width: 100,
			align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "Create Name",
			width: 100, dataIndex: 'ernam', sortable: true},
			{text: "Create Date",
			width: 120, dataIndex: 'erdat', sortable: true},
			{text: "Update Name",
			width: 100, dataIndex: 'upnam', sortable: true},
			{text: "Update Date",
			width: 120, dataIndex: 'updat', sortable: true},
			{text: "1",hidden: true,width: 0, dataIndex: 'wht01', sortable: false},
			{text: "2",hidden: true,width: 0, dataIndex: 'vat01', sortable: false},
			{text: "3",hidden: true,width: 0, dataIndex: 'loekz', sortable: false},
			{text: "4",hidden: true,width: 0, dataIndex: 'beamt', sortable: false},
			{text: "5",hidden: true,width: 0, dataIndex: 'dismt', sortable: false},
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
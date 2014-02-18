Ext.define('Account.DepositOut.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"depositout/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'depnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'depnr',
				'bldat',
				'ebeln',
				'lifnr',
				'name1',
				'txz01',
				'statx',
				'netwr',
				'ctype',
				'erdat',
				'ernam',
				'updat',
				'upnam'
			],
			remoteSort: true,
			sorters: [{property: 'depnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Deposit No", 
		    width: 100, align: 'center', dataIndex: 'depnr', sortable: true},
			{text: "Doc Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'bldat', sortable: true},
            {text: "PO No", 
		    width: 80, align: 'center', dataIndex: 'ebeln', sortable: true},
		    {text: "Vendor No", 
		    width: 80, align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", 
			width: 150, dataIndex: 'name1', sortable: true},
			{text: "Text Note", 
			width: 200, dataIndex: 'txz01', sortable: true},
			{text: "Status", 
			width: 100, dataIndex: 'statx', sortable: true},
			{text: "Amount", 
			xtype: 'numbercolumn',
			width: 80, align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Currency", 
			width: 60, align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "Create Name",
			width: 100, dataIndex: 'ernam', sortable: true},
			{text: "Create Date",
			width: 120, dataIndex: 'erdat', sortable: true},
			{text: "Update Name",
			width: 100, dataIndex: 'upnam', sortable: true},
			{text: "Update Date",
			width: 120, dataIndex: 'updat', sortable: true}
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
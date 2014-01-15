Ext.define('Account.RPayment.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"payment/loads_report",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.payno+o.vbelp; }//'invnr'
				},
				simpleSortMode: true
			},
			fields: [
			    'payno',
				'bldat',
				//'duedt',
				'lifnr',
				'name1',
				//'txz01',
				'netwr',
				'statx',
				'invnr',
				'invdt',
				'itamt',
				'netwr',
				'paytx'
			],
			remoteSort: true,
			sorters: [{property: 'payno', direction: 'ASC'}],
		});

		this.columns = [
		    {text: "Payment No", 
		    width: 100, align: 'center', dataIndex: 'payno', sortable: true},
			{text: "Doc Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'bldat', sortable: true},
			
		    {text: "Vendor No", 
		    width: 80, align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", 
			width: 200, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", xtype: 'numbercolumn',
			width: 100, align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Status", 
			width: 120, dataIndex: 'statx', sortable: true},
			{text: "Paymented by", 
			width: 120, dataIndex: 'paytx', align: 'left', sortable: true},
			
			{text: "AP No", 
			width: 100, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "AP Date", 
			width: 80, dataIndex: 'invdt', align: 'center', sortable: true},
			
			{text: "Amount", xtype: 'numbercolumn',
			width: 100, dataIndex: 'itamt', align: 'right', sortable: true}
			
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
		this.store.load({
			params: options
		});
	}
});
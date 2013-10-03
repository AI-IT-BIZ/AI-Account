Ext.define('Account.Payment.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"payment/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'payno'
				}
			},
			fields: [
			    'payno',
				'bldat',
				'duedt',
				'lifnr',
				'name1',
				'txz01',
				'netwr'
			],
			remoteSort: true,
			sorters: ['payno ASC']
		});

		this.columns = [
		    {text: "Payment No", 
		    width: 120, align: 'center', dataIndex: 'payno', sortable: true},
			{text: "Doc Date", xtype: 'datecolumn', format:'d/m/Y',width: 80, align: 'center', 
			dataIndex: 'bldat', sortable: true},
			{text: "Payment Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', 
			dataIndex: 'duedt', sortable: true},
		    {text: "Vendor No", 
		    width: 80, align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", 
			width: 200, dataIndex: 'name1', sortable: true},
			{text: "Text Note", 
			width: 250, dataIndex: 'txz01', sortable: true},
			{text: "Amount", 
			width: 80, align: 'right', dataIndex: 'netwr', sortable: true}
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
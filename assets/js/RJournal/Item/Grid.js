Ext.define('Account.RJournal.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"journal/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'belnr'
				}
			},
			fields: [
			    'belnr',
			    'typtx',
			    'bldat',
				'tranr',
			    'txz02',
				'txz01',
				'netwr'
				//'ctype'
			],
			remoteSort: true,
			sorters: ['belnr ASC']
		});

		this.columns = [
		    {text: "Journal No", 
		    width: 100, align: 'center', dataIndex: 'belnr', sortable: true},
		    {text: "Journal Type", 
		    width: 80, align: 'center', dataIndex: 'typtx', sortable: true},
			{text: "Document Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'bldat', sortable: true},
			{text: "Template Code", 
		    width: 80, align: 'center', dataIndex: 'tranr', sortable: true},
		    {text: "Template Name", 
		    width: 160, dataIndex: 'txz02', sortable: true},
		    {text: "Description", 
		    width: 200, dataIndex: 'txz01', sortable: true},
			{text: "Amount", 
			width: 70, align: 'right', dataIndex: 'netwr', sortable: true}
			//{text: "Currency", 
			//width: 60, align: 'center', dataIndex: 'ctype', sortable: true}
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
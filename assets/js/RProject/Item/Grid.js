Ext.define('Account.RProject.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"project/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'jobnr'
				}
			},
			fields: [
			    'jobnr',
				'jobtx',
				'bldat',
				'kunnr',
				'name1',
				
				'statx',
				'sname',
				'pramt',
				'ctype'
			],
			remoteSort: true,
			sorters: ['jobnr ASC']
		});

		this.columns = [
		    {text: "Project No", 
		    width: 100, align: 'center', dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", 
			width: 150, dataIndex: 'jobtx', sortable: true},
			{text: "Project Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'bldat', sortable: true},
		    {text: "Customer No", 
		    width: 100, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", 
			width: 100, dataIndex: 'name1', sortable: true},
			
			{text: "Status", 
			width: 100, dataIndex: 'statx', sortable: true},
			{text: "Sale Name", 
			width: 120, dataIndex: 'sname', sortable: true},
			{text: "Project Amount", 
			width: 100, align: 'right', dataIndex: 'pramt', sortable: true},
			{text: "Currency", 
			width: 80, align: 'center', dataIndex: 'ctype', sortable: true}
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
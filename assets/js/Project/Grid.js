Ext.define('Account.Project.Grid', {
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
			    'kunnr',
				'name1',
				
				'bldat',
				'statx',
				'salnr',
				'sname',
				'stdat',
				'endat',
				'datam'
			],
			remoteSort: true,
			sorters: ['jobnr ASC']
		});

		this.columns = [
		    {text: "Project No", width: 100, dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", width: 150, dataIndex: 'jobtx', sortable: true},
		    {text: "Customer No", width: 100, dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 150, dataIndex: 'name1', sortable: true},
			{text: "Project Date", width: 90, dataIndex: 'bldat', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statx', sortable: true},
			{text: "",
			 xtype: 'hidden',
			width: 0, 
			dataIndex: 'salnr', 
			sortable: true},
			{text: "Sale Person", width: 120, dataIndex: 'sname', sortable: true},
			{text: "Start Date", width: 80, dataIndex: 'stdat', sortable: true},
			{text: "End Date", width: 80, dataIndex: 'endat', sortable: true},
			{text: "Long-term", width: 80, dataIndex: 'datam', sortable: true}
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
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
				},
				simpleSortMode: true
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
				'pramt'
			],
			remoteSort: true,
			sorters: [{property: 'jobnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Project No", 
		    width: 80, align: 'center', dataIndex: 'jobnr', sortable: true},
			{text: "Project Name", 
			width: 150, dataIndex: 'jobtx', sortable: true},
		    {text: "Customer No", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", 
			width: 150, dataIndex: 'name1', sortable: true},
			{text: "Project Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'bldat', sortable: true},
			{text: "Status", 
			width: 120, dataIndex: 'statx', sortable: true},
			{text: "1",
			 hidden: true,
			 width: 0, 
			dataIndex: 'salnr', 
			sortable: true},
			{text: "Sale Person", 
			width: 100, dataIndex: 'sname', sortable: true},
			{text: "Start Date", xtype: 'datecolumn', format:'d/m/Y', 
			width: 80, align: 'center', dataIndex: 'stdat', sortable: true},
			{text: "End Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'endat', sortable: true},
			{text: "Project Amount", 
			xtype: 'numbercolumn',
			width: 90, align: 'right', dataIndex: 'pramt', sortable: true}
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
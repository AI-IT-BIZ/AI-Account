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
				'pramt'
			],
			remoteSort: true,
			sorters: ['jobnr ASC']
		});

		this.columns = [
		    {text: "Project No", 
		    width: 80, align: 'center', dataIndex: 'jobnr', sortable: false},
			{text: "Project Name", 
			width: 150, dataIndex: 'jobtx', sortable: false},
		    {text: "Customer No", 
		    width: 80, align: 'center', dataIndex: 'kunnr', sortable: false},
			{text: "Customer Name", 
			width: 150, dataIndex: 'name1', sortable: false},
			{text: "Project Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'bldat', sortable: false},
			{text: "Status", 
			width: 120, dataIndex: 'statx', sortable: false},
			{text: "",
			 xtype: 'hidden',
			width: 0, 
			dataIndex: 'salnr', 
			sortable: false},
			{text: "Sale Person", 
			width: 100, dataIndex: 'sname', sortable: false},
			{text: "Start Date", xtype: 'datecolumn', format:'d/m/Y', 
			width: 80, align: 'center', dataIndex: 'stdat', sortable: false},
			{text: "End Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'endat', sortable: false},
			{text: "Project Amount", 
			xtype: 'numbercolumn',
			width: 90, align: 'right', dataIndex: 'pramt', sortable: false}
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
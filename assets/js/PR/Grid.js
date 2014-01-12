Ext.define('Account.PR.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"pr/loads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'purnr',
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'purnr',
				'bldat',
				'lifnr',
				'name1',
				'netwr',
				'statx',
				'adr01',
				'distx',
				'pstlz',
				'telf1',
				'telfx',
				'email',
				'ctype'
			],
			remoteSort: true,
			sorters: [{property: 'purnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "PR No", flex: true, dataIndex: 'purnr', 
			align: 'center',sortable: true},
			{text: "PR Date", width: 125, 
			xtype: 'datecolumn',
			align: 'center', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			{text: "Vendor Code", flex: true, dataIndex: 'lifnr',
			align: 'center', sortable: true},
			{text: "Vendor Name", flex: true, dataIndex: 'name1', sortable: true},
			{text: "PR Status", flex: true, dataIndex: 'statx',
			align: 'center', sortable: true},
			{text: "Net Amount", xtype: 'numbercolumn',align: 'right',
			flex: true, dataIndex: 'netwr', sortable: true},
			{text: "Currency", dataIndex: 'ctype', sortable: true},
			{text: "1",hidden: true, width: 0, dataIndex: 'adr01', sortable: false},
			{text: "2",hidden: true, width: 0, dataIndex: 'distx', sortable: false},
			{text: "3",hidden: true, width: 0, dataIndex: 'pstlz', sortable: false},
			{text: "4",hidden: true, width: 0, dataIndex: 'telf1', sortable: false},
			{text: "5",hidden: true, width: 0, dataIndex: 'telfx', sortable: false},
			{text: "6",hidden: true, width: 0, dataIndex: 'email', sortable: false}
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
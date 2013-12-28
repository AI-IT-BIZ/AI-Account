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
					idProperty: 'invnr'
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
				'vat01'
				
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
			{text: "AP Doc", flex: true,  dataIndex: 'invnr',
			align: 'center', sortable: true},
			{text: "AP Date", width: 125, format:'d/m/Y',
			align: 'center',dataIndex: 'bldat', sortable: true},
			{text: "GR Doc", flex: true,dataIndex: 'ebeln', 
			align: 'center', sortable: true},
			{text: "Vendor Code", flex: true, 
			align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", flex: true, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", flex: true, 
			align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "AP Status", width: 80, 
			align: 'center', dataIndex: 'statx', sortable: true},
			{text: "Currency", flex: true,
			align: 'center', dataIndex: 'ctype', sortable: true},
			{text: "1",hidden: true,width: 0, dataIndex: 'wht01', sortable: false},
			{text: "2",hidden: true,width: 0, dataIndex: 'vat01', sortable: false}
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
Ext.define('Account.RGL.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"gl/rloads",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'saknr'
				}
			},
			fields: [
			    'saknr',
				'sgtxt',
				'deb1',
				'cre1'
			],
			remoteSort: true,
			sorters: ['saknr ASC']
		});

		this.columns = [
		    {text: "GL No", 
		    width: 100, align: 'center', dataIndex: 'saknr', sortable: true},
			{text: "GL Name", 
			width: 150, dataIndex: 'sgtxt', sortable: true},
			{text: "Debit", 
			width: 80, align: 'right', dataIndex: 'deb1', sortable: true},
		    {text: "Credit", 
		    width: 100, align: 'right', dataIndex: 'cre1', sortable: true}
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
	},
	
	reset: function(){
		//this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.load({saknr: 0 });
	}
});
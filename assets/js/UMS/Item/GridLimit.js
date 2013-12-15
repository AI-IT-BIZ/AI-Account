Ext.define('Account.UMS.Item.GridLimit', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'ums/loads_doctype_limit',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'empnr'
				},
				simpleSortMode: true
			},
	        fields: [
				{ name: 'comid', type: 'string' },
				{ name: 'empnr', type: 'string' },
				{ name: 'docty', type: 'string' },
				{ name: 'doctx', type: 'string' },
				{ name: 'limam', type: 'float' }
	        ],
			remoteSort: false,
			sorters: [{property: 'docty', direction: 'ASC'}]
		});

		this.columns = [
			{ text: "Employee Code", align: 'center', width: 80, dataIndex: 'comid', sortable: false },
			{ text: "Document Type", align: 'center', width: 80, dataIndex: 'doctx', sortable: false },
			{ text: "Limit", align: 'center', width: 80,  dataIndex: 'limam', sortable: false }
		];

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load({params: options});
	},
	getSelectionId: function(){
		var sel = this.getView().getSelectionModel().getSelection()[0];
		if(!sel) return;
		return sel.data[sel.idField.name];
	},
	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	}
});

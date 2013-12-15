Ext.define('Account.UMS.Item.GridLimit', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

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
			{ text: "Employee Code", align: 'center', width: 80, dataIndex: 'comid', sortable: false, hidden: true },
			{ text: "Document Type", align: 'left', width: 150, dataIndex: 'doctx', sortable: false },
			{ text: "Limit", align: 'right', width: 80,  dataIndex: 'limam', sortable: false, field: {
				type: 'numberfield',
				decimalPrecision: 2
			}, renderer: Ext.util.Format.numberRenderer('0,0.##')}
		];

		this.plugins = [this.editing];

		return this.callParent(arguments);
	},
	load: function(options, cb, scope){
		var prms = {params: options};
		if(cb && typeof(cb)=='function')
			prms['callback'] = cb;
		if(scope)
			prms['scope'] = scope;
		this.store.load(prms);
	},
	getSelectionId: function(){
		var sel = this.getView().getSelectionModel().getSelection()[0];
		if(!sel) return;
		return sel.data[sel.idField.name];
	},
	getData: function(){
		var rs = [];
		this.store.each(function(r){
			if(r.data['limam']>0)
				rs.push(r.getData());
		});
		return rs;
	}
});

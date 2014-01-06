Ext.define('Account.UMS.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'ums/loads_user',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.comid+'$'+o.uname; }
				},
				simpleSortMode: true
			},
			fields: [
			    'comid',
				'empnr',
				'uname',
				'name1',
				'name2',
				'adr01',
				'adr02',
				'ort01',
				'distr',
				'pstlz',
				'telf1',
				'telfx',
				'posit',
				'autnr'
			],
			remoteSort: true,
			sorters: [{property: 'empnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "Company ID", width: 90, dataIndex: 'comid', sortable: true},
			{text: "Employee No", width: 100, dataIndex: 'empnr', sortable: true},
			{text: "Username", width: 100, dataIndex: 'uname', sortable: true},
			{text: "Name", width: 185, dataIndex: 'name1', sortable: true},
			{text: "Position", width: 125, dataIndex: 'posit', sortable: true, hidden: true}
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			store: this.store,
			displayInfo: true
		};

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load({params: options});
	},
	getSelectionId: function(){
		var sel = this.getView().getSelectionModel().getSelection()[0];
		if(!sel) return;
		var retId = sel.data[sel.idField.name];
		var retIds = retId.split('$');
		if(retIds.length==2)
			return retIds[1];
		else
			return;
	}
});

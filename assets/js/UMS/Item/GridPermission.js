Ext.define('Account.UMS.Item.GridPermission', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'ums/loads_permission',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'empnr'
				},
				simpleSortMode: true
			},
	        fields: [{ name: 'doctx', type: 'string' },
	                 { name: 'docty', type: 'string' },
	                 { name: 'display', type: 'string' },
	                 { name: 'create', type: 'string' },
	                 { name: 'edit', type: 'string' },
	                 { name: 'delete', type: 'string' },
	                 { name: 'export', type: 'string' },
	                 { name: 'approve', type: 'string' },
	                 { name: 'uname', type: 'string' }
	        ],
			remoteSort: false,
			sorters: [{property: 'doctx', direction: 'ASC'}]
		});

		this.columns = [
			{id:'doctx', text: "Doc Type", align: 'left', width: 160, dataIndex: 'doctx', sortable: false },
			{ text: "Display", align: 'center', width: 80,renderer:this.renderAuthenField, dataIndex: 'display', sortable: false },
			{ text: "Create", align: 'center', width: 80,renderer:this.renderAuthenField, dataIndex: 'create', sortable: false },
			{ text: "Edit", align: 'center', width: 80, renderer:this.renderAuthenField,  dataIndex: 'edit', sortable: false },
			{ text: "Delete", align: 'center', width: 80, renderer:this.renderAuthenField,  dataIndex: 'delete', sortable: false },
			{ text: "Export", align: 'center', width: 80, renderer:this.renderAuthenField,  dataIndex: 'export', sortable: false },
			{ text: "Approve", align: 'center', width: 80, renderer:this.renderAuthenField,  dataIndex: 'approve', sortable: false }
		];

		this.on('cellclick', function (grid, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
			if(cellIndex>=1 && cellIndex<=6){
				var fieldName = this.columns[cellIndex].dataIndex,
					val = record.get(fieldName);
				record.set(fieldName, (val=='0')?'1':'0');
			}
		});

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
	renderAuthenField: function(v,p,r)
	{
		return (v == 1)?"<img src='assets/images/icons/accept.png' />":"<img src='assets/images/icons/cross.png' />";
	},
	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	}
});

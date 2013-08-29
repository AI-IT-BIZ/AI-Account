Ext.define('Account.Quotation.Item.Grid_p', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	
	initComponent : function() {
		var _this=this;

		this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus'
		});
		this.copyAct = new Ext.Action({
			text: 'Copy',
			iconCls: 'b-small-copy'
		});
		//this.deleteAct = new Ext.Action({
		//	text: 'Delete',
		//	iconCls: 'b-small-minus'
		//});
		
		this.tbar = [this.addAct, this.copyAct];
		
		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});
		
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"Quotation/loads_pay_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'paypr'
				}
			},
			fields: [
				'paypr',
				'sgtxt',
				'duedt',
				'perct',
				'pramt',
				'ctype'
			],
			remoteSort: true,
			sorters: ['vbeln ASC']
		});

		this.columns = [{
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete QT Payment',
				scope: this,
				handler: this.removeRecord
			}]
			},
		    {text: "Period No", width: 80, dataIndex: 'paypr', sortable: true,
		    field: {
				type: 'textfield'
			},
			},
			{text: "Period Desc.", width: 300, dataIndex: 'sgtxt', sortable: true,
			field: {
				type: 'textfield'
			},
			},
		    {text: "Period Date", width: 100, dataIndex: 'duedt', sortable: true,
		    field: {
				type: 'datefield'
			},
			},
			{text: "Percent", 
			width: 100, 
			dataIndex: 'perct', 
			sortable: true,
			align: 'right',
			field: {
				type: 'numberfield'
			},
			},
			{text: "Amount", 
			width: 150, 
			dataIndex: 'pramt', 
			sortable: true,
			align: 'right',
			field: {
				type: 'numberfield'
			},
			},
			{text: "Currency", 
			width: 100, 
			dataIndex: 'ctype', 
			sortable: true,
			align: 'center',
			field: {
				type: 'textfield'
			},
			}
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: this.store,
			displayInfo: true
		};
		
		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
		});

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
	},
	
	addRecord: function(){
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;

		// add new record
		rec = { id:newId, paypr:'', sgtxt:'', duedt:'', ctype:'THB' };
		edit = this.editing;
		edit.cancelEdit();
		var lastRecord = this.store.count();
		this.store.insert(lastRecord, rec);
		edit.startEditByPosition({
			row: lastRecord,
			column: 0
		});
	},
	
	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);
	},
	
	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	}
});
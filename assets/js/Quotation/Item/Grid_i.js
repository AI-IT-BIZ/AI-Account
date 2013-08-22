Ext.define('Account.Quotation.Item.Grid_i', {
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

		this.tbar = [this.addAct, this.deleteAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing');
		
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"Quotation/loads_qt_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vbeln'
				}
			},
			fields: [
			    'vbeln',
				'vbelp',
				'matnr',
				'menge',
				'meins',
				'unitp',
				'dismt',
				'itamt',
				'ctype'
			],
			remoteSort: true,
			sorters: ['vbeln ASC']
		});

		this.columns = [
		    {text: "Items", width: 70, dataIndex: 'vbelp', sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
			{text: "Material Code", width: 120, dataIndex: 'matnr', sortable: false,
			field: {
				type: 'textfield'
			},
			},
		    {text: "Description", width: 200, dataIndex: 'maktx', sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
			{text: "Qty", width: 70, dataIndex: 'menge', sortable: false,
			field: {
				type: 'numberfield',
				//decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			},
			{text: "Unit", width: 50, dataIndex: 'meins', sortable: false,
			field: {
				type: 'textfield'
			},
			},
			{text: "Price/Unit", width: 120, dataIndex: 'unitp', sortable: false,
			field: {
				type: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			},
			{text: "Discount", width: 100, dataIndex: 'dismt', sortable: false,
			field: {
				type: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			},
			{text: "Amount", width: 120, dataIndex: 'itamt', sortable: false,
			field: {
				type: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},
			},
			{text: "Currency", width: 100, dataIndex: 'ctype', sortable: false,
			field: {
				type: 'textfield'
			},
		},{
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/delete.gif',
				tooltip: 'Delete QT Item',
				scope: this,
				handler: this.removeRecord
			}]
			}];

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
		rec = { id:newId, code:'', price:0, amount:1 };
		edit = this.editing;
		edit.cancelEdit();
		this.store.insert(0, rec);
		edit.startEditByPosition({
			row: 0,
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
Ext.define('Account.PR2.Item.GridItem', {
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
				url: __site_url+"pr2/loads_pr_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id'
				}
			},
			fields: [
				{ name:'id', type:'int' },
				'purpo',
				{ name:'pr_id', type:'int' },
				{ name:'menge', type:'float' },
				'meins',
				'metxt',
				'matnr',
				'maktx',
				{ name:'itamt', type:'float' },
				{ name:'unitp', type:'decimal' },
				{ name:'dismt', type:'decimal' }
				
				
			],
			remoteSort: false
		});

		this.columns = [{
			text: "Material", width: 80, dataIndex: 'matnr', sortable: true,
			field: {
				type: 'textfield'
			},
			sortable: false
		}, {
			text: "Material Description", flex: true, dataIndex: 'maktx', sortable: true,
			field: {
				type: 'textfield'
			},
			sortable: false
		}, {
			text: "Amount", width: 50, dataIndex: 'itamt', sortable: true,
			field: {
				type: 'numberfield',
				/*decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}*/
			},
			sortable: false
		}, {
			text: "Unit", width: 80, dataIndex: 'meins', sortable: true,
			field: {
				type: 'textfield'
			},
			sortable: false
		}, {
			text: "Unit Desc", width: 100, dataIndex: 'metxt', sortable: true,
			field: {
				type: 'textfield'
			},
			sortable: false
		}, {
			text: "Unit/Price", width: 80, dataIndex: 'unitp', sortable: true,
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
			sortable: false
		}, {
			text: "Discount", width: 80, dataIndex: 'dismt', sortable: true,
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
			sortable: false
		}, {
			text: "Total", width: 100, sortable: true,
			field: {
				type: 'textfield'
			},
			sortable: false
		}, {
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/delete.gif',
				tooltip: 'Delete PR Item',
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
		this.store.load({
			params: options
		});
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
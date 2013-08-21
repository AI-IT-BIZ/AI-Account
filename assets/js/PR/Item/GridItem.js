Ext.define('Account.PR.Item.GridItem', {
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
				url: __site_url+"pr/loads_pr_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id'
				}
			},
			fields: [
				{ name:'id', type:'int' },
				'code',
				{ name:'pr_id', type:'int' },
				{ name:'price', type:'float' },
				{ name:'amount', type:'float' }
			],
			remoteSort: false
		});

		this.columns = [{
			text: "Code", flex: true, dataIndex: 'code', sortable: true,
			field: {
				type: 'textfield'
			},
			sortable: false
		}, {
			text: "Price", width: 100, dataIndex: 'price', sortable: true,
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
			text: "Amount", width: 100, dataIndex: 'amount', sortable: true,
			field: {
				type: 'numberfield',
				decimalPrecision: 2
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
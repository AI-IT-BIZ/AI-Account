Ext.define('Account.DepositOut.Item.Grid_i', {
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

		// INIT Invoice search popup /////////////////////////////////
		// this.invoiceDialog = Ext.create('Account.SInvoice.MainWindow');
		// END Invoice search popup //////////////////////////////////

		this.tbar = [this.addAct, this.copyAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"depositout/loads_dp_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'depnr,vbelp'
				}
			},
			fields: [
			    //'vbeln',
			    'vbelp',
				'matnr',
				'maktx',
				'menge',
				'meins',
				'unitp',
				'disit',
				'itamt',
				'ctype',
				'chk01'
			],
			remoteSort: true,
			sorters: ['ebelp ASC']
		});

		this.columns = [{
			xtype: 'actioncolumn',
			text: " ",
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete Deposit Payment',
				scope: this,
				handler: this.removeRecord2
			}]
			},{
			id : 'RowNumber44',
			text : "No.",
			dataIndex : 'vbelp',
			width : 90,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
		}
			},{
			text: "Material Code",
			width: 80,
			dataIndex: 'matnr',
			align : 'center',
			sortable: true,
			field: {
				type: 'textfield'
			}
			},{
			text: "Material Desc.",
			width: 220,
			dataIndex: 'maktx',
			sortable: true,
			field: {
				type: 'textfield'
			}
			},
			{text: "Qty",
			xtype: 'numbercolumn',
			width: 70,
			dataIndex: 'menge',
			sortable: false,
			align: 'right',
			editor: {
				xtype: 'textfield'
			}
			},
			{text: "Unit", width: 50, dataIndex: 'meins', sortable: false,
			field: {
				type: 'textfield'
			}
			},
			{text: "Price/Unit",
			xtype: 'numbercolumn',
			width: 100,
			dataIndex: 'unitp',
			sortable: false,
			align: 'right',
			field: {
				type: 'textfield'
			}
			},
			{text: "Discount",
			xtype: 'numbercolumn',
			width: 80,
			dataIndex: 'disit',
			sortable: false,
			align: 'right',
			field: {
				type: 'textfield'
			}
			},{
            xtype: 'checkcolumn',
            text: 'Vat',
            dataIndex: 'chk01',
            width: 30,
            field: {
                xtype: 'checkboxfield',
                listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}}
            },
			{
				text: "Amount",
				width: 90,
				xtype: 'numbercolumn',
				dataIndex: 'itamt',
				sortable: false,
				align: 'right',
				field: {
				type: 'textfield'
			}
			},
			{text: "Currency",
			width: 70,
			dataIndex: 'ctype',
			//xtype: 'textcolumn',
			sortable: true,
			align: 'center',
			editor: {
				xtype: 'textfield'
			},
			}
		];

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
		_this = this;
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;
        
        var cur = _this.curValue;
        //var amts = _this.amtValue;
		// add new record
		rec = { id:newId, ctype:cur, duedt:new Date() };
		edit = this.editing;
		edit.cancelEdit();
		// find current record
		var sel = this.getView().getSelectionModel().getSelection()[0];
		var selIndex = this.store.indexOf(sel);
		this.store.insert(selIndex+1, rec);
		edit.startEditByPosition({
			row: selIndex+1,
			column: 0
		});

		this.runNumRow();
	},

	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);

		this.runNumRow();
	},

	runNumRow: function(){
		var row_num = 0;
		this.store.each(function(r){
			r.set('paypr', row_num++);
		});
	},

	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	}
});
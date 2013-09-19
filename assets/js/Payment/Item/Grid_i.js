Ext.define('Account.Payment.Item.Grid_i', {
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

		// INIT PY search popup /////////////////////////////////
		this.pyDialog = Ext.create('Account.SAp.MainWindow');
		// END Material search popup //////////////////////////////////

		this.tbar = [this.addAct, this.copyAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"payment/loads_py_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'invnr,vbelp'
				}
			},
			fields: [
			    'invnr',
				'vbelp',
				'invnr',
				'refnr',
				'invdt',
				'texts',
				'itamt',
				'payrc',
				'reman'
			],
			remoteSort: true,
			sorters: ['invnr ASC']
		});

		this.columns = [
		    {
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete Payment Item',
				scope: this,
				handler: this.removeRecord
			}]
		},{
			id : 'RowNumber',
			header : "No.",
			dataIndex : 'vbelp',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},
		{text: "PY Code",
		width: 120,
		dataIndex: 'invnr',
		sortable: false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.pyDialog.show();
				}
			},
			},
		    {text: "Ref.No",
		    width: 120,
		    dataIndex: 'refnr',
		    sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
		    {text: "PY Date",
		    width: 80,
		    dataIndex: 'invdt',
		    sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
		    {text: "Text Note",
		    width: 180,
		    dataIndex: 'texts',
		    sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
			{text: "PY Amt",
			width: 100,
			dataIndex: 'itamt',
			sortable: false,
			align: 'right',
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
			{text: "Payment Amt",
			width: 100,
			dataIndex: 'payrc',
			sortable: false,
			align: 'right',
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
			{
				text: "Remain Amt",
				width: 120,
				dataIndex: 'reman',
				sortable: false,
				align: 'right',
				renderer: function(v,p,r){
					var itamt = parseFloat(r.data['itamt']),
						pay = parseFloat(r.data['payrc']);
					itamt = isNaN(itamt)?0:itamt;
					pay = isNaN(pay)?0:pay;

					var amt = itamt - pay;
					return Ext.util.Format.usMoney(amt).replace(/\$/, '');
				}
			}/*,
			{text: "Currency",
			width: 55,
			dataIndex: 'ctype',
			sortable: false,
			align: 'center',
			field: {
				type: 'textfield'
			},
		}*/];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
		});

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='invnr'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'ap/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, r.data.invnr);

							// Ref no
							rModel.set('refnr', r.data.refnr);

							// Invoice date
							rModel.set('invdt', r.data.bldat);
							
							// Text Note
							rModel.set('texts', r.data.sgtxt);
							
							// Invoice amt
							rModel.set('itamt', r.data.netwr);
							//rModel.set('amount', 100+Math.random());

						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
		});

		_this.pyDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];

				// change cell code value (use db value)
				rModel.set('invnr', record.data.invnr);

				// Ref no
				rModel.set('refnr', record.data.refnr);

				// Invoice date
				rModel.set('invdt', record.data.bldat);
				
				// Text note
				rModel.set('texts', record.data.sgtxt);

				// Invoice amt
				rModel.set('itamt', record.data.netwr);
				//rModel.set('amount', 100+Math.random());

			}
			grid.getSelectionModel().deselectAll();
			_this.pyDialog.hide();
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
		rec = { id:newId, invnr:'' };
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
			r.set('vbelp', row_num++);
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
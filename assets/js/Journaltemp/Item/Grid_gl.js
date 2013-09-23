Ext.define('Account.Journaltemp.Item.Grid_gl', {
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

		// INIT Material search popup /////////////////////////////////
		this.glDialog = Ext.create('Account.GL.MainWindow');
		// END Material search popup //////////////////////////////////

		this.tbar = [this.addAct, this.copyAct];
		
		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});
		
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"journaltemp/loads_gl_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'tranr,trapr'
				}
			},
			fields: [
			    'tranr',
				'trapr',
				'saknr',
				'sgtxt',
				'debit',
				'credi',
				'txz01'
			],
			remoteSort: true,
			sorters: ['trapr ASC']
		});

		this.columns = [
		{
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete Template Item',
				scope: this,
				handler: this.removeRecord
			}]
		},{
			id : 'RowNumber',
			header : "No.",
			dataIndex : 'trapr',
			width : 50,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
		}
		},
		    {text: "GL No.", 
		    width: 100, 
		    dataIndex: 'saknr', 
		    align: 'center',
		    sortable: false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.glDialog.show();
				}
			}
			},
			{text: "GL Description", width: 300, 
			dataIndex: 'sgtxt', sortable: true},
		    
		    {text: "Debit", 
		    width: 100, dataIndex: 'debit', sortable: true,
		    align: 'right',
		    xtype: 'numbercolumn',
		    decimalPrecision: 2,
		    field: {
				type: 'numberfield',
				decimalPrecision: 2
			}
		    },
			{text: "Credit", 
			width: 100, dataIndex: 'credi', sortable: true,
			align: 'right',
			xtype: 'numbercolumn',
		    decimalPrecision: 2,
			field: {
				type: 'numberfield',
				decimalPrecision: 2
			}
			},
			{text: "Remarks", 
			width: 250, dataIndex: 'txz01', sortable: true,
			field: {
				type: 'textfield'
			}
			}
		];
		
		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
		});

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='saknr'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'gl/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, r.data.saknr);

							// Materail text
							rModel.set('sgtxt', r.data.sgtxt);
							alert(r.data.gltyp);
							if (r.data.gltyp=='1'){
								rModel.set('debit', '1.00');
							}else if(record.data.gltyp=='2'){
								rModel.set('credi', '1.00');
							}

						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
		});

		_this.glDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];

				// change cell code value (use db value)
				rModel.set('saknr', record.data.saknr);

				// Materail text
				rModel.set('sgtxt', record.data.sgtxt);
				//alert(record.data.gltyp);
				if(record.data.gltyp=='1'){
					rModel.set('debit', '1.00');
			    }else if(record.data.gltyp=='2'){
				    rModel.set('credi', '1.00');
				}

			}
			grid.getSelectionModel().deselectAll();
			_this.glDialog.hide();
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
		rec = { id:newId };
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
			r.set('trpr', row_num++);
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
Ext.define('Account.PettyReim.Item.Grid_i', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		/*this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus'
		});
		this.copyAct = new Ext.Action({
			text: 'Copy',
			iconCls: 'b-small-copy'
		});
		// INIT Material search popup //////////////////////////////////
		this.materialDialog = Ext.create('Account.SMaterial.MainWindow');
		// END Material search popup ///////////////////////////////////
        this.unitDialog = Ext.create('Account.SUnit.Window');
		this.tbar = [this.addAct, this.copyAct];*/
		
		this.bankDialog = Ext.create('Account.SBankname.MainWindow');

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"pettyreim/loads_ap_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'remnr,vbelp'
				}
			},
			fields: [
			    'remnr',
				'vbelp',
				'matnr',
				'maktx',
				'menge',
				'meins',
				'unitp',
				'disit',
				'itamt',
				'ctype',
				'chk01',
				'chk02',
				'bcode',
				'bname',
				'saknr',
				'saknr2'
			],
			remoteSort: true,
			sorters: ['vbelp ASC']
		});

		this.columns = [{
			id : 'APiRowNumber5',
			header : "Items",
			dataIndex : 'vbelp',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},
		{text: "Material Code",
		width: 80,
		dataIndex: 'matnr',
		sortable: false,
			/*field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.materialDialog.show();
				}
			},*/
			},
		    {text: "Description",
		    width: 180,
		    dataIndex: 'maktx',
		    sortable: false,
		    //field: {
			//	type: 'textfield'
			//},
		    },
			{text: "Qty",
			xtype: 'numbercolumn',
			width: 50,
			dataIndex: 'menge',
			sortable: false,
			align: 'right'
			},
			{text: "Unit", width: 40, 
			dataIndex: 'meins', 
			align: 'center',
			sortable: false,
			/*field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.unitDialog.show();
				}
			},*/
			},
			{text: "Bank Code", align : 'center',
			width:100, 
			dataIndex: 'bcode',
			sortable: false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.bankDialog.show();
				}
			},
			},
		    {text: "Bank Name",
		    width: 180, dataIndex: 'bname', sortable: false,
		    field: {
				type: 'textfield'
			}
			},
			{text: "Petty Cash Amt",
			xtype: 'numbercolumn',
			width: 120,
			dataIndex: 'unitp',
			sortable: false,
			align: 'right',
			editor: {
				type: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
						_this.editing.completeEdit();
					},
				}
			}
			},
			{text: "Currency",
			width: 65,
			dataIndex: 'ctype',
			sortable: false,
			align: 'center',
			//field: {
			//	type: 'textfield'
			//},
		},{
			dataIndex: 'saknr',
			//width: 55,
			hidden: true,
			sortable: false
		},{
			dataIndex: 'saknr2',
			//width: 55,
			hidden: true,
			sortable: false
		}];

		this.plugins = [this.editing];

		// init event
		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='bcode'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'bankname/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, r.data.bcode);
							// Materail text
							rModel.set('bname', r.data.bname);
							// GL No
							rModel.set('saknr2', r.data.saknr);
						}else{
							var rModel = _this.store.getById(e.record.data.id);
							rModel.set(e.field, '');
							// Materail text
							rModel.set('bname', '');
							// GL No
							rModel.set('saknr2', '');
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
			
			//var _this = this;
			if(e.column.dataIndex=='unitp'){
				var v = parseFloat(e.value);
				var rModel = _this.store.getById(e.record.data.id);
				var remain = _this.remainValue;
				//alert(v+'aaa'+remain);
			    if(v>remain){
			    	rModel.set(e.field, remain);
			    	Ext.Msg.alert('Warning', 'CPV Amount over Limit Amount');
			    }
			}
		});

		_this.bankDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];

				// change cell code value (use db value)
				rModel.set('bcode', record.data.bcode);
				// Materail text
				rModel.set('bname', record.data.bname);
				// GL No
				rModel.set('saknr2', record.data.saknr)
			}
			grid.getSelectionModel().deselectAll();
			_this.bankDialog.hide();
		});

		return this.callParent(arguments);
	},

	load: function(options){
		this.store.load({
			params: options
		});
	},
	
	addDefaultRecord: function(){
		this.store.removeAll(); 
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){ //กรณีมีเลือกรายการขึ้นมาแก้ไขและมีรายการมากกว่า 1 รายการ
			if(r.get('id')<newId)
				newId = r.get('id'); 
				
		});
		newId--;
	
		//for ( var i = 0; i < 5; i++ ) {
			// add new record
			rec = { id:0,matnr:'200021',maktx:'เงินทดลองจ่าย',
			menge:1,meins:'EA',chk01:1,ctyp1:'THB',saknr:'1111-00' };
			edit = this.editing;
			edit.cancelEdit();
			var selIndex = 0;
			this.store.insert(selIndex+1, rec);
			edit.startEditByPosition({
				row: selIndex+1,
				column: 0
			});
	
			this.runNumRow();
		//}
	},

	addRecord: function(){
		var _this = this;
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;
        
        var cur = _this.curValue;
		// add new record
		rec = { id:newId, chk01:1, ctype: cur  };
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
	
	copyRecord: function(){
		var _this=this;

		var sel = _this.getView().getSelectionModel().getSelection()[0];
		if(sel){
			// หา record ที่สร้างใหม่ล่าสุด
			var newId = -1;
			this.store.each(function(r){
				if(r.get('id')<newId)
					newId = r.get('id');
			});
			newId--;

	        var cur = _this.curValue;
			// add new record
			rec = sel.getData();
			//console.log(rec);
			rec.id = newId;
			//rec = { id:newId, ctype:cur };
			edit = this.editing;
			edit.cancelEdit();
			// find current record
			//var sel = this.getView().getSelectionModel().getSelection()[0];
			var selIndex = this.store.indexOf(sel);
			this.store.insert(selIndex+1, rec);
			edit.startEditByPosition({
				row: selIndex+1,
				column: 0
			});

			this.runNumRow();

			this.getSelectionModel().deselectAll();
		}else{
			Ext.Msg.alert('Warning', 'Please select record to copy.');
		}
	},

	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);

		this.runNumRow();
	},

	runNumRow: function(){
		var row_num = 0;
		this.store.each(function(r){
			r.set('ebelp', row_num++);
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
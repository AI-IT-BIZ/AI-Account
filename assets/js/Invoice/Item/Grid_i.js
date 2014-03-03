Ext.define('Account.Invoice.Item.Grid_i', {
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

		// INIT Material search popup /////////////////////////////////
		this.materialDialog = Ext.create('Account.SMaterial.MainWindow');
		// END Material search popup //////////////////////////////////
        this.unitDialog = Ext.create('Account.SUnit.Window');
        
		this.tbar = [this.addAct, this.copyAct];*/
        
        this.whtDialog = Ext.create('Account.WHT.Window');
        
		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"invoice/loads_iv_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.invnr+o.vbelp; },
					totalProperty: 'totalCount'
				}
			},
			fields: [
			    'invnr',
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
				'saknr',
				'whtnr',
				'whtpr'
				
			],
			remoteSort: true,
			sorters: ['vbelp ASC']
		});

		this.columns = [
		    {
			id : 'RowNumber',
			text: "No.",
			dataIndex : 'vbelp',
			width : 40,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},
		{text: "Material Code",
		width: 90,
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
		    width: 220,
		    dataIndex: 'maktx',
		    sortable: false,
		    //field: {
			//	type: 'textfield'
			//},
		    },
			{text: "Qty",
			xtype: 'numbercolumn',
			width: 70,
			dataIndex: 'menge',
			sortable: false,
			align: 'right',
			/*field: {
				type: 'numberfield',
				//decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},*/
			},
			{text: "Unit",
			width: 50,
			dataIndex: 'meins',
			align: 'center',
			sortable: false,
			/*field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					//_this.editing.completeEdit();
					_this.unitDialog.show();
				}
			},*/
			},
			{text: "Price/Unit",
			xtype: 'numbercolumn',
			width: 100,
			dataIndex: 'unitp',
			sortable: false,
			align: 'right',
			/*field: {
				type: 'numberfield',
				decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},*/
			},
			{text: "Discount",
			//xtype: 'numbercolumn',
			width: 80,
			dataIndex: 'disit',
			sortable: false,
			align: 'right',
			field: Ext.create('BASE.form.field.PercentOrNumber'),
				renderer: function(v,p,r){
					var regEx = /%$/gi;
					if(regEx.test(v))
						return v;
					else
						return Ext.util.Format.usMoney(v).replace(/\$/, '');
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
            },{text: "WHT Type",
		    width: 60,
		    dataIndex: 'whtnr',
		    sortable: false,
		    align: 'center',
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.whtDialog.show();
				}
			}
			},
			{text: "WHT Value",
			width: 60,
			dataIndex: 'whtpr',
			sortable: false,
			value: '0%',
			align: 'center'
		   },
			{
				text: "Amount",
				width: 100,
				dataIndex: 'itamt',
				sortable: false,
				align: 'right',
				renderer: function(v,p,r){
					var qty = parseFloat(r.data['menge']),
						price = parseFloat(r.data['unitp']);
						//discount = parseFloat(r.data['disit'].replace(/[^0-9.]/g, ''));
					qty = isNaN(qty)?0:qty;
					price = isNaN(price)?0:price;
					//discount = isNaN(discount)?0:discount;
                    
					var amt = qty * price;//) - discount;
					return Ext.util.Format.usMoney(amt).replace(/\$/, '');
				}
			},
			{text: "Currency",
			width: 55,
			dataIndex: 'ctype',
			sortable: false,
			align: 'center'
		    },
			{
			dataIndex: 'saknr',
			//width: 55,
			hidden: true,
			sortable: false
		}];

		this.plugins = [this.editing];

		// init event
		/*this.addAct.setHandler(function(){
			_this.addRecord();
		});
		
		this.copyAct.setHandler(function(){
			_this.copyRecord();
		});*/

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='whtnr'){
				var v = e.value;
				if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'invoice/load_wht',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);
							rModel.set(e.field, r.data.whtnr);
							rModel.set('whtpr', r.data.whtpr);
						   
						}else{
							rModel.set(e.field, '');
							rModel.set('whtpr', '');
							//o.markInvalid('Could not find wht code : '+o.getValue());
						}
					}
				});
			}
		});

		_this.whtDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];
				//change cell code value (use db value)
				rModel.set('whtnr', record.data.whtnr);
				rModel.set('whtpr', record.data.whtpr);
			    //_this.trigUnit.setValue(record.data.meins);
			}
            
			grid.getSelectionModel().deselectAll();
			_this.whtDialog.hide();
		});
		
		this.store.on('load', function(store, rs){
			if(_this.readOnly){
				var view = _this.getView();
				var t = _this.getView().getEl().down('table');
				t.addCls('mask-grid-readonly');
				_this.readOnlyMask = new Ext.LoadMask(t, {
					msg:"..."
				});
				_this.readOnlyMask.show();
			}else{
				if(_this.readOnlyMask)
					_this.readOnlyMask.hide();
			}
		});

		return this.callParent(arguments);
	},

	load: function(options){
		this.store.load({
			params: options
		});
		
		//this.addRecord();
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
		rec = { id:newId,ctype:'THB' };
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
		this.getSelectionModel().deselectAll();
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
		this.getSelectionModel().deselectAll();
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
Ext.define('Account.GR.Item.Grid_i', {
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
		this.materialDialog = Ext.create('Account.SMatAsset.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});*/
		// END Material search popup ///////////////////////////////////
        this.assetDialog = Ext.create('Account.GenAsset.Window');
		//this.tbar = [this.addAct, this.copyAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"gr/loads_gr_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'mbeln,mbelp'
				}
			},
			fields: [
			    'mbeln',
				'mbelp',
				'matnr',
				'maktx',
				'menge',
				'meins',
				'unitp',
				'disit',
				'itamt',
				'ctype',
				'chk01',
				'serno',
				'reman',
				'upqty'
			],
			remoteSort: true,
			sorters: ['mbelp ASC']
		});

		this.columns = [{
			id : 'GRiRowNumber',
			header : "Items",
			dataIndex : 'mbelp',
			width : 50,
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
		    width: 220,
		    dataIndex: 'maktx',
		    sortable: false,
		    //field: {
			//	type: 'textfield'
			//},
		    },
			{text: "Qty",
			xtype: 'numbercolumn',
			width: 60,
			dataIndex: 'menge',
			sortable: false,
			align: 'right',
			/*field: {
				type: 'numberfield',
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},*/
			},
			{text: "Unit", width: 50, dataIndex: 'meins', sortable: false,
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
			width: 70,
			dataIndex: 'disit',
			sortable: false,
			align: 'right',
			/*field: Ext.create('BASE.form.field.PercentOrNumber'),
				renderer: function(v,p,r){
					var regEx = /%$/gi;
					if(regEx.test(v))
						return v;
					else
						return Ext.util.Format.usMoney(v).replace(/\$/, '');
				}*/
				renderer: function(v,p,r){
					var regEx = v.substring(0,1);
					if(regEx == '.')
						return Ext.util.Format.usMoney(v).replace(/\$/, '');
					else
						return v;
					}
			},{
            xtype: 'checkcolumn',
            text: 'Vat',
            dataIndex: 'chk01',
            disabled: true,
            width: 30,
            /*field: {
                xtype: 'checkboxfield',
                listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}}*/
            },
			{
				text: "Amount",
				width: 90,
				dataIndex: 'itamt',
				sortable: false,
				align: 'right',
				renderer: function(v,p,r){
					var qty = parseFloat(r.data['upqty']),
						price = parseFloat(r.data['unitp']);
						//discount = parseFloat(r.data['dismt']);
					qty = isNaN(qty)?0:qty;
					price = isNaN(price)?0:price;
					//discount = isNaN(discount)?0:discount;

					var amt = qty * price;//) - discount;
					return Ext.util.Format.usMoney(amt).replace(/\$/, '');
				}
			},
			{text: "Currency",
			width: 50,
			dataIndex: 'ctype',
			sortable: false,
			align: 'center',
			//field: {
			//	type: 'textfield'
			//},
		},{text: "Remain Qty",
			xtype: 'numbercolumn',
			width: 65,
			dataIndex: 'reman',
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
			},{text: "GR Qty",
			xtype: 'numbercolumn',
			width: 60,
			dataIndex: 'upqty',
			sortable: false,
			allowBlank: false,
			align: 'right',
			field: {
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
			},
			},
		{text: "FA Tag No.",
		width: 80,
		dataIndex: 'serno',
		sortable: false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					//_this.editing.completeEdit();
					_this.assetDialog.show();
					_this.assetDialog.grid.load();
				}
			},
			}];

		this.plugins = [this.editing];

		this.editing.on('edit', function(editor, e) {
		if(e.column.dataIndex=='upqty'){
				var v = parseFloat(e.value);
				var rModel = _this.store.getById(e.record.data.id);
				var remain = e.record.data.reman;
				//alert(v+'aaa'+e.record.data.reman);
			    if(v>remain){
			    	Ext.Msg.alert('Warning', 'GR qty over remain qty');
			    	rModel.set(e.field, 0);
			    }
			}
		});
		// for set readonly grid
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
		rec = { id:newId, ctype:'THB' };
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
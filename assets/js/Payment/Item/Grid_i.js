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
		this.apDialog = Ext.create('Account.SAp.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});

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
					idProperty: 'payno,vbelp'
				}
			},
			fields: [
			    'payno',
				'vbelp',
				'invnr',
				'refno',
				'invdt',
				'texts',
				{name:'itamt', type: 'string'},
				//'payrc',
				//'reman',
				'belnr',
				'ctype',
				'beamt',
				'dismt',
				'wht01',
				'vat01',
				'dtype',
				'loekz',
				'ebeln',
				'lifnr'
			],
			remoteSort: true,
			sorters: ['vbelp ASC']
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
				xtype: 'hidden',
				name: 'loekz'
			},{
			id : 'PMiRowNumber022',
			header : "No.",
			dataIndex : 'vbelp',
			width : 50,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},
		{text: "Acc-Payable No",
		width: 100,
		dataIndex: 'invnr',
		align : 'center',
		sortable: false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.apDialog.show();
				}
			},
			},{text: "PO/GR No",
		    width: 100,
		    dataIndex: 'ebeln',
		    align : 'center',
		    sortable: false,
		    field: {
				type: 'textfield'
			}
			},
			{text: "Payment Date",
		    width: 80,
		    xtype: 'datecolumn',
		    align : 'center',
		    dataIndex: 'invdt',
		    sortable: false,
		    renderer : Ext.util.Format.dateRenderer('m/d/Y')
		    },
		    {text: "Ref.Tax Invoice",
		    width: 100,
		    dataIndex: 'refno',
		    sortable: false,
		    field: {
				type: 'textfield'
			}
		    },
		    {
		    text: "Amount",
			dataIndex: 'beamt',
			xtype: 'numbercolumn',
			width: 100,
			align: 'right',
			sortable: false,
			readOnly: true
		    },{
		    text: "Discount",
			dataIndex: 'dismt',
			xtype: 'numbercolumn',
			width: 80,
			align: 'right',
			sortable: false,
			readOnly: true
		    },{
		    text: "Vat Amt",
			dataIndex: 'vat01',
			xtype: 'numbercolumn',
			width: 100,
			align: 'right',
			sortable: false,
			readOnly: true
		    },{
		    text: "WHT Amt",
			dataIndex: 'wht01',
			xtype: 'numbercolumn',
			width: 100,
			align: 'right',
			sortable: false,
			readOnly: true
		    },
			{text: "Net Amt",
			xtype: 'numbercolumn',
			width: 100,
			dataIndex: 'itamt',
			sortable: false,
			align: 'right',
			readOnly: true
			},
			/*{text: "Payment Amt",
			xtype: 'numbercolumn',
			width: 100,
			dataIndex: 'payrc',
			sortable: false,
			align: 'right',
			readOnly: true
			},
			{
				text: "Remain Amt",
				xtype: 'numbercolumn',
				width: 100,
				dataIndex: 'reman',
				sortable: false,
				align: 'right',
				readOnly: true,
				renderer: function(v,p,r){
					var itamt = parseFloat(r.data['itamt']),
						pay = parseFloat(r.data['payrc']);
					itamt = isNaN(itamt)?0:itamt;
					pay = isNaN(pay)?0:pay;

					var amt = itamt - pay;
					return Ext.util.Format.usMoney(amt).replace(/\$/, '');
				}
			},*///{text: "",xtype: 'hidden',width: 0, dataIndex: 'statu'},
			{text: "Currency",
			width: 55,
			dataIndex: 'ctype',
			sortable: false,
			align: 'center'
		},{
			dataIndex: 'dtype',
			//width: 55,
			hidden: true,
			sortable: false
		},{
			dataIndex: 'lifnr',
			//width: 55,
			hidden: true,
			sortable: false
		}];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
		});
		
		this.copyAct.setHandler(function(){
			_this.copyRecord();
		});

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='invnr'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;
				
				var v_url = 'ap/load';
				var v_str = v.substring(0,1);
				if(v_str == 'D'){
					v_url = 'depositout/load';
				}

				Ext.Ajax.request({
					url: __site_url+v_url,
					method: 'POST',
					params: {
						id: v,
						key: 1
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);
							
							// check data
				var isDuplicate = false;
				_this.store.each(function(record){
					//alert(v.data['invnr']+'/');

				  	if(r.data.invnr == record.data.invnr){
				  		isDuplicate = true;
				  		return false;
				  	}
				});
				if(isDuplicate){
					Ext.Msg.alert('Warning', 'The AP number already on list.');
					return;
				}
				
							// change cell code value (use db value)
							rModel.set(e.field, r.data.invnr);
							// Ref no
							rModel.set('refnr', r.data.refno);
							// Invoice date
							rModel.set('invdt', r.data.bldat);
							// Text Note
							//rModel.set('texts', r.data.sgtxt);
							// GR No
							rModel.set('ebeln', r.data.ebeln);
							// Invoice amt
							rModel.set('itamt', r.data.netwr);
							// Currency
							rModel.set('ctype', r.data.ctype);
							// WHT01
							rModel.set('wht01', r.data.wht01);
							// VAT01
							rModel.set('vat01', r.data.vat01);
							// Amount
				            rModel.set('beamt', r.data.beamt);
				            // Discount
				            rModel.set('dismt', r.data.dismt);
							// Dtype
							var dtype = r.data.invnr.substring(0,2);
							rModel.set('dtype', dtype[0]);
							//Flag
							rModel.set('loekz', r.data.loekz);
							//rModel.set('amount', 100+Math.random());
							rModel.set('lifnr', r.data.lifnr);
						}else{
							var rModel = _this.store.getById(e.record.data.id);
							rModel.set(e.field, '');
							rModel.set('refnr', '');
							rModel.set('invdt', '');
							rModel.set('jobtx', '');
							rModel.set('texts', '');
							rModel.set('itamt', '');
							rModel.set('ctyp1', '');
							rModel.set('wht01', '');
							rModel.set('vat01', '');
							rModel.set('loekz', '');
				            rModel.set('dtype', '');
							rModel.set('lifnr', '');
							rModel.set('beamt', '');
							rModel.set('dismt', '');
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
		});

		_this.apDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var checks='';
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];
				
				// check data
				var isDuplicate = false;
				_this.store.each(function(r){
					//alert(v.data['invnr']+'/');

				  	if(r.data.invnr == record.data.invnr){
				  		isDuplicate = true;
				  		return false;
				  	}
				});
				if(isDuplicate){
					Ext.Msg.alert('Warning', 'The AP number already on list.');
					return;
				}
				
				// change cell code value (use db value)
				rModel.set('invnr', record.data.invnr);
				// Ref no
				rModel.set('refno', record.data.refnr);
				// Invoice date
				rModel.set('invdt', record.data.bldat);
				// Text note
				//rModel.set('texts', record.data.sgtxt);
				// GR No
				rModel.set('ebeln', record.data.ebeln);
				// Invoice amt
				rModel.set('itamt', record.data.netwr);
				// Currency
				rModel.set('ctype', record.data.ctype);
				// WHT01
				rModel.set('wht01', record.data.wht01);
				// VAT01
				rModel.set('vat01', record.data.vat01);
				// Amount
				rModel.set('beamt', record.data.beamt);
				// Discount
				rModel.set('dismt', record.data.dismt);
				// Dtype
				var dtype = record.data.invnr.substring(0,2);
				rModel.set('dtype', dtype[0]);
				//Flag
			    rModel.set('loekz', record.data.loekz);
			    rModel.set('lifnr', record.data.lifnr);
			}
			grid.getSelectionModel().deselectAll();
			_this.apDialog.hide();
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
			r.set('vbelp', row_num++);
		});
	},

	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	},
	
	setVendorCode: function(lifnr){
		this.vendorCode = lifnr;
		var field = this.apDialog.searchForm.form.findField('lifnr');
		field.setValue(lifnr);
		this.apDialog.grid.load();
	}
});
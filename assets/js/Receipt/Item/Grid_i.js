Ext.define('Account.Receipt.Item.Grid_i', {
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
		this.invoiceDialog = Ext.create('Account.SInvoice.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
		// END Invoice search popup //////////////////////////////////

		this.tbar = [this.addAct, this.copyAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"receipt/loads_rc_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'recnr,vbelp'
				}
			},
			fields: [
			    'recnr',
				'vbelp',
				'invnr',
				'refnr',
				'invdt',
				'texts',
				{name:'itamt', type: 'string'},
				'jobtx',
				//'payrc',
				//'reman',
				'belnr',
				'ctype',
				'wht01',
				'vat01',
				'dtype',
				'loekz',
				'kunnr'
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
				tooltip: 'Delete Receipt Item',
				scope: this,
				handler: this.removeRecord
			}]
		},{
						xtype: 'hidden',
						name: 'loekz'
					},{
			id : 'RowNumber5',
			header : "No.",
			dataIndex : 'vbelp',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},
		{text: "Invoice No",
		width: 100,
		dataIndex: 'invnr',
		sortable: false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.invoiceDialog.show();
				}
			}
			},
			{text: "Project Description",
		    width: 150,
		    dataIndex: 'jobtx',
		    sortable: false,
		    field: {
				type: 'textfield'
			}
			},
		    {text: "Ref.No",
		    width: 120,
		    dataIndex: 'refnr',
		    sortable: false,
		    field: {
				type: 'textfield'
			}
		    },
		    {text: "Invoice Date",
		    width: 80,
		    xtype: 'datecolumn',
		    dataIndex: 'invdt',
		    sortable: false,
		    renderer : Ext.util.Format.dateRenderer('m/d/Y')
		    },
		    {text: "Text Note",
		    width: 180,
		    dataIndex: 'texts',
		    sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
			{text: "Invoice Amt",
			xtype: 'numbercolumn',
			width: 120,
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
			{   text: "Remain Amt",
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
			//readOnly: true,
			align: 'center',
			//field: {
			//	type: 'textfield'
			//},
		},{
			dataIndex: 'wht01',
			//width: 55,
			hidden: true,
			sortable: false
		},{
			dataIndex: 'vat01',
			//width: 55,
			hidden: true,
			sortable: false
		},{
			dataIndex: 'dtype',
			//width: 55,
			hidden: true,
			sortable: false
		},{
			dataIndex: 'kunnr',
			//width: 55,
			hidden: true,
			sortable: false
		}];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
		});

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='invnr'){
				var v = e.value;
				var v_url = 'invoice/load';
				var v_str = v.substring(0,1);
				if(v_str == 'D'){
					v_url = 'depositin/load';
				}

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+v_url,
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
							// Project No
							rModel.set('jobtx', r.data.jobtx);
							// Text Note
							rModel.set('texts', r.data.txz01);
							// Invoice amt
							rModel.set('itamt', r.data.netwr);
							// Currency
							rModel.set('ctype', r.data.ctype);
							// WHT01
							rModel.set('wht01', r.data.wht01);
							// VAT01
							rModel.set('vat01', r.data.vat01);
							//Flag
							rModel.set('loekz', r.data.loekz);
							// Dtype
							var dtype = r.data.invnr.substring(0,2);
				            rModel.set('dtype', dtype[0]);
							//rModel.set('amount', 100+Math.random());
							rModel.set('kunnr', r.data.kunnr);

						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
		});

		_this.invoiceDialog.grid.on('beforeitemdblclick', function(grid, record, item){
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
				rModel.set('texts', record.data.txz01);
				// Project No
			    rModel.set('jobtx', record.data.jobtx);
				// Invoice amt
				rModel.set('itamt', record.data.netwr);
				// Currency
				rModel.set('ctype', record.data.ctype);
				// WHT01
				rModel.set('wht01', record.data.wht01);
				// VAT01
				rModel.set('vat01', record.data.vat01);
				//Flag
				rModel.set('loekz', record.data.loekz);
				// Dtype
				var dtype = record.data.invnr.substring(0,2);
				rModel.set('dtype', dtype[0]);
				//rModel.set('amount', 100+Math.random());
				rModel.set('kunnr', record.data.kunnr);
                
			}
			grid.getSelectionModel().deselectAll();
			_this.invoiceDialog.hide();
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
	},

	addRecord: function(){
		var _this=this;
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;
        
        var cur = _this.curValue;
		// add new record
		rec = { id:newId, invnr:'', ctype:cur };
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
	setCustomerCode: function(kunnr){
		this.customerCode = kunnr;
		var field = this.invoiceDialog.searchForm.form.findField('kunnr');
		field.setValue(kunnr);
		this.invoiceDialog.grid.load();
	}
});
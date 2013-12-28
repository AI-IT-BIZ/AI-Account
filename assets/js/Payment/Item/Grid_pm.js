Ext.define('Account.Payment.Item.Grid_pm', {
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
		
		// INIT Bank search popup /////////////////////////////////
		this.bankDialog = Ext.create('Account.Bankname.MainWindow');
		// END Bank search popup //////////////////////////////////
		
		this.tbar = [this.addAct, this.copyAct];
		/*--------------------*/

// Defined combo store
		this.ptypeStore = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'receipt/loads_pcombo',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'ptype'
				}
			},
			fields: [
				'ptype',
				'paytx'
			],
			remoteSort: true,
			sorters: 'ptype ASC'
		});

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"payment/loads_pm_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'recnr,paypr'
				}
			},
			fields: [
			    'recnr',
			    'paypr',
				'ptype',
				'bcode',
				'bname',
				'sgtxt',
				'chqid',
				'chqdt',
				{name:'pramt', type: 'string'},
				'payam',
				'reman',
				'saknr',
				'wht01'//,
				//'vat01',
				//'dtype'
			],
			remoteSort: true,
			sorters: ['paypr ASC']
		});

		this.columns = [{
		    xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete Payment',
				scope: this,
				handler: this.removeRecord2
			}]
		},{
			id : 'RowNumber60',
			header : "No.",
			dataIndex : 'paypr',
			width : 50,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		}, {text: "Payment",
		    width: 100,
		    dataIndex: 'ptype',
		    sortable: false,
		    editor: new Ext.form.field.ComboBox({
	            store: this.ptypeStore,
				queryMode: 'remote',
				displayField: 'paytx',
				valueField: 'ptype'
			}),
			renderer: function(value) {
				if (!isNaN(value)){
					if (_this.ptypeStore.findRecord('ptype', value) != null)
						return _this.ptypeStore.findRecord('ptype', value).get('paytx');
					else
						return value;
				} else if (typeof value != 'undefined') {
					if (value.paytx != null)
						return value.paytx;
					else
						return "";
				} else
					return "";
			}
		}, {text: "Bank Code", align : 'center',
			width:80, 
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
		    width: 120, dataIndex: 'bname', sortable: false,
		    field: {
				type: 'textfield'
			},
		    },
			{text: "Branch",
			width: 100, dataIndex: 'sgtxt', sortable: false,
			field: {
				type: 'textfield'
			},
			},
			{text: "Cheque No", align : 'center',
			width: 80, dataIndex: 'chqid', sortable: false,
			field: {
				type: 'textfield'
			},
			},
		    {text: "Cheque Dat", align : 'center',
		    xtype: 'datecolumn', width: 80,
		    dataIndex: 'chqdt', sortable: false,
		    format:'d/m/Y',
		    editor: {
                xtype: 'datefield',
                format:'d/m/Y',
			    altFormats:'Y-m-d|d/m/Y',
			    submitFormat:'Y-m-d'
           },
           renderer: function(value) {
           	if (!isNaN(value)){
           		return Ext.Date.format(value, 'd/m/Y')
           	}else{
           		return "";
           	}
           }
		    },
		    {text: "Amount", 
		    xtype: 'numbercolumn',
		    align : 'right',
		    width: 100, dataIndex: 'pramt', 
		    sortable: false//,
		    /*readOnly: true,
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
			}*/
		    },
		    {text: "Pay Amount", 
		    xtype: 'numbercolumn',
		    align : 'right',
		    width: 100, dataIndex: 'payam', 
		    sortable: false,
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
			}
			},
		    {text: "Remain Amt", 
		     xtype: 'numbercolumn',
		    align : 'right',
		    width: 100, dataIndex: 'reman', sortable: false,
		    readOnly: true,
		    renderer: function(v,p,r){
				var pamt = parseFloat(r.data['pramt'].replace(/[^0-9.]/g, ''));
				var pay = parseFloat(r.data['payam'].replace(/[^0-9.]/g, ''));
				pamt = isNaN(pamt)?0:pamt;
				pay = isNaN(pay)?0:pay;
				var amt = pamt - pay;
				return Ext.util.Format.usMoney(amt).replace(/\$/, '');
				}
		},{
			dataIndex: 'saknr',
			//width: 55,
			hidden: true,
			sortable: false
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
		}
		];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord2();
		});

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
							rModel.set('saknr', r.data.saknr);
						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
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
				rModel.set('saknr', record.data.saknr)
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

	addRecord2: function(){
		var _this = this;
		// หา record ที่สร้างใหม่ล่าสุด
		var net = _this.netValue;
		var newId = -1;
		var i=0;var wht01=0;var vat01=0;
		var dtype='';
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;
        var sel = _this.getView().getSelectionModel().getSelection()[0];
        if (sel){
         i = parseFloat(sel.get('payam').replace(/[^0-9.]/g, ''));
         net = net - i;
         wht01 = parseFloat(sel.get('wht01'));
         vat01 = parseFloat(sel.get('vat01'));
         dtype = parseFloat(sel.get('dtype'));
        }
		// add new record
		rec = { id:newId, pramt:net, vat01:vat01, wht01:wht01, dtype:dtype };
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

		this.runNumRow2();
	},

	removeRecord2: function(grid, rowIndex){
		this.store.removeAt(rowIndex);

		this.runNumRow2();
	},

	runNumRow2: function(){
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
	},
});
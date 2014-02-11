Ext.define('Account.DepositOut.Item.Grid_i', {
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
		});*/

		// INIT Material search popup //////////////////////////////////
		//this.materialDialog = Ext.create('Account.SMaterial.MainWindow');
		// END Material search popup ///////////////////////////////////
        //this.unitDialog = Ext.create('Account.SUnit.Window');
		//this.tbar = [this.addAct, this.copyAct];
		this.whtDialog = Ext.create('Account.WHT.Window');

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
				'paypr',
				'sgtxt',
				'duedt',
				'perct',
				'pramt',
				'ctyp1',
				'chk01',
				'chk02',
				'disit',
				'whtnr',
				'whtpr'
			],
			remoteSort: true,
			sorters: ['vbelp ASC']
		});

		this.columns = [{
			xtype: 'actioncolumn',
			text: " ",
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete Deposit Receipt',
				scope: this,
				//disabled: true,
				handler: this.removeRecord
			}]
			},{
			id : 'DPRowNumber4',
			text : "Item No.",
			dataIndex : 'vbelp',
			width : 50,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
		}
			},{
			text: "Period No.",
			width: 60,
			dataIndex: 'paypr',
			align : 'center',
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			},{
			text: "Period Desc.",
			width: 240,
			dataIndex: 'sgtxt',
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			},
		    {text: "Period Date",
		    width: 100,
		    xtype: 'datecolumn',
		    dataIndex: 'duedt',
		    format:'d/m/Y',
		    sortable: true,
		    /*editor: {
                xtype: 'datefield',
                //allowBlank: false,
                format:'d/m/Y',
			    altFormats:'Y-m-d|d/m/Y',
			    submitFormat:'Y-m-d'
                //minText: 'Cannot have a start date before the company existed!',
                //maxValue: Ext.Date.format(new Date(), 'd/m/Y')
            }*/
			},
			{text: "Discount",
			//xtype: 'numbercolumn',
			width: 70,
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
			{text: "Amount/ %",
			width: 100,
			//xtype: 'textcolumn',
			dataIndex: 'perct',
			sortable: true,
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
			{text: "Amount",
			width: 100,
			dataIndex: 'pramt',
			xtype: 'numbercolumn',
			//sortable: true,
			align: 'right',
			/*renderer: function(v,p,r){
				var		percRaw = r.data['disit'];
				var net = parseFloat(r.data['itamt'].replace(/[^0-9.]/g, ''));
				if(percRaw!='0.00'){
				var		regEx = /%$/gi;
					if(regEx.test(percRaw)){
						var perc = parseFloat(percRaw.replace(regEx, '')),
							amt = (perc * net) / 100;
						return Ext.util.Format.usMoney(amt).replace(/\$/, '');
					}//else
					//if(percRaw>0)
						//return Ext.util.Format.usMoney(percRaw).replace(/\$/, '');
				//}
				}else{
					return Ext.util.Format.usMoney(net).replace(/\$/, '');
				}
				}*/
			},
			{text: "Currency",
			width: 70,
			dataIndex: 'ctyp1',
			//xtype: 'textcolumn',
			sortable: true,
			align: 'center',
			//editor: {
			//	xtype: 'textfield'
			//},
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
					url: __site_url+'invoice/loads_wht',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							//o.setValue(r.data.whtnr);
							_this.getForm().findField('whtnr').setValue(r.data.whtnr);
							_this.getForm().findField('whtpr').setValue(r.data.whtpr);
							//_this.getForm().findField('whtgp').setValue(r.data.whtgp);
						   
						}else{
							o.setValue('');
							_this.getForm().findField('whtpr').setValue('');
							//_this.getForm().findField('whtgp').setValue('');
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
				// change cell code value (use db value)
				rModel.set('whtnr', record.data.whtnr);
				rModel.set('whtpr', record.data.whtpr);
				//rModel.set('whtgp', record.data.whtgp);
			//_this.trigUnit.setValue(record.data.meins);
			}
            
			grid.getSelectionModel().deselectAll();
			_this.whtDialog.hide();
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
			rec = { id:0,matnr:'200019',maktx:'เงินมัดจำจ่าย',
			menge:1,meins:'EA',chk01:1,ctyp1:'THB',saknr:'1151-06' };
			edit = this.editing;
			edit.cancelEdit();
			// find current record
			//var sel = this.getView().getSelectionModel().getSelection()[0];
			//var selIndex = this.store.indexOf(sel);
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
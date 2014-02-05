Ext.define('Account.AP.Item.Grid_p', {
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
			disabeled: true,
			iconCls: 'b-small-copy'
		});

		this.tbar = [this.addAct, this.copyAct];
		
		this.partialDialog = Ext.create('Account.SPartialpay.MainWindow');

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"ap/loads_pay_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'vbeln,paypr'
				}
			},
			fields: [
			    'vbeln',
				'paypr',
				'sgtxt',
				'duedt',
				'perct',
				'pramt',
				'ctyp1',
				'payty',
				'loekz'
			],
			remoteSort: true,
			sorters: ['paypr ASC']
		});

		this.columns = [{
			xtype: 'actioncolumn',
			text: " ",
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete QT Payment',
				scope: this,
				handler: this.removeRecord2
			}]
			},{
			id : 'IVRowNumber01',
			text : "No.",
			dataIndex : 'paypr',
			width : 50,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
		    }
			},{
			text : "Periods No.",
			dataIndex : 'loekz',
			width : 70,
			align : 'center',
			sortable : false,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.partialDialog.show();
				}
			},
			},{
			text: "Period Desc.",
			width: 320,
			dataIndex: 'sgtxt',
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			},
		    {text: "Due Date",
		    width: 100,
		    xtype: 'datecolumn',
		    dataIndex: 'duedt',
		    format:'d/m/Y',
		    sortable: false,
		    /*editor: {
                xtype: 'datefield',
                allowBlank: false,
                format:'d/m/Y',
			    altFormats:'Y-m-d|d/m/Y',
			    submitFormat:'Y-m-d',
			    listeners: {
			    	'change':function(o){
			    		if(_this.startDate)
			    			o.setMinValue(_this.startDate);
			    	}
			    }
            }*/
			},
			{
				text: "Amt/ %",
				width: 70,
				//xtype: 'numbercolumn',
				dataIndex: 'perct',
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
			},
			
			{
				text: "Amount",
				width: 120,
				dataIndex: 'pramt',
				xtype: 'numbercolumn',
				//sortable: true,
				align: 'right',
				renderer: function(v,p,r){
					var net = _this.netValue,
						percRaw = r.data['perct'],
						regEx = /%$/gi;
					if(regEx.test(percRaw)){
						var perc = parseFloat(percRaw.replace(regEx, '')),
							amt = (perc * net) / 100;
						return Ext.util.Format.usMoney(amt).replace(/\$/, '');
					}else
						return Ext.util.Format.usMoney(percRaw).replace(/\$/, '');
				}
			},
			{text: "Currency",
			width: 70,
			dataIndex: 'ctyp1',
			//xtype: 'textcolumn',
			sortable: false,
			align: 'center',
			//editor: {
			//	xtype: 'textfield'
			//},
			}
		];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord2();
		});

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='loekz'){
				var v = e.value;
				var po = _this.poValue;

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'po/load_partial',
					method: 'POST',
					params: {
						id: v,
						po: po
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, r.data.paypr);
							rModel.set('sgtxt', r.data.sgtxt);
				            rModel.set('duedt', r.data.duedt);
				            rModel.set('perct', r.data.perct);
				            rModel.set('pramt', r.data.pramt);
				            rModel.set('ctyp1', r.data.ctyp1);

						}else{
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, '');
							rModel.set('sgtxt', '');
				            rModel.set('duedt', '');
				            rModel.set('perct', '');
				            rModel.set('pramt', '');
				            rModel.set('ctyp1', '');
							//_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
			
		});

		_this.partialDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];

				// change cell code value (use db value)
				rModel.set('loekz', record.data.paypr);
				rModel.set('sgtxt', record.data.sgtxt);
				rModel.set('duedt', record.data.duedt);
				rModel.set('perct', record.data.perct);
				rModel.set('pramt', record.data.pramt);
				rModel.set('ctyp1', record.data.ctyp1);

			}
			grid.getSelectionModel().deselectAll();
			_this.partialDialog.hide();
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
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;

        var cur = _this.curValue;
		// add new record
		rec = { id:newId, pramt:'0.00', ctyp1:cur };
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
	setpoCode: function(ebeln){
		this.poCode = ebeln;
		var field = this.partialDialog.searchForm.form.findField('ebeln');
		field.setValue(ebeln);
		this.partialDialog.grid.load();
	},
	netValue : 0,
	startDate: null
});
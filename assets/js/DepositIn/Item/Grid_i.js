Ext.define('Account.DepositIn.Item.Grid_i', {
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
		// this.invoiceDialog = Ext.create('Account.SInvoice.MainWindow');
		// END Invoice search popup //////////////////////////////////

		this.tbar = [this.addAct, this.copyAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"depositin/loads_dp_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'depnr,paypr'
				}
			},
			fields: [
			    //'vbeln',
				'paypr',
				'sgtxt',
				'duedt',
				'perct',
				'pramt',
				'ctyp1'
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
				tooltip: 'Delete Deposit Receipt',
				scope: this,
				handler: this.removeRecord2
			}]
			},{
			id : 'RowNumber4',
			text : "Periods No.",
			dataIndex : 'paypr',
			width : 90,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
		}
			},{
			text: "Period Desc.",
			width: 340,
			dataIndex: 'sgtxt',
			sortable: true,
			field: {
				type: 'textfield'
			}
			},
		    {text: "Period Date",
		    width: 100,
		    xtype: 'datecolumn',
		    dataIndex: 'duedt',
		    format:'d/m/Y',
		    sortable: true,
		    editor: {
                xtype: 'datefield',
                //allowBlank: false,
                format:'d/m/Y',
			    altFormats:'Y-m-d|d/m/Y',
			    submitFormat:'Y-m-d'
                //minText: 'Cannot have a start date before the company existed!',
                //maxValue: Ext.Date.format(new Date(), 'd/m/Y')
            }
			},
			{text: "Percent",
			width: 70,
			xtype: 'numbercolumn',
			dataIndex: 'perct',
			sortable: true,
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
			{text: "Amount",
			width: 150,
			dataIndex: 'pramt',
			xtype: 'numbercolumn',
			//sortable: true,
			align: 'right'/*,
			renderer: function(v,p,r){
				var net = _this.netValue;
				var perc = parseFloat(r.data['perct']);
				perc = isNaN(perc)?0:perc;
				if(perc>0){
                //net = isNaN(net)?0:net;
				var amt = (perc * net) / 100;
				return Ext.util.Format.usMoney(amt).replace(/\$/, '');
				}
				}*/
			},
			{text: "Currency",
			width: 70,
			dataIndex: 'ctyp1',
			//xtype: 'textcolumn',
			sortable: true,
			align: 'center',
			editor: {
				xtype: 'textfield'
			},
			}
		];

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord();
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
			r.set('paypr', row_num++);
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
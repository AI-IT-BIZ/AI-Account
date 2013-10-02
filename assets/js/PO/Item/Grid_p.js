Ext.define('Account.PR2.Item.Grid_p', {
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
		//this.deleteAct = new Ext.Action({
		//	text: 'Delete',
		//	iconCls: 'b-small-minus'
		//});

		this.tbar = [this.addAct, this.copyAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"quotation/loads_pay_item",
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
				'ctyp1'
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
				tooltip: 'Delete QT Payment',
				scope: this,
				handler: this.removeRecord2
			}]
			},{
			id : 'POpRowNumber2',
			header : "Periods No.",
			dataIndex : 'paypr',
			width : 90,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
		}
			},{
			text: "Period Desc.",
			width: 380,
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
			width: 100,
			xtype: 'numbercolumn',
			dataIndex: 'perct',
			sortable: true,
			align: 'right',
			editor: {
                xtype: 'numberfield',
                //allowBlank: false,
                minValue: 1,
                maxValue: 150000
            }
			},
			{text: "Amount",
			width: 150,
			dataIndex: 'pramt',
			xtype: 'numbercolumn',
			sortable: true,
			align: 'right',
			editor: {
                xtype: 'numberfield',
                allowBlank: false,
                
                renderer: function(v,p,r){
					var perc = parseFloat(r.data['perct']),
						//price = parseFloat(r.data['unitp']),
						net = parseFloat(r.data['netwr']);
					perc = isNaN(perc)?0:perc;
					net = isNaN(net)?0:net;

					var amt = (perc * net) / 100;
					    amt = net - amt;
					return Ext.util.Format.usMoney(amt).replace(/\$/, '');
            
            }}
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

		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: this.store,
			displayInfo: true
		};

		this.plugins = [this.editing];

		// init event
		this.addAct.setHandler(function(){
			_this.addRecord2();
		});

		return this.callParent(arguments);
	},

	load: function(options){
		this.store.load({
			params: options
		});
	},

	addRecord2: function(){
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id')<newId)
				newId = r.get('id');
		});
		newId--;

		// add new record
		rec = { id:newId, ctyp1:'THB' };
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
	}
});
Ext.define('Account.GR.Item.Grid_spec', {
	extend	: 'Ext.form.Panel',
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
		});
		// END Material search popup ///////////////////////////////////
        this.unitDialog = Ext.create('Account.SUnit.Window');
		this.tbar = [this.addAct, this.copyAct];*/

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"gr/loads_asset_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'matnr,matpr'
				}
			},
			fields: [
			    'matnr',
				'matpr',
				'serno',
			    'mtart',
			    'matkl',
				'saknr',
				'brand',
				'model',
				'specs',
				'assnr',
				'reque',
				'holds',
				'depnr',
				'keepi',
				'resid'
				
			],
			remoteSort: true,
			sorters: ['matpr ASC']
		});

		this.columns = [{
			id : 'FXiRowNumber',
			header : "Items",
			dataIndex : 'matpr',
			width : 50,
			align : 'center',
			resizable : false, sortable : false,
			//renderer : function(value, metaData, record, rowIndex) {
			//	return rowIndex+1;
			//}
		},
		{text: "Serial No.",
		width: 90,
		dataIndex: 'serno',
		sortable: false,
			field: {
				type: 'textfield'
			},
			},
		    {text: "Asset Type",
		    width: 60,
		    dataIndex: 'mtart',
		    sortable: false,
		    align: 'center'
		    },
			{text: "Asset Grp",
			xtype: 'numbercolumn',
			width: 60,
			dataIndex: 'matkl',
			sortable: false,
			align: 'center'
			},
			{text: "GL No.", width: 70, 
			dataIndex: 'saknr', sortable: false,
			},
			{text: "Brand",
			width: 120,
			dataIndex: 'brand',
			sortable: false
			},
			{text: "Model",
			width: 100,
			dataIndex: 'model',
			sortable: false
		    }
            {text: "Specification",
			width: 100,
			dataIndex: 'specs',
			sortable: false
			},
			{text: "Under Asset",
			width: 90,
			dataIndex: 'assnr',
			align: 'center',
			sortable: false
			},
			{text: "Requesting by",
			width: 50,
			dataIndex: 'reque',
			sortable: false,
			align: 'center'
		    },
		    {text: "Asset Holder",
			width: 90,
			dataIndex: 'holds',
			sortable: false
			},
		    {text: "Department",
		     width: 90,
		     dataIndex: 'depnr',
		     sortable: false
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
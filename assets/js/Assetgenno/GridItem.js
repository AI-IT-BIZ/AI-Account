Ext.define('Account.Assetgenno.GridItem', {
	extend	: 'Ext.grid.Panel',
	requires: [
		'Ext.ux.grid.FiltersFeature'
	],
	constructor:function(config) {
        
		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;
		
		Ext.QuickTips.init();

		//this.addAct = new Ext.Action({
		//	text: 'Add',
		//	iconCls: 'b-small-plus'
		//});

		// INIT GL search popup ///////////////////////////////////////////////
           //this.glnoDialog = Ext.create('Account.GL.MainWindow');
		// END GL search popup ///////////////////////////////////////////////

		//this.tbar = [this.addAct];// this.deleteAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'asset/loads_type',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_ass'
				}
			},
			fields: [
				{ name:'id_ass', type:'int' },
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
			remoteSort: false,
			sorters: ['id_ass ASC'],
			pageSize: 10000000
		});

		[{
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

        Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});

		this.plugins = [this.editing];


		// init event ///////
		//this.addAct.setHandler(function(){
		//	_this.addRecord();
		//});

		return this.callParent(arguments);
	},
	
	load: function(options){
		this.store.load(options);
	},
	
	addRecord: function(){
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;var i=0;
		this.store.each(function(r){
			i++;
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
		//alert(sel);
		var selIndex = this.store.indexOf(sel);
		//alert(selIndex);
		this.store.insert(i, rec);
		edit.startEditByPosition({
			row: i,
			column: 0
		});

		this.runNumRow();
	},
	
	save : function(){
		var _this=this;
		
		var r_data = this.getData();
		Ext.Ajax.request({
			url: __site_url+'asset/save_type',
			method: 'POST',
			params: {
				ftyp: Ext.encode(r_data)
			},
			success: function(response){
				var r = Ext.decode(response.responseText);
				if(r && r.success){
					//Ext.Msg.alert('SUCCESS');
		       }else{
		       	     Ext.Msg.alert(r.message);
		       		//Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
		       }
			}
		});
	},
	
	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);
		this.runNumRow();
	},
	
	reset: function(){
		//this.getForm().reset();
		// สั่ง grid load เพื่อเคลียร์ค่า
		this.grid.load({ mtart: 0 });
	},
	
	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	},

	runNumRow: function(){
		var row_num = 0;
		this.store.each(function(r){
			r.set('id_mtype', row_num++);
		});
	}
});
Ext.define('Account.Initdoc.GridItem', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
        /*Ext.apply(this, {
			url: __site_url+'customertype/save',
			border: false,
			//bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'right',
				//labelWidth: 130,
				//width:300,
				labelStyle: 'font-weight:bold'
			}
		});*/
		
		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		this.addAct = new Ext.Action({
			text: 'Add',
			iconCls: 'b-small-plus'
		});

		// INIT GL search popup ///////////////////////////////////////////////
        //this.glnoDialog = Ext.create('Account.GL.MainWindow');
		// END GL search popup ///////////////////////////////////////////////

		this.tbar = [this.addAct, this.deleteAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'initdoc/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id'
				}
			},
			fields: [
				{ name:'id', type:'int' },
				'objnr',
				'modul',
				'grpmo',
				'sgtxt',
				'short',
				'minnr',
				'perio',
				'tname',
				'tcode'
			],
			remoteSort: false,
			sorters: ['id ASC']
		});

		this.columns = [{
			xtype: 'actioncolumn',
			width: 30,
			sortable: false,
			menuDisabled: true,
			items: [{
				icon: __base_url+'assets/images/icons/bin.gif',
				tooltip: 'Delete Item',
				scope: this,
				handler: this.removeRecord
			}]
		},{
			id : 'NiRowNumber',
			header : "No.",
			dataIndex : 'id_doc',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},{
			text: "Object Code ",
		    width: 80,
		    dataIndex: 'objnr',
		    sortable: true,
		    field: {
				type: 'textfield'
			},
		},{
			text: "Object Desc.",
		    width: 100,
		    dataIndex: 'sgtxt',
		    sortable: true,
		    field: {
				type: 'textfield'
			},
		},{
			text: "Group No.", 
			width: 100,
			dataIndex: 'grpmo', 
			sortable: true
		},{
			text: "Short", 
			width: 100,
			dataIndex: 'grpmo', 
			sortable: true,
			field: {
				type: 'textfield'
				}
		},{
			text: "Start No.", 
			width: 100,
			dataIndex: 'minnr', 
			sortable: true,
			field: {
				type: 'textfield'
				}
		},{
			text: "Period No.", 
			width: 100,
			dataIndex: 'perio', 
			sortable: true,
			field: {
				type: 'textfield'
				}
		},{
			text: "Table Name", 
			width: 100,
			dataIndex: 'tname', 
			sortable: true,
			field: {
				type: 'textfield'
				}
		},{
			text: "Field Name", 
			width: 100,
			dataIndex: 'tcode', 
			sortable: true,
			field: {
				type: 'textfield'
				}
		}];

		this.plugins = [this.editing];


		// init event ///////
		this.addAct.setHandler(function(){
			_this.addRecord();
		});


		return this.callParent(arguments);
	},
	
	load: function(options){
		//alert("1234");
		this.store.load({
			params: options,
			proxy: {
				type: 'ajax',
				url: __site_url+'initdoc/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_doc'
				}
			},
			fields: [
				{ name:'id_doc', type:'int' },
				'objnr',
				'modul',
				'grpmo',
				'sgtxt',
				'short',
				'minnr',
				'perio'
			],
			remoteSort: false,
			sorters: ['id_doc ASC']
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
		//alert(sel);
		var selIndex = this.store.indexOf(sel);
		//alert(selIndex);
		this.store.insert(selIndex+1, rec);
		edit.startEditByPosition({
			row: selIndex+1,
			column: 0
		});

		this.runNumRow();
	},
	
	save : function(){
		var _this=this;
		
		var r_data = this.getData();
		Ext.Ajax.request({
			url: __site_url+'initdoc/save',
			method: 'POST',
			params: {
				init: Ext.encode(r_data)
			},
			success: function(response){
				var r = Ext.decode(response.responseText);
				if(r && r.success){
					Ext.Msg.alert('SUCCESS');
		       }else{
		       		Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
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
		this.grid.load({ objnr: 0 });
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
			r.set('id_doc', row_num++);
		});
	}
});
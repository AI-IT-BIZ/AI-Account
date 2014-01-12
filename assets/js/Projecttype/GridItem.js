Ext.define('Account.Projecttype.GridItem', {
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
			enabled: !UMS.CAN.CREATE('PJ'),
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
				url: __site_url+'project/loads_type',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_jtype',
					totalProperty: 'totalCount'
				}
			},
			fields: [
				{ name:'id_jtype', type:'int' },
				'jtype',
				'typtx'
			],
			remoteSort: false,
			sorters: ['id_jtype ASC']
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
			id : 'PMiRowNumber003',
			header : "Type ID",
			dataIndex : 'id_jtype',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},{
			text: "Type Code",
		    width: 100,
		    dataIndex: 'jtype',
		    sortable: true,
		    field: {
				type: 'textfield'
			},
		},{
			text: "Type Description",
		    width: 250,
		    dataIndex: 'typtx',
		    sortable: true,
		    field: {
				type: 'textfield'
			},
		}];
		
		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: this.store,
			displayInfo: true
		};

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
				url: __site_url+'project/loads_type',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_jtype'
				}
			},
			fields: [
				{ name:'id_jtype', type:'int' },
				'ptype',
				'protx'//,
				//'saknr',
				//'sgtxt'
			],
			remoteSort: false,
			sorters: ['id_jtype ASC']
		});
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
			url: __site_url+'project/save_type',
			method: 'POST',
			params: {
				jtyp: Ext.encode(r_data)
			},
			success: function(response){
				var r = Ext.decode(response.responseText);
				if(r && r.success){
					//Ext.Msg.alert('SUCCESS');
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
		this.grid.load({ jtype: 0 });
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
			r.set('id_jtype', row_num++);
		});
	}
});
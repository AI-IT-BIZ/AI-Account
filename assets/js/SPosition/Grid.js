//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.SPosition.Grid', {
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

		// INIT GL search popup ///////////////////////////////////////////////
           this.depnrDialog = Ext.create('Account.SDepartment.MainWindow');
		// END GL search popup ///////////////////////////////////////////////

		this.tbar = [this.addAct];// this.deleteAct];
		
		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});
		
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'sposition/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_depnr',
					totalProperty: 'totalCount'
				}
			},
			fields: [
			    { name:'id_depnr', type:'int'},
			    'depnr',
				'posnr',
				'postx',
				'deptx'
			],
			remoteSort: true,
			sorters: ['id_depnr ASC']
		});

		this.columns = [
			{
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
			id : 'PTiRowNumber011',
			header : "No",
			dataIndex : 'id_depnr',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},{
			text: "Department Code", 
			width: 100,
			dataIndex: 'depnr', 
			sortable: true,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				allowBlank : false,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.depnrDialog.grid.load();
					_this.depnrDialog.show();
				}
			}
		},{
			text: "Department", width: 125, 
			dataIndex: 'deptx', sortable: true
			},{
			text: "Position Code", width: 100, 
			dataIndex: 'posnr', 
			sortable: true,
			field: {
				type: 'textfield'
			}
			},{
			text: "Position", width: 150, 
			dataIndex: 'postx', 
			sortable: true,
			field: {
				type: 'textfield'
			}
			}
		];

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

		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='depnr'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;
				Ext.Ajax.request({
					url: __site_url+'sposition/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, r.data.depnr);
							rModel.set('deptx', r.data.deptx);

						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
		});

		_this.depnrDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];

				// change cell code value (use db value)
				rModel.set('depnr', record.data.depnr);
				rModel.set('deptx', record.data.deptx);

			}
			grid.getSelectionModel().deselectAll();
			_this.depnrDialog.hide();
		});

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
		//if(options){ alert(options); }
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
			url: __site_url+'sposition/save',
			method: 'POST',
			params: {
				posi: Ext.encode(r_data)
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
		//สั่ง grid load เพื่อเคลียร์ค่า
		this.grid.load({ depnr: 0 });
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
			r.set('id_depnr', row_num++);
		});
	}
});

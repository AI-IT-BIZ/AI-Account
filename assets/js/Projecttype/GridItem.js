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
					idProperty: 'id_jtype'
				}
			},
			fields: [
				{ name:'id_jtype', type:'int' },
				'jtype',
				'jobtx'
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
		    dataIndex: 'jobtx',
		    sortable: true,
		    field: {
				type: 'textfield'
			},
		}/*,{
			text: "GL no", 
			width: 100,
			dataIndex: 'saknr', 
			sortable: true,
			field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				allowBlank : false,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.glnoDialog.show();
				}
			},
			sortable: false
		},{
			text: "GL Description", 
			width: 150, 
			dataIndex: 'sgtxt', 
			sortable: true
		}*/];

		this.plugins = [this.editing];


		// init event ///////
		this.addAct.setHandler(function(){
			_this.addRecord();
		});

		/*this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='saknr'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'gl/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							var rModel = _this.store.getById(e.record.data.id);

							// change cell code value (use db value)
							rModel.set(e.field, r.data.saknr);
							rModel.set('sgtxt', r.data.sgtxt);

						}else{
							_this.editing.startEdit(e.record, e.column);
						}
					}
				});
			}
		});

		_this.glnoDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			var rModels = _this.getView().getSelectionModel().getSelection();
			if(rModels.length>0){
				rModel = rModels[0];

				// change cell code value (use db value)
				rModel.set('saknr', record.data.saknr);
				rModel.set('sgtxt', record.data.sgtxt);

			}
			grid.getSelectionModel().deselectAll();
			_this.glnoDialog.hide();
		});*/

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
			url: __site_url+'project/save_type',
			method: 'POST',
			params: {
				mtyp: Ext.encode(r_data)
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
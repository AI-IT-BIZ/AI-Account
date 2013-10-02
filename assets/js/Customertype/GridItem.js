Ext.define('Account.Customertype.GridItem', {
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
        this.glnoDialog = Ext.create('Account.GL.MainWindow');
		// END GL search popup ///////////////////////////////////////////////

		this.tbar = [this.addAct, this.deleteAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'customertype/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_ktype'
				}
			},
			fields: [
				{ name:'id_ktype', type:'int' },
				'ktype',
				'custx',
				'saknr',
				'sgtxt'
			],
			remoteSort: false,
			sorters: ['id_ktype ASC']
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
			id : 'PMiRowNumber',
			header : "Type ID",
			dataIndex : 'id_ktype',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},{
			text: "Type Code ",
		    width: 80,
		    dataIndex: 'ktype',
		    sortable: true,
		    field: {
				type: 'textfield'
			},
		},{
			text: "Type Description",
		    width: 100,
		    dataIndex: 'custx',
		    sortable: true,
		    field: {
				type: 'textfield'
			},
		},{
			text: "GL no", flex: true, dataIndex: 'saknr', sortable: true,
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
			text: "GL Description", width: 100, dataIndex: 'sgtxt', sortable: true
		}];

		this.plugins = [this.editing];


		// init event ///////
		this.addAct.setHandler(function(){
			_this.addRecord();
		});


		this.editing.on('edit', function(editor, e) {
			if(e.column.dataIndex=='saknr'){
				var v = e.value;

				if(Ext.isEmpty(v)) return;

				Ext.Ajax.request({
					url: __site_url+'sglAccount/loads',
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
							rModel.set(e.field, r.data.sgtxt);
							

							// change cell price value
							//rModel.set('price', 100+Math.random());

							// change cell amount value
							//rModel.set('amount', 100+Math.random());
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

				// change cell price value
				//rModel.set('price', 100+Math.random());

				// change cell amount value
				//rModel.set('amount', 100+Math.random());
			}
			grid.getSelectionModel().deselectAll();
			_this.glnoDialog.hide();
		});

		return this.callParent(arguments);
	},
	load: function(options){
		//alert("1234");
		this.store.load({
			params: options,
			proxy: {
				type: 'ajax',
				url: __site_url+'customertype/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_ktype'
				}
			},
			fields: [
				{ name:'id_ktype', type:'int' },
				'ktype',
				'custx',
				'saknr',
				'sgtxt'
			],
			remoteSort: false,
			sorters: ['id_ktype ASC']
		});
	},
	

	/*
	addRecord: function(){
		// หา record ที่สร้างใหม่ล่าสุด
		var newId = -1;
		this.store.each(function(r){
			if(r.get('id_vtype')<newId)
				newId = r.get('id_vtype');
		});
			alert(r.get('id_vtype'));
		newId--;

		// add new record
		rec = { id_vtype:newId, vtype:'', ventx:'', saknr:'', sgtxt:''       };
		edit = this.editing;
		edit.cancelEdit();
		this.store.insert(0, rec);
		edit.startEditByPosition({
			row: 0,
			column: 0
		});
	},*/
	
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
	
	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);
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
			r.set('id_vtype', row_num++);
		});
	},
});
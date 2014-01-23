Ext.define('Account.Customertype.GridItem', {
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
		var filters = {
			ftype: 'filters',
			local: true,
			filters: [{
				type: 'string',
				dataIndex: 'ktype'
			},{
				type: 'string',
				dataIndex: 'custx'
			},{
				type: 'string',
				dataIndex: 'saknr'
			},{
				type: 'string',
				dataIndex: 'sgtxt'
			}]
		};
        
		this.addAct = new Ext.Action({
			disabled: !UMS.CAN.CREATE('CS'),
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
					idProperty: 'id_ktype',
					totalProperty: 'totalCount'
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
			sorters: ['id_ktype ASC'],
			pageSize: 10000000
		});

		this.columns = [{
			xtype: 'actioncolumn',
			text: "Del",
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
			//id : 'PMiRowNumber77',
			text: "No",
			dataIndex : 'id_ktype',
			width : 60,
			align : 'center',
			//hidden: true,
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},{
			text: "Type Code",
		    width: 80,
		    dataIndex: 'ktype',
		    maxLenges: 4,
		    sortable: true,
		    field: {
				type: 'textfield',
			},
		},{
			text: "Type Description",
		    width: 150,
		    dataIndex: 'custx',
		    sortable: true,
		    maxLenges: 100,
		    field: {
				type: 'textfield',
			},
		},{
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
			width: 170, 
			dataIndex: 'sgtxt', 
			sortable: true
		}];
		
		Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});
		
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
							var rModel = _this.store.getById(e.record.data.id);
							rModel.set(e.field, '');
							rModel.set('sgtxt', '');
							//_this.editing.startEdit(e.record, e.column);
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
		//var sel = this.getView().getSelectionModel().getSelection()[0];
		//alert(sel);
		//var selIndex = this.store.indexOf(sel);
		//alert(i);
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
			url: __site_url+'customertype/save',
			method: 'POST',
			params: {
				ktyp: Ext.encode(r_data)
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
		this.grid.load({ ktype: 0 });
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
			r.set('id_ktype', row_num++);
		});
	}
});
Ext.define('Account.SMaterialtype.GridItem', {
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


		// INIT GL search popup ///////////////////////////////////////////////
           //this.glnoDialog = Ext.create('Account.GL.MainWindow');
		// END GL search popup ///////////////////////////////////////////////


		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'material/loads_type',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_mtype',
					totalProperty: 'totalCount'
				}
			},
			fields: [
				{ name:'id_mtype', type:'int' },
				'mtart',
				'matxt'
			],
			remoteSort: false,
			sorters: ['id_mtype ASC']
		});

		this.columns = [{
			id : 'MTiRowNumber001',
			header : "Type ID",
			dataIndex : 'id_mtype',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},{
			text: "Type Code",
		    width: 100,
		    dataIndex: 'mtart',
		    sortable: true,
		    //field: {
			//	type: 'textfield'
			//},
		},{
			text: "Type Description",
		    width: 250,
		    dataIndex: 'matxt',
		    sortable: true,
		    //field: {
			//	type: 'textfield'
			//},
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

		//this.plugins = [this.editing];


		// init event ///////
		//this.addAct.setHandler(function(){
		//	_this.addRecord();
		//});

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
				url: __site_url+'material/loads_type',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_mtype'
				}
			},
			fields: [
				{ name:'id_mtype', type:'int' },
				'mtart',
				'matxt'//,
				//'saknr',
				//'sgtxt'
			],
			remoteSort: false,
			sorters: ['id_mtype ASC']
		});
	},
	
	save : function(){
		var _this=this;
		
		var r_data = this.getData();
		Ext.Ajax.request({
			url: __site_url+'material/save_type',
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
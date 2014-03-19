Ext.define('Account.SMaterialtype.GridItem', {
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
				dataIndex: 'mtart'
			},{
				type: 'string',
				dataIndex: 'matxt'
			}]
		};

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'material/loads_type',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'mtart',
					totalProperty: 'totalCount'
				}
			},
			fields: [
				//{ name:'id_mtype', type:'int' },
				'mtart',
				'matxt'
			],
			remoteSort: false,
			sorters: ['mtart ASC'],
			pageSize: 10000000
		});

		this.columns = [{
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
		
		this.bbar = {
			xtype: 'pagingtoolbar',
		//	pageSize: 10,
			store: this.store,
			displayInfo: true
		};
		
		Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});

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
	}
});
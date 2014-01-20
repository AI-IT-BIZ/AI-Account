//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.SPosition.Grid', {
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
				dataIndex: 'depnr'
			},{
				type: 'string',
				dataIndex: 'posnr'
			},{
				type: 'string',
				dataIndex: 'postx'
			},{
				type: 'string',
				dataIndex: 'deptx'
			}]
		};
		
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'sposition/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.depnr+o.posnr; },
					totalProperty: 'totalCount'
				}
			},
			fields: [
			    //{ name:'id_depnr', type:'int'},
			    'depnr',
				'posnr',
				'postx',
				'deptx'
			],
			remoteSort: false,
			sorters: ['posnr ASC']//,
			//pageSize: 10000000
		});

		this.columns = [
			{
			text: "Department Code", 
			width: 100,
			dataIndex: 'depnr', 
			sortable: true,
			/*field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				allowBlank : false,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.depnrDialog.grid.load();
					_this.depnrDialog.show();
				}
			}*/
		},{
			text: "Department", width: 125, 
			dataIndex: 'deptx', sortable: true
			},{
			text: "Position Code", width: 100, 
			dataIndex: 'posnr', 
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			},{
			text: "Position", width: 150, 
			dataIndex: 'postx', 
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			}
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			//pageSize: 10,
			store: this.store,
			displayInfo: true
		};
		
		Ext.apply(this, {
			forceFit: true,
			features: [filters]
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
	}
});

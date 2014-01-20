//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.SDepartment.Grid', {
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
				dataIndex: 'deptx'
			}]
		};
		
		
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'sposition/loads_dep',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'depnr',
					totalProperty: 'totalCount'
				}
			},
			fields: [
			   // { name:'id_depnr2', type:'int'},
			    'depnr',
				'deptx'
			],
			remoteSort: false,
			sorters: ['depnr ASC']//,
			//pageSize: 10000000
		});

		this.columns = [
			{
			text: "Department Code", 
			width: 100,
			dataIndex: 'depnr', 
			sortable: true,
			field: {
				type: 'textfield'
			}
		},{
			text: "Department", width: 125, 
			dataIndex: 'deptx', 
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
		
		Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});
		
		this.plugins = [this.editing];
		
		// init event ///////
		this.addAct.setHandler(function(){
			_this.addRecord2();
		});

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
		//if(options){ alert(options); }
	},
	addRecord2: function(){
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
			url: __site_url+'sposition/save_dep',
			method: 'POST',
			params: {
				depn: Ext.encode(r_data)
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



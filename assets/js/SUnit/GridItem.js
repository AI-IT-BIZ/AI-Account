Ext.define('Account.SUnit.GridItem', {
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
				dataIndex: 'meins'
			},{
				type: 'string',
				dataIndex: 'matxt'
			}]
		};

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'unit/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_unit',
					totalProperty: 'totalCount'
				}
			},
			fields: [
				//{ name:'id_unit', type:'int' },
				'meins',
				'metxt'
			],
			remoteSort: false,
			sorters: ['id_unit ASC']
		});

		this.columns = [{
			text: "Unit Code ",
		    width: 80,
		    dataIndex: 'meins',
		    sortable: true,
		    //field: {
			//	type: 'textfield'
			//},
		},{
			text: "Unit Description",
		    width: 100,
		    dataIndex: 'metxt',
		    sortable: true,
		    //field: {
			//	type: 'textfield'
			//},
		}];
		
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

		return this.callParent(arguments);
	},
	
	load: function(options){
		//alert("1234");
		this.store.load({
			params: options,
			proxy: {
				type: 'ajax',
				url: __site_url+'unit/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_unit'
				}
			},
			fields: [
				{ name:'id_unit', type:'int' },
				'meins',
				'metxt'
			],
			remoteSort: false,
			sorters: ['id_unit ASC']
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
			url: __site_url+'unit/save',
			method: 'POST',
			params: {
				unit: Ext.encode(r_data)
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
		this.grid.load({ meins: 0 });
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
			r.set('id_unit', row_num++);
		});
	}
});
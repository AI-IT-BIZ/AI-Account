Ext.define('Account.SAssetgrp.GridItem', {
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
				dataIndex: 'matkl'
			},{
				type: 'string',
				dataIndex: 'matxt'
			},{
				type: 'string',
				dataIndex: 'mtart'
			},{
				type: 'string',
				dataIndex: 'saknr'
			},{
				type: 'string',
				dataIndex: 'sgtxt'
			},{
				type: 'string',
				dataIndex: 'depre'
			}]
		};

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'asset/loads_grp',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'matkl',
					totalProperty: 'totalCount'
				}
			},
			fields: [
				//{ name:'id_mgrp', type:'int' },
				'matkl',
				'matxt',
				'mtart',
				'saknr',
				'sgtxt',
				'depre'
			],
			remoteSort: false,
			sorters: ['matkl ASC']
		});

		this.columns = [/*{
			id : 'FAiRowNumber004',
			header : "Type ID",
			dataIndex : 'id_mgrp',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},*/{
			text: "Group Code",
		    width: 80,
		    dataIndex: 'matkl',
		    sortable: true,
		    //field: {
			//	type: 'textfield'
			//},
		},{
			text: "Group Description",
		    width: 150,
		    dataIndex: 'matxt',
		    sortable: true,
		    //field: {
			//	type: 'textfield'
			//},
		},{
			text: "Type Code",
		    width: 80,
		    dataIndex: 'mtart',
		    sortable: true,
		    //field: {
			//	type: 'textfield'
			//},
		},{
			text: "GL no", 
			width: 100,
			dataIndex: 'saknr', 
			sortable: true
		},{
			text: "GL Description", 
			width: 200, 
			dataIndex: 'sgtxt', 
			sortable: true
		},{
			text: "Depreciation(%)", 
			width: 100, 
			dataIndex: 'depre', 
			sortable: true
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
				url: __site_url+'asset/loads_grp',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_mgrp'
				}
			},
			fields: [
				{ name:'id_mgrp', type:'int' },
				'mtart',
				'matxt',
				'saknr',
				'sgtxt',
				'depre'
			],
			remoteSort: false,
			sorters: ['id_mgrp ASC']
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
			url: __site_url+'asset/save_grp',
			method: 'POST',
			params: {
				fgrp: Ext.encode(r_data)
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
		this.grid.load({ matkl: 0 });
	},
	
	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	}
});
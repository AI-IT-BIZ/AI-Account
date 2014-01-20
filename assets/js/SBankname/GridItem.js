//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.SBankname.GridItem', {
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
				dataIndex: 'bcode'
			},{
				type: 'string',
				dataIndex: 'bname'
			},{
				type: 'string',
				dataIndex: 'addrs'
			},{
				type: 'string',
				dataIndex: 'saknr'
			},{
				type: 'string',
				dataIndex: 'sgtxt'
			}]
		};
		
		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'bankname/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'bcode',
					totalProperty: 'totalCount'
				}
			},
			fields: [
			    //{ name:'id_bname', type:'int' },
				'bcode',
				'bname',
				'addrs',
				'saknr',
				'sgtxt'
			],
			remoteSort: true,
			sorters: ['bcode ASC']//,
			//pageSize: 10000000
		});

		this.columns = [
			{text: "Bank Code", align: 'center',
			width: 100, dataIndex: 'bcode', 
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			},
			{text: "Bank Name", 
			width: 150, dataIndex: 'bname', 
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			},
			{text: "Address", 
			width: 125, dataIndex: 'addrs', 
			sortable: true,
			//field: {
			//	type: 'textfield'
			//}
			},{
			text: "GL no", 
			width: 100,
			dataIndex: 'saknr', 
			sortable: true
			/*field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				allowBlank : false,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
					_this.editing.completeEdit();
					_this.glnoDialog.show();
				}
			},
			sortable: false*/
		},{
			text: "GL Description", 
			width: 170, 
			dataIndex: 'sgtxt', 
			sortable: true
		}
		];
		
		Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load(options);
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
			url: __site_url+'bankname/save',
			method: 'POST',
			params: {
				bnam: Ext.encode(r_data)
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
		this.grid.load({ bcode: 0 });
	},
	
	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	}
});


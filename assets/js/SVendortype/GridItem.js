Ext.define('Account.SVendortype.GridItem', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+'vendortype/loads',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_vtype',
					totalProperty: 'totalCount'
				}
			},
			fields: [
				{ name:'id_vtype', type:'int' },
				'vtype',
				'ventx',
				'saknr',
				'sgtxt'
			],
			remoteSort: false,
			sorters: ['id_vtype ASC']
		});

		this.columns = [{
			id : 'PMiRowNumber01',
			header : "No",
			dataIndex : 'id_vtype',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},{
			text: "Vendor Type",
		    width: 80,
		    dataIndex: 'vtype',
		    sortable: true,
		    //field: {
			//	type: 'textfield',
			//	readOnly: true
			//},
		},{
			text: "Type Description",
		    width: 150,
		    dataIndex: 'ventx',
		    sortable: true,
		    //field: {
			//	type: 'textfield',
			//	disabled: true
			//},
		},{
			text: "GL no", flex: true, dataIndex: 'saknr', sortable: true
		},{
			text: "GL Description", width: 170, dataIndex: 'sgtxt', sortable: true
		}];
		
		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: this.store,
			displayInfo: true
		};

		return this.callParent(arguments);
	},
	
	load: function(options){
		this.store.load({
			params: options
		});
	},
	
	save : function(){
		var _this=this;
		
		var r_data = this.getData();
		Ext.Ajax.request({
			url: __site_url+'vendortype/save',
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
//http://www.sencha.com/blog/using-ext-loader-for-your-application

Ext.define('Account.GenAsset.Grid', {
	extend	: 'Ext.grid.Panel',
	requires: [
		'Ext.ux.grid.FiltersFeature'
	],
	constructor:function(config) {

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.preview = Ext.create('Account.Assetgenno.PreviewWindow');

		Ext.QuickTips.init();
		var filters = {
			ftype: 'filters',
			local: true,
			filters: [{
				type: 'string',
				dataIndex: 'matnr'
			},{
				type: 'string',
				dataIndex: 'maktx'
			},{
				type: 'string',
				dataIndex: 'mbeln'
			},{
				type: 'string',
				dataIndex: 'bldat'
			},{
				type: 'string',
				dataIndex: 'matpr'
			}]
		};

		//this.addAct = new Ext.Action({
		//	text: 'Add',
		//	iconCls: 'b-small-plus'
		//});

		// INIT GL search popup ///////////////////////////////////////////////
           //this.depnrDialog = Ext.create('Account.SDepartment.MainWindow');
		// END GL search popup ///////////////////////////////////////////////

		this.tbar = [this.addAct];// this.deleteAct];

		this.editing = Ext.create('Ext.grid.plugin.CellEditing', {
			clicksToEdit: 1
		});

		this.store = new Ext.data.JsonStore({
			// store configs
			proxy: {
				type: 'ajax',
				url: __site_url+'asset/loads_tag',
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'id_matnr',
					totalProperty: 'totalCount'
				}
			},
			fields: [
			   { name:'id_matnr', type:'int'},
			    'matnr',
				'maktx',
				'matpr',
				'menge',
				'mbeln',
				'bldat',
				'lvorm'
			],
			remoteSort: false,
			sorters: ['id_matnr2 ASC'],
			pageSize: 10000000
		});

		this.columns = [
			{
			//id : 'DPiRowNumber05',
			text : "No",
			dataIndex : 'id_matnr',
			width : 60,
			align : 'center',
			resizable : false, sortable : false,
			renderer : function(value, metaData, record, rowIndex) {
				return rowIndex+1;
			}
		},{
			text: "FA Code",
			width: 100,
			dataIndex: 'matnr',
			sortable: true
		},{
			text: "FA Name",
			width: 150,
			dataIndex: 'maktx',
			sortable: true,
			maxLenges: 100
			},{
			text: "FA Tag No.",
			width: 100,
			dataIndex: 'matpr',
			sortable: true
		},{
			text: "GR No",
			width: 100,
			dataIndex: 'mbeln',
			sortable: true
		},{text: "GR Date", width: 80, 
			xtype: 'datecolumn', align: 'center', 
			format:'d/m/Y', dataIndex: 'bldat', sortable: true
		},{
			xtype: 'checkcolumn',
			text: "Print",
			width: 30,
			dataIndex: 'lvorm',
			field: {
                xtype: 'checkboxfield',
                listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}}
			},
		{text: "1",hidden: true,
		 width: 0,
		 dataIndex: 'menge',
		 sortable: false},
		];

		//this.bbar = {
		//	xtype: 'pagingtoolbar',
			//pageSize: 10,
		//	store: this.store,
		//	displayInfo: true
		//};

		Ext.apply(this, {
			forceFit: true,
			features: [filters]
		});

		this.plugins = [this.editing];

		// init event ///////
		//this.addAct.setHandler(function(){
		//	_this.addRecord2();
		//});

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load({
			params: options
		});
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

		this.runNumRow2();
	},

	save : function(){
		var _this=this;
		var matnr='';
        _this.store.each(function(r){
			matnr = r.get('matnr');
		});
		var r_data = this.getData();
		Ext.Ajax.request({
			url: __site_url+'asset/save_tag',
			method: 'POST',
			params: {
				matnr:matnr,
				fatp: Ext.encode(r_data)
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
	
	barcode : function(){
		var _this=this;
		var matpr='';
        _this.store.each(function(r){
        	if(r.get('lvorm')){
        		if(matpr==""){matpr = "'"+r.get('matpr')+"'";}
				else {matpr = matpr+","+"'"+r.get('matpr')+"'";}
			}
		});
		_this.preview.openDialog(__base_url + 'index.php/asset/barcode?matpr='+matpr,'_blank');
		/*Ext.Ajax.request({
			url: __site_url+'asset/save_tag',
			method: 'POST',
			params: {
				matpr:matpr,
				fatp: Ext.encode(r_data)
			},
			success: function(response){
				var r = Ext.decode(response.responseText);
				if(r && r.success){
					//Ext.Msg.alert('SUCCESS');
		       }else{
		       		Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
		       }
			}
		});*/
	},

	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);
		this.runNumRow2();
	},

	reset: function(){
		//this.getForm().reset();
		//สั่ง grid load เพื่อเคลียร์ค่า
		this.grid.load({ matpr: 0 });
	},

	getData: function(){
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		return rs;
	},

	runNumRow2: function(){
		var row_num = 0;
		this.store.each(function(r){
			r.set('id_matnr2', row_num++);
		});
	}
});



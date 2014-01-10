Ext.define('Account.Asset.Import.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			viewConfig: {
				getRowClass: function(r, rowIndex, rowParams, store){
					var s = r.get('error');
					if(s && s.length>0)
						return 'red-bg-row';
				}
			},
			buttonAlign: 'center'
		});

		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		this.importAct = new Ext.Action({
			text: 'Import',
			iconCls: 'b-small-save'
		});

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"import/asset/read",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'row_id'
				},
				simpleSortMode: true
			},
			fields: [
				'row_id',
				'matnr', //Material No
				'maktx', //Material Name
				'matkl', //Material Group
				'mtart', //Material Type
				'meins', //Unit
				'saknr', //GL Account
				'beqty', //Beginning Qty
				'beval', //Beginning Value
				'cosav', //Average Cost
				'enqty', //Ending Qty
				'enval', //Ending Value
				'unit1', //Unit 1
				'cost1', //Cost 1
				'unit2', //Unit 2
				'cost2', //Cost 2
				'unit3', //Unit 3
				'cost3', //Cost 3
				'statu', //Status
				'error' 
			],
			remoteSort: false

		});

		this.columns = [{
				xtype: 'actioncolumn',
				text: " ",
				width: 30,
				sortable: false,
				menuDisabled: true,
				items: [{
					icon: __base_url+'assets/images/icons/bin.gif',
					tooltip: 'Delete Item',
					scope: this,
					handler: this.removeRecord
				}]
			},
			{text: "Asset Code", width: 100, align: 'center',		dataIndex: 'matnr', sortable: false},
			{text: "Asset Name", width: 150, align: 'center',		dataIndex: 'maktx', sortable: false},
			{text: "Asset Group", width: 100, align: 'center',		dataIndex: 'matkl', sortable: false},
			{text: "Asset Type", width: 80, align: 'center',		dataIndex: 'mtart', sortable: false},
			{text: "Unit", width: 80, align: 'center',		dataIndex: 'unit1', sortable: false},
			{text: "Cost", width: 80, align: 'center',		dataIndex: 'cost1', sortable: false},
			{
				text: "Error", width: 250, dataIndex: 'error', sortable: false,
				renderer: function(v,p,r){
					return (v && v.length>0)?v:'-';
				}
			}
		];

		this.buttons = [this.importAct];

		this.importAct.setHandler(function(){
			_this.importData();
		});

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load({
			params: options
		});
	},
	showMask: function(msg, msgClass){
		msg = msg||'Please select excel file for upload.';
		msgClass = msgClass||'grid-disable';
		this.importAct.setDisabled(true);
		this.getEl().mask(msg, msgClass);
	},
	hideMask: function(){
		this.importAct.setDisabled(false);
		this.getEl().unmask();
	},
	removeRecord: function(grid, rowIndex){
		this.store.removeAt(rowIndex);
		this.runNumRow();
		grid.getSelectionModel().deselectAll();
	},
	importData: function(){
		var _this=this;
		var rs = [];
		this.store.each(function(r){
			rs.push(r.getData());
		});
		if(rs.length>0){
			this.showMask('Importing please wait', '');
			var data_json = Ext.encode(rs);
			Ext.Ajax.request({
				url: __site_url+'import/material/import',
				params: {
					data: data_json
				},
				success: function(response){
					var text = response.responseText;
					var data = Ext.decode(text);
					if(data.success){
						Ext.Msg.show({
							title: 'Import success.',
							msg: 'Import '+data.rows.length+' rows success.',
							buttons: Ext.Msg.OK,
							icon: Ext.MessageBox.INFO
						});
						_this.fireEvent('import_success', data);
					}else{
						_this.hideMask();
						Ext.Msg.show({
							title: 'An error occured.',
							msg: response,
							buttons: Ext.Msg.OK,
							icon: Ext.MessageBox.ERROR
						});
					}
				},
				failure: function(response){
					Ext.Msg.show({
						title: 'An error occured.',
						msg: response.responseText,
						buttons: Ext.Msg.OK,
						icon: Ext.MessageBox.ERROR
					});
				}
			});
		}else{
			Ext.Msg.alert('Status', 'No datas to import.');
		}
	}
});
Ext.define('Account.ChartOfAccounts.Import.Grid', {
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
				url: __site_url+"import/ChartOfAccounts/read",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'row_id'
				},
				simpleSortMode: true
			},
			fields: [
				'row_id',
				'saknr', //GL Code
				'sgtxt', //GL Name
				'entxt', //GL Name Eng
				'glgrp', //GL Group
				'level', //Level
				'gltyp', //GL Type
				'overs', //GL Over
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
			{text: "GL Code", width: 50, align: 'center',		dataIndex: 'saknr', sortable: false},
			{text: "GL Name", width: 100, align: 'center',		dataIndex: 'sgtxt', sortable: false},
			{text: "GL Name Eng", width: 100, align: 'center',		dataIndex: 'entxt', sortable: false},
			{text: "GL Group", width: 50, align: 'center',		dataIndex: 'glgrp', sortable: false},
			{text: "Level", width: 30, align: 'center',		dataIndex: 'level', sortable: false},
			{text: "GL Type", width: 30, align: 'center',		dataIndex: 'gltyp', sortable: false},
			{text: "GL Over", width: 50, align: 'center',		dataIndex: 'overs', sortable: false},
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
				url: __site_url+'import/ChartOfAccounts/import',
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
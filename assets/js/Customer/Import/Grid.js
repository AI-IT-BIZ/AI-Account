Ext.define('Account.Customer.Import.Grid', {
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
				url: __site_url+"import/customer/read",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'row_id'
				},
				simpleSortMode: true
			},
			fields: [
				'row_id',
				'kunnr', //Customer Code
				'ktype', //Customer Type
				'name1', //Customer Name
				'adr01', //Address
				'distx', //Province
				'cunt1', //Country
				'pstlz', //Post Code
				'email', //Email
				'telf1', //Phone Number
				'telfx', //Fax Number
				'pson1', //Cantact Person
				'adr02', //Address 2
				'dis02', //Province 2
				'cunt2', //Country 2
				'pst02', //Post Code 2
				'emai2', //Email 2
				'tel02', //Phone Number 2
				'telf2', //Fax Number 2
				'pson2', //Contact Person 2
				'ptype', //Payment
				'term', //Credit Terms
				'apamt', //Credit Limit
				'pleve', //Price Level
				'taxnr', //Vat Type
				'vat01', //Vat Value
				'begin', //Minimum Amount
				'edin', //Maximum Amount
				'taxid', //Tax ID
				'saknr', //GL Account
				'note1', //Text Notes
				'statu', //Customer Status
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
			{text: "Customer Code", width: 100, align: 'center',		dataIndex: 'kunnr', sortable: false},
			{text: "Customer Name", width: 150, align: 'center',		dataIndex: 'name1', sortable: false},
			{text: "Address", width: 200, align: 'center',		dataIndex: 'adr01', sortable: false},
			{text: "Province", width: 80, align: 'center',		dataIndex: 'distx', sortable: false},
			{text: "Post Code", width: 80, align: 'center',		dataIndex: 'pstlz', sortable: false},
			{text: "GL Number", width: 80, align: 'center',		dataIndex: 'saknr', sortable: false},
			{text: "Email", width: 100, align: 'center',		dataIndex: 'email', sortable: false},
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
				url: __site_url+'import/customer/import',
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
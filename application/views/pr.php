<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>AI Account</title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/ext/resources/css/ext-all-neptune.css') ?>" />
	<script type="text/javascript" src="<?= base_url('assets/ext/ext-all.js') ?>"></script>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body>

	<script type="text/javascript">
requires: ['*'];
Ext.onReady(function() {


	var addAct = new Ext.Action({
		text: 'เพิ่ม',
		iconCls: 'b-small-plus'
	});

	// create the Data Store
	var store = new Ext.data.JsonStore({
		// store configs
		proxy: {
			type: 'ajax',
			url: '<?= site_url("pr/loads") ?>',
			reader: {
				type: 'json',
				root: 'rows',
				idProperty: 'id'
			}
		},
		fields: [
			{name:'id', type: 'int'},
			'code',
			{name:'create_date'},
			'create_by',
			{name:'update_date'},
			'update_by'
		],
		remoteSort: true,
		sorters: ['id ASC']
	});

	// create the grid
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		columns: [
			{text: "Id", width: 120, dataIndex: 'id', sortable: true},
			{text: "รหัส", flex: true, dataIndex: 'code', sortable: true},
			{text: "create_date", width: 125, dataIndex: 'create_date', sortable: true}
		],
		forceFit: true,
		height:210,
		split: true,
		region: 'center',
		tbar : [
			addAct
		],
		bbar: {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: store,
			displayInfo: true
		}
	});

	var form = Ext.widget('form', {
		url: '<?= site_url("pr/save") ?>',
		layout: {
			type: 'vbox',
			align: 'stretch'
		},
		border: false,
		bodyPadding: 10,
		fieldDefaults: {
			labelAlign: 'top',
			labelWidth: 100,
			labelStyle: 'font-weight:bold'
		},
		items: [{
			xtype: 'textfield',
			fieldLabel: 'Code',
			name: 'code',
			allowBlank: false
		}],

		buttons: [{
			text: 'Cancel',
			handler: function() {
				this.up('form').getForm().reset();
				this.up('window').hide();
			}
		}, {
			text: 'Send',
			handler: function() {
				var _this=this;
				var _form = this.up('form').getForm();
				if (_form.isValid()) {
					_form.submit({
						success: function(form_basic, action) {
							//Ext.Msg.alert('Success', action.result.message);
							var evt = form.fireEvent('afterSave', form_basic);
						},
						failure: function(form_basic, action) {
							Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
						}
					});
				}
			}
		}]
	});

	var dialog = Ext.widget('window', {
		title: 'Contact Us',
		closeAction: 'hide',
		height: 180,
		minHeight: 180,
		width: 300,
		minWidth: 300,
		layout: 'fit',
		resizable: true,
		modal: true,
		items: form,
		defaultFocus: 'code'
	});

	store.load();

	addAct.setHandler(function(){
		dialog.show();
	});

	form.addEvents('afterSave');
	form.on('afterSave', function(form_basic){
		form_basic.reset();
		store.load();
		dialog.hide();
	});

	////////////////////////////////////////////
	// VIEWPORT

	var viewport = Ext.create('Ext.Viewport', {
		layout: {
			type: 'border',
			padding: 5
		},
		defaults: {
			split: true
		},
		items: [
			grid,
			{
				region: 'north',
				collapsible: true,
				title: 'North',
				//split: true,
				height: 100,
				minHeight: 60,
				html: 'north'
			}
		]
	});
});

	</script>


</body>
</html>
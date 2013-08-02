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
Ext.require(['*']);
Ext.onReady(function() {

    // Add button
	var addAct = new Ext.Action({
		text: 'Add',
		iconCls: 'b-small-plus'
	});
	var editAct = new Ext.Action({
		text: 'Edit',
		iconCls: 'b-small-pencil'
	});
	var deleteAct = new Ext.Action({
		text: 'Delete',
		iconCls: 'b-small-minus'
	});

	// create the Data Store
	var store = new Ext.data.JsonStore({
		// store configs
		proxy: {
			type: 'ajax',
			url: '<?= site_url("mattype/loads") ?>',
			reader: {
				type: 'json',
				root: 'rows',
				idProperty: 'mtart'
			}
		},
		fields: [
			'mtart',
			'matxt',
			{name:'erdat'},
			'ernam',
			//{name:'update_date'},
			//'update_by'
		],
		remoteSort: true,
		sorters: ['mtart ASC']
	});

	// create the grid
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		columns: [
			{text: "Mat Type", width: 120, dataIndex: 'mtart', sortable: true},
			{text: "Description", flex: true, dataIndex: 'matxt', sortable: true},
			{text: "Create Date", width: 125, dataIndex: 'erdat', sortable: true},
			{text: "Create Name", width: 125, dataIndex: 'ernam', sortable: true}
		],
		forceFit: false,
		height:210,
		split: true,
		region: 'center',
		tbar : [
			addAct, editAct, deleteAct
		]
	});

	var form = Ext.widget('form', {
		url: '<?= site_url("mattype/save") ?>',
		layout: {
			type: 'vbox',
			align: 'stretch'
		},
		border: false,
		//bodyPadding: 10,
		bodyPadding: '5 5 0',
		fieldDefaults: {
			//labelAlign: 'top',
			msgTarget: 'side',
			labelWidth: 110,
			labelStyle: 'font-weight:bold'
		},

		items: [{
			xtype: 'textfield',
			fieldLabel: 'Mat-Type Code',
			name: 'mtart',
			allowBlank: false,
			tooltip: 'Enter your Mat-Type Code'
		}, {
			xtype: 'textfield',
			fieldLabel: 'Mat-Type Name',
			name: 'matxt',
			allowBlank: true,
			tooltip: 'Enter your Mat-Type Name'
		}],

		buttons: [{
			text: 'Save',
			handler: function() {
				var form = this.up('form').getForm();
				if (form.isValid()) {
					form.submit({
	                    success: function(form, action) {
	                       Ext.Msg.alert('Success', 'Already Saved Data');
	                       form.reset();
	                       
	                    },
	                    failure: function(form, action) {
	                        Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
	                        
	                    }
	                });
				}
			}
		}, {
			text: 'Cancel',
			handler: function(form_basic, action) {
				var evt = form.fireEvent('afterCancel');
				this.up('form').getForm().reset();
				this.up('window').hide();
				
			}
		}]
	});

	var dialog = Ext.widget('window', {
		title: 'Material Type',
		closeAction: 'hide',
		height: 180,
		minHeight: 180,
		width: 350,
		minWidth: 300,
		layout: 'fit',
		resizable: true,
		modal: true,
		items: form,
		defaultFocus: 'mtart'
	});

	store.load();

	addAct.setHandler(function(){
		dialog.show();
	});
	
	editAct.setHandler(function(){
		dialog.show();
	});
	
	deleteAct.setHandler(function(){
		var selection = grid.getView().getSelectionModel().getSelection()[0];
                    if (selection) {
                        store.remove(selection);
                    }
	});
	
	form.addEvents('afterCancel');
	form.on('afterCancel', function(){
		//form_basic.reset();
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
			grid//,
			/*{
				region: 'north',
				collapsible: true,
				title: 'North',
				//split: true,
				height: 100,
				minHeight: 60,
				html: 'north'
			}*/
		]
	});
});

	</script>


</body>
</html>
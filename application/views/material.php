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
			url: '<?= site_url("material/loads") ?>',
			reader: {
				type: 'json',
				root: 'rows',
				idProperty: 'matnr'
			}
		},
		fields: [
			{name:'matnr'},
			'maktx',
	        'mtart',
	        'meins',
	        'saknr',
	        
	        'cost1',
	        'cost2',
	        'cost3',
	        
			{name:'erdat'},
			'ernam',
			{name:'updat'},
			'upnam'
		],
		remoteSort: true,
		sorters: ['matnr ASC']
	});

	// create the grid
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		columns: [
			{text: "Material Code", width: 70, dataIndex: 'matnr', sortable: true},
			{text: "Material Name", width: 120, dataIndex: 'maktx', sortable: true},
			{text: "Material Type", width: 50, dataIndex: 'mtart', sortable: true},
			{text: "Unit", width: 40, dataIndex: 'meins', sortable: true},
			{text: "GL Account", width: 70, dataIndex: 'saknr', sortable: true},
			{text: "Cost 1", width: 50, dataIndex: 'cost1', sortable: true},
			{text: "Cost 2", width: 50, dataIndex: 'cost2', sortable: true},
			{text: "Cost 3", width: 50, dataIndex: 'cost3', sortable: true},
			{text: "Create Date", width: 50, dataIndex: 'erdat', sortable: true},
			{text: "Create Name", width: 40, dataIndex: 'ernam', sortable: true},
			{text: "Update Date", width: 50, dataIndex: 'updat', sortable: true},
			{text: "Update Name", width: 40, dataIndex: 'upnam', sortable: true}
		],
		forceFit: true,
		height:210,
		split: true,
		region: 'center',
		tbar : [
			addAct, editAct, deleteAct
		]
	});

	var form = Ext.widget('form', {
		url: '<?= site_url("material/save") ?>',
		layout: {
			type: 'vbox',
			align: 'stretch'
		},
		border: false,
		bodyPadding: '5 5 0',
		fieldDefaults: {
			//labelAlign: 'top',
			msgTarget: 'side',
			labelWidth: 150,
			labelStyle: 'font-weight:bold'
		},
		defaults: {
            anchor: '100%'
        },
// Frame number 1	
		items: [{
            xtype:'fieldset',
            title: 'Material Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
		items: [{
			xtype: 'textfield',
			fieldLabel: 'Material Code',
			name: 'matnr',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: 'Material Name',
			name: 'maktx',
			allowBlank: true
		}, {
                    xtype: 'combobox',
                    fieldLabel: 'Material Type',
                    name: 'mtart',
                    /*store: Ext.create('Ext.data.ArrayStore', {
                        fields: ['abbr', 'state'],
                        data : Ext.example.states // from states.js
                    }),
                    valueField: 'abbr',
                    displayField: 'state',
                    typeAhead: true,
                    queryMode: 'local',*/
                    emptyText: 'Select a mat-type...'
                }, {
			xtype: 'textfield',
			fieldLabel: 'Unit',
			name: 'meins',
			allowBlank: true
		}, {
			xtype: 'textfield',
			//xtype: 'filefield',
            id: 'form-file',
            emptyText: 'Select a GL account',
			fieldLabel: 'GL Account',
			name: 'saknr',
			allowBlank: true,
			buttonText: '',
            buttonConfig: {
                iconCls: 'b-small-pencil'
            }
            }]
		}, {
// Frame number 2	
			xtype:'fieldset',
            title: 'Balance Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
     items :[{
		
		xtype: 'numberfield',
			fieldLabel: 'Beginning Qty',
			name: 'beqty',
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Beginning Value',
			name: 'beval',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Average Cost',
			name: 'cosav',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Ending Qty',
			name: 'enqty',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Ending Value',
			name: 'enval',
			allowBlank: true
		}]
	},{
// Frame number 3	
			xtype:'fieldset',
            title: 'Costing Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
            items: [{
            xtype: 'container',
            anchor: '100%',
            layout: 'hbox',
            items:[{
                xtype: 'container',
                flex: 1,
                layout: 'anchor',
     items :[{
			xtype: 'textfield',
			fieldLabel: 'Unit 1',
			name: 'unit1',
			anchor:'90%',
			allowBlank: true
		},{
			xtype: 'textfield',
			fieldLabel: 'Unit 2',
			name: 'unit1',
			anchor:'90%',
			allowBlank: true
		},{
			xtype: 'textfield',
			fieldLabel: 'Unit 3',
			name: 'unit3',
			anchor:'90%',
			allowBlank: true
		}]
            },{
                xtype: 'container',
                flex: 1,
                layout: 'anchor',
        items: [{
			xtype: 'numberfield',
			fieldLabel: 'Cost 1',
			name: 'cost1',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Cost 2',
			minValue: 0,
			name: 'cost2',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Cost 3',
			minValue: 0,
			name: 'cost3',
			anchor:'100%',
			labelWidth: 90,
			allowBlank: true
		}
		]
		}]
		}]
		}],

		buttons: [{
			text: 'Save',
			handler: function() {
				var form = this.up('form').getForm();
				if (form.isValid()) {
					form.submit({
	                    success: function(form, action) {
	                       Ext.Msg.alert('Success', action.result.message);
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
		title: 'Material Master',
		closeAction: 'hide',
		height: 550,
		minHeight: 400,
		width: 550,
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
			grid,
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
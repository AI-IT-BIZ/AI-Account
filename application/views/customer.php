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
			url: '<?= site_url("customer/loads") ?>',
			reader: {
				type: 'json',
				root: 'rows',
				idProperty: 'kunnr'
			}
		},
		fields: [
			{name:'kunnr'},
			'name1',
	        'adr01',
	        'distr',
	        'pstlz',
	        
	        'telf1',
	        'telfx',
	        'pson1',
	        'taxbs',
	        'saknr',
	        'ptype',
	        
	        'retax',
	        'crdit',
	        'disct',
	        'pappr',
	        'begin',
	        'endin',
	        'sgtxt',
	        'ktype',
	        
			{name:'erdat'},
			'ernam'
			//{name:'updat'},
			//'upnam'
		],
		remoteSort: true,
		sorters: ['kunnr ASC']
	});

	// create the grid
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		columns: [
			{text: "Customer No", width: 70, dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 120, dataIndex: 'name1', sortable: true},
			{text: "Address", width: 50, dataIndex: 'adr01', sortable: true},
			{text: "District", width: 40, dataIndex: 'distr', sortable: true},
			{text: "Post Code", width: 30, dataIndex: 'pstlz', sortable: true},
			{text: "Telephon", width: 30, dataIndex: 'telf1', sortable: true},
			{text: "Fax", width: 30, dataIndex: 'telfx', sortable: true},
			{text: "Contact Person", width: 50, dataIndex: 'pson1', sortable: true},
			{text: "Tax Type", width: 50, dataIndex: 'taxnr', sortable: true},
			
			{text: "Price Type", width: 30, dataIndex: 'ptype', sortable: true},
			{text: "Tax Return", width: 120, dataIndex: 'retax', sortable: true},
			{text: "Credit", width: 50, dataIndex: 'crdit', sortable: true},
			{text: "Discount", width: 40, dataIndex: 'retax', sortable: true},
			{text: "Price Level", width: 20, dataIndex: 'pleve', sortable: true},
			{text: "Approve Amt", width: 30, dataIndex: 'apamt', sortable: true},
			{text: "Qty Beginning", width: 30, dataIndex: 'begin', sortable: true},
			{text: "Qty Ending", width: 50, dataIndex: 'endin', sortable: true},
			{text: "Remark", width: 50, dataIndex: 'sgtxt', sortable: true},
			
			{text: "Create Name", width: 40, dataIndex: 'ernam', sortable: true},
			{text: "Create Date", width: 50, dataIndex: 'updat', sortable: true}
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
		url: '<?= site_url("customer/save") ?>',
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
            title: 'Customer Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
		items: [{
			xtype: 'textfield',
			fieldLabel: 'Customer No',
			name: 'kunnr',
			allowBlank: false
		}, {
			xtype: 'textfield',
			fieldLabel: 'Customer Name',
			name: 'name1',
			allowBlank: true
		}, {
			xtype: 'textfield',
			fieldLabel: 'Address',
			name: 'adr01',
			allowBlank: true
		},{
                    xtype: 'combobox',
                    fieldLabel: 'District',
                    name: 'distr',
                    /*store: Ext.create('Ext.data.ArrayStore', {
                        fields: ['abbr', 'state'],
                        data : Ext.example.states // from states.js
                    }),
                    valueField: 'abbr',
                    displayField: 'state',
                    typeAhead: true,
                    queryMode: 'local',*/
                    emptyText: 'Select a district...'
                }, {
			xtype: 'textfield',
			fieldLabel: 'Post Code',
			name: 'pstlz',
			allowBlank: true
		}, {
			xtype: 'textfield',
			fieldLabel: 'Telephon',
			name: 'telf1',
			allowBlank: true
		}, {
			xtype: 'textfield',
		    fieldLabel: 'Fax',
			name: 'telfx',
			allowBlank: true
		}, {
			xtype: 'textfield',
		    fieldLabel: 'Email',
			name: 'email',
			allowBlank: true
		}, {
			xtype: 'textfield',
		    fieldLabel: 'Tax ID',
			name: 'taxid',
			allowBlank: true
		}, {
			xtype: 'textfield',
		    fieldLabel: 'GL Account',
			name: 'saknr',
			allowBlank: true
		}, {
			xtype: 'textfield',
		    fieldLabel: 'Price Type',
			name: 'taxnr',
			allowBlank: true
		},/*{
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
            }*/]
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
			fieldLabel: 'Credit',
			name: 'crdit',
			allowBlank: true
		},{
			xtype: 'numberfield',
			fieldLabel: 'Discount',
			name: 'disct',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Cost Level',
			name: 'pleve',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Credit Approval',
			name: 'apamt',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Begining Qty',
			name: 'begin',
			allowBlank: true
		}, {
			xtype: 'numberfield',
			fieldLabel: 'Ending Qty',
			name: 'endin',
			allowBlank: true
		}]
	},{
// Frame number 3	
			/*xtype:'fieldset',
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
		}]*/
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
		title: 'Customer Master',
		closeAction: 'hide',
		height: 550,
		minHeight: 400,
		width: 550,
		minWidth: 300,
		layout: 'fit',
		resizable: true,
		modal: true,
		items: form,
		defaultFocus: 'kunnr'
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
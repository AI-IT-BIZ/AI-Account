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

	Ext.state.Manager.setProvider(Ext.create('Ext.state.CookieProvider'));

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

	Ext.define('Book',{
		extend: 'Ext.data.Model',
		proxy: {
			type: 'ajax',
			reader: 'xml'
		},
		fields: [
			// set up the fields mapping into the xml doc
			// The first needs mapping, the others are very basic
			{name: 'Author', mapping: '@author.name'},
			'Title',
			'Manufacturer',
			'ProductGroup',
			'DetailPageURL'
		]
	});

	// create the Data Store
	var store = Ext.create('Ext.data.Store', {
		model: 'Book',
		proxy: {
			// load using HTTP
			type: 'ajax',
			url: '<?= base_url("assets/sample/sheldon.xml") ?>',
			// the return will be XML, so lets set up a reader
			reader: {
				type: 'xml',
				record: 'Item',
				totalProperty  : 'total'
			}
		}
	});

	// create the grid
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		columns: [
			{text: "Author", width: 120, dataIndex: 'Author', sortable: true},
			{text: "Title", flex: 1, dataIndex: 'Title', sortable: true},
			{text: "Manufacturer", width: 125, dataIndex: 'Manufacturer', sortable: true},
			{text: "Product Group", width: 125, dataIndex: 'ProductGroup', sortable: true}
		],
		forceFit: true,
		height:210,
		split: true,
		region: 'center',
		tbar : [
			addAct, editAct, deleteAct
		]
	});

	// define a template to use for the detail view
	var bookTplMarkup = [
		'Title: <a href="{DetailPageURL}" target="_blank">{Title}</a><br/>',
		'Author: {Author}<br/>',
		'Manufacturer: {Manufacturer}<br/>',
		'Product Group: {ProductGroup}<br/>'
	];
	var bookTpl = Ext.create('Ext.Template', bookTplMarkup);

	var required = '<span style="color:red;font-weight:bold" data-qtip="Required">*</span>'
	var form = Ext.widget('form', {
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
	        xtype: 'fieldcontainer',
	        fieldLabel: 'Your Name',
	        labelStyle: 'font-weight:bold;padding:0;',
	        layout: 'hbox',
	        defaultType: 'textfield',

	        fieldDefaults: {
	            labelAlign: 'top'
	        },

	        items: [{
	            flex: 1,
	            name: 'firstName',
	            itemId: 'firstName',
	            afterLabelTextTpl: required,
	            fieldLabel: 'First',
	            allowBlank: false
	        }, {
	            width: 30,
	            name: 'middleInitial',
	            fieldLabel: 'MI',
	            margins: '0 0 0 5'
	        }, {
	            flex: 2,
	            name: 'lastName',
	            afterLabelTextTpl: required,
	            fieldLabel: 'Last',
	            allowBlank: false,
	            margins: '0 0 0 5'
	        }]
	    }, {
	        xtype: 'textfield',
	        fieldLabel: 'Your Email Address',
	        afterLabelTextTpl: required,
	        vtype: 'email',
	        allowBlank: false
	    }, {
	        xtype: 'textfield',
	        fieldLabel: 'Subject',
	        afterLabelTextTpl: required,
	        allowBlank: false
	    }, {
	        xtype: 'textareafield',
	        fieldLabel: 'Message',
	        labelAlign: 'top',
	        flex: 1,
	        margins: '0',
	        afterLabelTextTpl: required,
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
	        	this.up('form').getForm().checkValidity();
	            if (this.up('form').getForm().isValid()) {
	                // In a real application, this would submit the form to the configured url
	                // this.up('form').getForm().submit();
	                this.up('form').getForm().reset();
	                this.up('window').hide();
	                Ext.MessageBox.alert('Thank you!', 'Your inquiry has been sent. We will respond as soon as possible.');
	            }
	        }
	    }]
	});

	var dialog = Ext.widget('window', {
	    title: 'Contact Us',
	    closeAction: 'hide',
	    width: 400,
	    height: 400,
	    minWidth: 300,
	    minHeight: 300,
	    layout: 'fit',
	    resizable: true,
	    modal: true,
	    items: form,
	    defaultFocus: 'firstName'
	});



	////////////////////////////////////////////
	// Event
	store.load();

	addAct.setHandler(function(){
		dialog.show();
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
		items: [{
			region: 'north',
			collapsible: true,
			title: 'North',
			split: true,
			height: 100,
			minHeight: 60,
			html: 'north'
		},{
			region: 'west',
			collapsible: true,
			title: 'West',
			split: true,
			width: 250,
			minHeight: 60,
			html: 'West content'
		},
		grid
		]
	});


});

	</script>


</body>
</html>
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

	var saveAct = new Ext.Action({
		text: 'Save',
		iconCls: 'b-small-save'
	});
	var editAct = new Ext.Action({
		text: 'Edit',
		iconCls: 'b-small-pencil'
	});
	var exitAct = new Ext.Action({
		text: 'Exit',
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
	        'beqty',
	        'beval'
	        
		],
		remoteSort: true,
		sorters: ['matnr ASC']
	});
	
//Edit Obj
var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
        clicksToEdit: 1
    });

	// create the grid
	var grid = Ext.create('Ext.grid.Panel', {
		store: store,
		plugins: [cellEditing],
		columns: [
			{text: "Material Code", 
			 width: 70, 
			 dataIndex: 'matnr', 
			 sortable: true,
			 field: {
                xtype: 'triggerfield'
            }
			 },
			{text: "Material Name", width: 120, dataIndex: 'maktx', sortable: true},
			{text: "Quantity", 
			 width: 70, 
			 dataIndex: 'beqty', 
			 sortable: true,
			 field: {
                xtype: 'numberfield'
            }
			 
			 },
			{text: "Cost", width: 70, dataIndex: 'beval', sortable: true}
		],
		forceFit: true,
		height:210,
		split: true,
		region: 'center',
		tbar : [
			saveAct, editAct, exitAct
		]
	});

	
	store.load();

	saveAct.setHandler(function(){
		//dialog.show();
	});
	
	editAct.setHandler(function(){
		//dialog.show();
	});
	
	exitAct.setHandler(function(){
		//var selection = grid.getView().getSelectionModel().getSelection()[0];
        //            if (selection) {
        //                store.remove(selection);
        //            }
	});
	
	/*form.addEvents('afterCancel');
	form.on('afterCancel', function(){
		//form_basic.reset();
		store.load();
		//dialog.hide();
	});*/


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
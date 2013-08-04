<script type="text/javascript">
Ext.Loader.setPath('Account', __base_url+'assets/js');

Ext.onReady(function() {

	$om.prDialog = Ext.create('Account.PR.MainWindow');

	$om.warehouseDialog = Ext.create('Account.Warehouse.MainWindow');

	$om.viewport.on('click_income', function(){
		$om.prDialog.show();
	});
	$om.viewport.on('click_journal', function(){
		$om.warehouseDialog.show();
	});

});
</script>
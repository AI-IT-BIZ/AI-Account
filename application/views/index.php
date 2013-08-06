<script type="text/javascript">
Ext.Loader.setPath('Account', __base_url+'assets/js');

Ext.onReady(function() {

	$om.viewport.on('click_income', function(){
		if(!$om.prDialog)
			$om.prDialog = Ext.create('Account.PR.MainWindow');
		$om.prDialog.show();
	});
	$om.viewport.on('click_journal', function(){
		if(!$om.warehouseDialog)
			$om.warehouseDialog = Ext.create('Account.Warehouse.MainWindow');
		$om.warehouseDialog.show();
	});
	
	$om.viewport.on('click_balance', function(){
		if(!$om.warehouseDialog)
			$om.warehouseDialog = Ext.create('Account.Warehouse.MainWindow');
		$om.warehouseDialog.show();
	});
	

});
</script>
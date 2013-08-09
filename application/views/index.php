<script type="text/javascript">
Ext.Loader.setPath('Account', __base_url+'assets/js');

Ext.onReady(function() {
    $om.quotationDialog = Ext.create('Account.Quotation.MainWindow');
    $om.quotationDialog.show();
    
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
	//Sale Module
	$om.viewport.on('click_project', function(){
		if(!$om.projectDialog)
			$om.projectDialog = Ext.create('Account.Project.MainWindow');
		$om.projectDialog.show();
	});
	$om.viewport.on('click_quotation', function(){
		if(!$om.quotationDialog)
			$om.quotationDialog = Ext.create('Account.Quotation.MainWindow');
		$om.quotationDialog.show();
	});
	$om.viewport.on('click_invoice', function(){
		if(!$om.invoiceDialog)
			$om.invoiceDialog = Ext.create('Account.Invoice.MainWindow');
		$om.invoiceDialog.show();
	});

});
</script>
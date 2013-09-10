<script type="text/javascript">
Ext.Loader.setPath('Account', __base_url+'assets/js');

Ext.onReady(function() {
       // $om.invoiceDialog = Ext.create('Account.Invoice.MainWindow');
		//$om.invoiceDialog.show();
    
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
//<<<<<<< HEAD
	
	$om.viewport.on('click_balance', function(){
		if(!$om.warehouseDialog)
			$om.warehouseDialog = Ext.create('Account.Warehouse.MainWindow');
		$om.warehouseDialog.show();
	});
	
	$om.viewport.on('click_customer', function(){
		if(!$om.customerDialog)
			$om.customerDialog = Ext.create('Account.Customer.MainWindow');
		$om.customerDialog.show();
	});
	
//=======
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
	$om.viewport.on('click_rproject', function(){
		if(!$om.rprojectDialog)
			$om.rprojectDialog = Ext.create('Account.RProject.MainWindow');
		$om.rprojectDialog.show();
	});
	$om.viewport.on('click_rquotation', function(){
		if(!$om.rquotationDialog)
			$om.rquotationDialog = Ext.create('Account.RQuotation.MainWindow');
		$om.rquotationDialog.show();
	});
	$om.viewport.on('click_rinvoice', function(){
		if(!$om.rinvoiceDialog)
			$om.rinvoiceDialog = Ext.create('Account.RInvoice.MainWindow');
		$om.rinvoiceDialog.show();
	});
	
	$om.viewport.on('click_rinv_payment', function(){
		if(!$om.rinv_paymentDialog)
			$om.rinv_paymentDialog = Ext.create('Account.RInv_payment.MainWindow');
		$om.rinv_paymentDialog.show();
	});
//Purchase Module
	$om.viewport.on('click_vendor', function(){
		if(!$om.vendorDialog)
			$om.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		$om.vendorDialog.show();
	});
	
	$om.viewport.on('click_salep', function(){
		if(!$om.salepersonDialog)
			$om.salepersonDialog = Ext.create('Account.Saleperson.MainWindow');
		$om.salepersonDialog.show();
	});
	
	$om.viewport.on('click_pr', function(){
		if(!$om.pr2Dialog)
			$om.pr2Dialog = Ext.create('Account.PR2.MainWindow');
		$om.pr2Dialog.show();
	});
	
	$om.viewport.on('click_po', function(){
		if(!$om.poDialog)
			$om.poDialog = Ext.create('Account.PO.MainWindow');
		$om.poDialog.show();
	});
	
	$om.viewport.on('click_gr', function(){
		if(!$om.grDialog)
			$om.grDialog = Ext.create('Account.Goodsreceipt.MainWindow');
		$om.grDialog.show();
	});
	
	$om.viewport.on('click_rpo', function(){
		if(!$om.rpoDialog)
			$om.rpoDialog = Ext.create('Account.RPO.MainWindow');
		$om.rpoDialog.show();
	});
	
	$om.viewport.on('click_rpr', function(){
		if(!$om.rprDialog)
			$om.rprDialog = Ext.create('Account.RPR.MainWindow');
		$om.rprDialog.show();
	});
//Material Module
	$om.viewport.on('click_material', function(){
		if(!$om.materialDialog)
			$om.materialDialog = Ext.create('Account.Material.MainWindow');
		$om.materialDialog.show();
	});
	
	$om.viewport.on('click_return', function(){
		if(!$om.returnDialog)
			$om.returnDialog = Ext.create('Account.Return.MainWindow');
		$om.returnDialog.show();
	});
	
	$om.viewport.on('click_picking', function(){
		if(!$om.pickingDialog)
			$om.pickingDialog = Ext.create('Account.Picking.MainWindow');
		$om.pickingDialog.show();
	});
	

});
</script>
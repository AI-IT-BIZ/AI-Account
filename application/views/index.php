<script type="text/javascript">
Ext.Loader.setPath('Account', __base_url+'assets/js');

Ext.onReady(function() {
       // $om.invoiceDialog = Ext.create('Account.Invoice.MainWindow');
		//$om.invoiceDialog.show();
    
    $om.viewport.on('click_config', function(){
		if(!$om.initdocDialog)
			$om.initdocDialog = Ext.create('Account.Initdoc.MainWindow');
		$om.initdocDialog.show();
	});
    
	$om.viewport.on('click_income', function(){
		if(!$om.prDialog)
			$om.prDialog = Ext.create('Account.PR.MainWindow');
		$om.prDialog.show();
	});
	
	$om.viewport.on('click_journaltemp', function(){
		if(!$om.journaltempDialog)
			$om.journaltempDialog = Ext.create('Account.Journaltemp.MainWindow');
		$om.journaltempDialog.show();
	});
	
	$om.viewport.on('click_journal', function(){
		if(!$om.journalDialog)
			$om.journalDialog = Ext.create('Account.Journal.MainWindow');
		$om.journalDialog.show();
	});
	
	$om.viewport.on('click_rjournal', function(){
		if(!$om.rjournalDialog)
			$om.rjournalDialog = Ext.create('Account.RJournal.MainWindow');
		$om.rjournalDialog.show();
	});
	
	$om.viewport.on('click_rgl', function(){
		if(!$om.rglDialog)
			$om.rglDialog = Ext.create('Account.RGL.MainWindow');
		$om.rglDialog.show();
	});

//<<<<<<< HEAD
	
	$om.viewport.on('click_customer', function(){
		if(!$om.customerDialog)
			$om.customerDialog = Ext.create('Account.Customer.MainWindow');
		$om.customerDialog.show();
	});
	
	$om.viewport.on('click_vendor', function(){
		if(!$om.vendorDialog)
			$om.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		$om.vendorDialog.show();
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
	$om.viewport.on('click_deposit1', function(){
		if(!$om.deposit1Dialog)
			$om.deposit1Dialog = Ext.create('Account.DepositIn.MainWindow');
		$om.deposit1Dialog.show();
	});
	$om.viewport.on('click_saleorder', function(){
		if(!$om.saleorderDialog)
			$om.saleorderDialog = Ext.create('Account.Saleorder.MainWindow');
		$om.saleorderDialog.show();
	});
	$om.viewport.on('click_invoice', function(){
		if(!$om.invoiceDialog)
			$om.invoiceDialog = Ext.create('Account.Invoice.MainWindow');
		$om.invoiceDialog.show();
	});
	$om.viewport.on('click_billto', function(){
		if(!$om.billtoDialog)
			$om.billtoDialog = Ext.create('Account.Billto.MainWindow');
		$om.billtoDialog.show();
	});
	$om.viewport.on('click_receipt', function(){
		if(!$om.receiptDialog)
			$om.receiptDialog = Ext.create('Account.Receipt.MainWindow');
		$om.receiptDialog.show();
	});
	/*$om.viewport.on('click_rproject', function(){
		if(!$om.rprojectDialog)
			$om.rprojectDialog = Ext.create('Account.RProject.MainWindow');
		$om.rprojectDialog.show();
	});
	$om.viewport.on('click_rquotation', function(){
		if(!$om.rquotationDialog)
			$om.rquotationDialog = Ext.create('Account.RQuotation.MainWindow');
		$om.rquotationDialog.show();
	});*/
	$om.viewport.on('click_rinvoice', function(){
		if(!$om.rinvoiceDialog)
			$om.rinvoiceDialog = Ext.create('Account.RInvoice.MainWindow');
		$om.rinvoiceDialog.show();
	});
	$om.viewport.on('click_rreceipt', function(){
		if(!$om.rreceiptDialog)
			$om.rreceiptDialog = Ext.create('Account.RReceipt.MainWindow');
		$om.rreceiptDialog.show();
	});
//Purchase Module
	$om.viewport.on('click_pr', function(){
		if(!$om.prDialog)
			$om.prDialog = Ext.create('Account.PR.MainWindow');
		$om.prDialog.show();
	});
	$om.viewport.on('click_po', function(){
		if(!$om.poDialog)
			$om.poDialog = Ext.create('Account.PO.MainWindow');
		$om.poDialog.show();
	});
	$om.viewport.on('click_deposit2', function(){
		if(!$om.deposit2Dialog)
			$om.deposit2Dialog = Ext.create('Account.DepositOut.MainWindow');
		$om.deposit2Dialog.show();
	});
	$om.viewport.on('click_gr', function(){
		if(!$om.grDialog)
			$om.grDialog = Ext.create('Account.GR.MainWindow');
		$om.grDialog.show();
	});
	$om.viewport.on('click_ap', function(){
		if(!$om.apDialog)
			$om.apDialog = Ext.create('Account.AP.MainWindow');
		$om.apDialog.show();
	});
	$om.viewport.on('click_billfrom', function(){
		if(!$om.billfromDialog)
			$om.billfromDialog = Ext.create('Account.Billfrom.MainWindow');
		$om.billfromDialog.show();
	});
	$om.viewport.on('click_payment', function(){
		if(!$om.paymentDialog)
			$om.paymentDialog = Ext.create('Account.Payment.MainWindow');
		$om.paymentDialog.show();
	});
	$om.viewport.on('click_employee', function(){
		if(!$om.employeeDialog)
			$om.employeeDialog = Ext.create('Account.Employee.MainWindow');
		$om.employeeDialog.show();
	});
	/*$om.viewport.on('click_rpo', function(){
		if(!$om.rpoDialog)
			$om.rpoDialog = Ext.create('Account.RPO.MainWindow');
		$om.rpoDialog.show();
	});
	$om.viewport.on('click_rpr', function(){
		if(!$om.rprDialog)
			$om.rprDialog = Ext.create('Account.RPR.MainWindow');
		$om.rprDialog.show();
	});*/
	$om.viewport.on('click_rgr', function(){
		if(!$om.rgrDialog)
			$om.rgrDialog = Ext.create('Account.RGR.MainWindow');
		$om.rgrDialog.show();
	});
	$om.viewport.on('click_rap', function(){
		if(!$om.rapDialog)
			$om.rapDialog = Ext.create('Account.RAP.MainWindow');
		$om.rapDialog.show();
	});
	$om.viewport.on('click_rpayment', function(){
		if(!$om.rpaymentDialog)
			$om.rpaymentDialog = Ext.create('Account.RPayment.MainWindow');
		$om.rpaymentDialog.show();
	});
	
//Material Module
	$om.viewport.on('click_material', function(){
		if(!$om.materialDialog)
			$om.materialDialog = Ext.create('Account.Material.MainWindow');
		$om.materialDialog.show();
	});
	
	$om.viewport.on('click_transaction', function(){
		if(!$om.transactionDialog)
			$om.transactionDialog = Ext.create('Account.Transaction.MainWindow');
		$om.transactionDialog.show();
	});
	
	$om.viewport.on('click_balance', function(){
		if(!$om.balanceDialog)
			$om.balanceDialog = Ext.create('Account.Balance.MainWindow');
		$om.balanceDialog.show();
	});
	
	$om.viewport.on('click_otincome', function(){
		if(!$om.otincomeDialog)
			$om.otincomeDialog = Ext.create('Account.Otincome.MainWindow');
		$om.otincomeDialog.show();
	});
	
	$om.viewport.on('click_otexpense', function(){
		if(!$om.otexpenseDialog)
			$om.otexpenseDialog = Ext.create('Account.Otexpense.MainWindow');
		$om.otexpenseDialog.show();
	});
	
	$om.viewport.on('click_rtransaction', function(){
		if(!$om.rtransactionDialog)
			$om.rtransactionDialog = Ext.create('Account.RTransaction.MainWindow');
		$om.rtransactionDialog.show();
	});
	
	$om.viewport.on('click_rbalance', function(){
		if(!$om.rbalanceDialog)
			$om.rbalanceDialog = Ext.create('Account.RBalance.MainWindow');
		$om.rbalanceDialog.show();
	});
	

});
</script>
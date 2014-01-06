<script type="text/javascript">
var arrPermit;
Ext.Loader.setConfig({
	enabled: true,
	paths: {
		'BASE': __base_url+'assets/ext_base',
		'Account': __base_url+'assets/js'
	}
});

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
		if(!UMS.CAN.DISPLAY('JT')){
			UMS.ALERT("You don't have permission for Journal Template.");
			return;
		}

		if(!$om.journaltempDialog)
			$om.journaltempDialog = Ext.create('Account.Journaltemp.MainWindow');
		$om.journaltempDialog.show();
	});

	$om.viewport.on('click_journal', function(){
		if(!UMS.CAN.DISPLAY('JN')){
			UMS.ALERT("You don't have permission for Journal.");
			return;
		}

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


   $om.viewport.on('click_chart_account', function(){
   		if(!UMS.CAN.DISPLAY('CA')){
			UMS.ALERT("You don't have permission for Chart of Account.");
			return;
		}

		if(!$om.chartOfAccountDialog)
			$om.chartOfAccountDialog = Ext.create('Account.ChartOfAccounts.MainWindow');
		$om.chartOfAccountDialog.show();
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
		if(!UMS.CAN.DISPLAY('PJ')){
			UMS.ALERT("You don't have permission for Project.");
			return;
		}

		if(!$om.projectDialog)
			$om.projectDialog = Ext.create('Account.Project.MainWindow');
		$om.projectDialog.show();
	});
	$om.viewport.on('click_quotation', function(){
		if(!UMS.CAN.DISPLAY('QT')){
			UMS.ALERT("You don't have permission for Quotation.");
			return;
		}

		if(!$om.quotationDialog)
			$om.quotationDialog = Ext.create('Account.Quotation.MainWindow');
		$om.quotationDialog.show();
	});
	$om.viewport.on('click_deposit1', function(){
		if(!UMS.CAN.DISPLAY('DR')){
			UMS.ALERT("You don't have permission for Deposit Reciept.");
			return;
		}

		if(!$om.deposit1Dialog)
			$om.deposit1Dialog = Ext.create('Account.DepositIn.MainWindow');
		$om.deposit1Dialog.show();
	});
	$om.viewport.on('click_saleorder', function(){
		if(!UMS.CAN.DISPLAY('SO')){
			UMS.ALERT("You don't have permission for Sale Order.");
			return;
		}

		if(!$om.saleorderDialog)
			$om.saleorderDialog = Ext.create('Account.Saleorder.MainWindow');
		$om.saleorderDialog.show();
	});
	$om.viewport.on('click_invoice', function(){
		if(!UMS.CAN.DISPLAY('IV')){
			UMS.ALERT("You don't have permission for Invoice.");
			return;
		}

		if(!$om.invoiceDialog)
			$om.invoiceDialog = Ext.create('Account.Invoice.MainWindow');
		$om.invoiceDialog.show();
	});
	$om.viewport.on('click_sale_dn', function(){
		if(!UMS.CAN.DISPLAY('SN')){
			UMS.ALERT("You don't have permission for Sale Debit/Credit Note.");
			return;
		}

		if(!$om.saleDebitNoteDialog)
			$om.saleDebitNoteDialog = Ext.create('Account.SaleDebitNote.MainWindow');
		$om.saleDebitNoteDialog.show();
	});
	$om.viewport.on('click_sale_cn', function(){
		if(!UMS.CAN.DISPLAY('SN')){
			UMS.ALERT("You don't have permission for Sale Debit/Credit Note.");
			return;
		}

		if(!$om.saleCreditNoteDialog)
			$om.saleCreditNoteDialog = Ext.create('Account.SaleCredit.MainWindow');
		$om.saleCreditNoteDialog.show();
	});
	$om.viewport.on('click_billto', function(){
		if(!UMS.CAN.DISPLAY('BT')){
			UMS.ALERT("You don't have permission for Billing Note.");
			return;
		}

		if(!$om.billtoDialog)
			$om.billtoDialog = Ext.create('Account.Billto.MainWindow');
		$om.billtoDialog.show();
	});
	$om.viewport.on('click_receipt', function(){
		if(!UMS.CAN.DISPLAY('RD')){
			UMS.ALERT("You don't have permission for Receipt.");
			return;
		}

		if(!$om.receiptDialog)
			$om.receiptDialog = Ext.create('Account.Receipt.MainWindow');
		$om.receiptDialog.show();
	});
	$om.viewport.on('click_saleperson', function(){
		if(!UMS.CAN.DISPLAY('SP')){
			UMS.ALERT("You don't have permission for Sale Person.");
			return;
		}

		if(!$om.salepersonDialog)
			$om.salepersonDialog = Ext.create('Account.Saleperson.MainWindow');
		$om.salepersonDialog.show();
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
		if(!UMS.CAN.DISPLAY('PR')){
			UMS.ALERT("You don't have permission for Purchase Requisition.");
			return;
		}

		if(!$om.prDialog)
			$om.prDialog = Ext.create('Account.PR.MainWindow');
		$om.prDialog.show();
	});
	$om.viewport.on('click_po', function(){
		if(!UMS.CAN.DISPLAY('PO')){
			UMS.ALERT("You don't have permission for Purchase Order.");
			return;
		}

		if(!$om.poDialog)
			$om.poDialog = Ext.create('Account.PO.MainWindow');
		$om.poDialog.show();
	});
	$om.viewport.on('click_deposit2', function(){
		if(!UMS.CAN.DISPLAY('DP')){
			UMS.ALERT("You don't have permission for Deposit Payment.");
			return;
		}

		if(!$om.deposit2Dialog)
			$om.deposit2Dialog = Ext.create('Account.DepositOut.MainWindow');
		$om.deposit2Dialog.show();
	});
	$om.viewport.on('click_gr', function(){
		if(!UMS.CAN.DISPLAY('GR')){
			UMS.ALERT("You don't have permission for Good Reciept.");
			return;
		}

		if(!$om.grDialog)
			$om.grDialog = Ext.create('Account.GR.MainWindow');
		$om.grDialog.show();
	});
	$om.viewport.on('click_ap', function(){
		if(!UMS.CAN.DISPLAY('AP')){
			UMS.ALERT("You don't have permission for Account Payable.");
			return;
		}

		if(!$om.apDialog)
			$om.apDialog = Ext.create('Account.AP.MainWindow');
		$om.apDialog.show();
	});
	$om.viewport.on('click_purchase_dn', function(){
		if(!UMS.CAN.DISPLAY('PN')){
			UMS.ALERT("You don't have permission for Purchase Debit/Credit Note.");
			return;
		}

		if(!$om.purchaseDebitNoteDialog)
			$om.purchaseDebitNoteDialog = Ext.create('Account.PurchaseDebitNote.MainWindow');
		$om.purchaseDebitNoteDialog.show();
	});
	$om.viewport.on('click_purchase_cn', function(){
		if(!UMS.CAN.DISPLAY('PN')){
			UMS.ALERT("You don't have permission for urchase Debit/Credit Note.");
			return;
		}

		if(!$om.purchaseCreditNoteDialog)
			$om.purchaseCreditNoteDialog = Ext.create('Account.PurchaseCreditNote.MainWindow');
		$om.purchaseCreditNoteDialog.show();
	});
	$om.viewport.on('click_billfrom', function(){
		if(!UMS.CAN.DISPLAY('BF')){
			UMS.ALERT("You don't have permission for Billing Receipt.");
			return;
		}

		if(!$om.billfromDialog)
			$om.billfromDialog = Ext.create('Account.Billfrom.MainWindow');
		$om.billfromDialog.show();
	});
	$om.viewport.on('click_payment', function(){
		if(!UMS.CAN.DISPLAY('PY')){
			UMS.ALERT("You don't have permission for Payment.");
			return;
		}

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
		if(!UMS.CAN.DISPLAY('MM')){
			UMS.ALERT("You don't have permission for Material Master.");
			return;
		}

		if(!$om.materialDialog)
			$om.materialDialog = Ext.create('Account.Material.MainWindow');
		$om.materialDialog.show();
	});

	$om.viewport.on('click_service', function(){
		if(!UMS.CAN.DISPLAY('SV')){
			UMS.ALERT("You don't have permission for Service Master.");
			return;
		}

		if(!$om.serviceDialog)
			$om.serviceDialog = Ext.create('Account.Service.MainWindow');
		$om.serviceDialog.show();
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
			$om.rtransactionDialog = Ext.create('Account.RPurchaseVat.MainWindow');
		$om.rtransactionDialog.show();
	});

	$om.viewport.on('click_rbalance', function(){
		if(!$om.rbalanceDialog)
			$om.rbalanceDialog = Ext.create('Account.RPP30Vat.MainWindow');
		$om.rbalanceDialog.show();
	});


	// SETTINGS
	$om.viewport.on('click_company_setting', function(){
		if(!UMS.CAN.DISPLAY('CC')){
	 		UMS.ALERT("You don't have permission for Company Define.");
	  		return;
		}
		$om.companyDialog = Ext.create('Account.Company.MainWindow');
		$om.companyDialog.show();
	});

	$om.viewport.on('click_authorize_setting', function(){
	  	if(!UMS.CAN.DISPLAY('AU')){
	 		UMS.ALERT("You don't have permission for Authorize Setting.");
	  		return;
		}
		$om.configDialog = Ext.create('Account.UMS.MainWindow');
		$om.configDialog.show();
	});

	$om.viewport.on('click_limitation_setting', function(){
	  	if(!UMS.CAN.DISPLAY('AU')){
	 		UMS.ALERT("You don't have permission for Limitation Setting'.");
	  		return;
		}
		var uComid = __user_state.UserState.comid;
		$om.mainWindow = Ext.create('Account.UMSLimit.MainWindow', {
			treeExtraParams: {
				comid: uComid
			}
		});
		$om.mainWindow.openDialog({
			comid: uComid
		});
		//$om.limitDialog = Ext.create('Account.UMSLimit.SelectCompanyWindow');
		//$om.limitDialog.show();
	});

	//Report
	$om.viewport.on('click_report_gl', function(){
		$om.RGeneralJournal = Ext.create('Account.RGeneralLedger.MainWindow');
		$om.RGeneralJournal.show();
	});

	$om.viewport.on('click_report_gr', function(){
		$om.RGeneralJournal = Ext.create('Account.RGeneralJournal.MainWindow');
		$om.RGeneralJournal.show();
	});

	$om.viewport.on('click_report_tb', function(){
		$om.RTrialBalance = Ext.create('Account.RTrialBalance.MainWindow');
		$om.RTrialBalance.show();
	});

	$om.viewport.on('click_report_income', function(){
		$om.RIncome = Ext.create('Account.RIncome.MainWindow');
		$om.RIncome.show();
	});


	$om.viewport.on('click_report_balance_sheet', function(){
		$om.RBalanceSheet = Ext.create('Account.RBalanceSheet.MainWindow');
		$om.RBalanceSheet.show();
	});

	$om.viewport.on('click_RSumVat', function(){
		$om.RSumVat = Ext.create('Account.RSumVat.MainWindow');
		$om.RSumVat.show();
	});

	$om.viewport.on('click_Rpp30Vat', function(){
		$om.Rpp30Vat = Ext.create('Account.Rpp30Vat.MainWindow');
		$om.Rpp30Vat.show();
	});

	$om.viewport.on('click_Rpnd1WHT', function(){
		$om.Rpnd1WHT = Ext.create('Account.Rpnd1WHT.MainWindow');
		$om.Rpnd1WHT.show();
	});

	$om.viewport.on('click_Rpnd3WHT', function(){
		$om.Rpnd3WHT = Ext.create('Account.Rpnd3WHT.MainWindow');
		$om.Rpnd3WHT.show();
	});

	$om.viewport.on('click_Rpnd50WHT', function(){
		$om.Rpnd50WHT = Ext.create('Account.Rpnd50WHT.MainWindow');
		$om.Rpnd50WHT.show();
	});

	$om.viewport.on('click_Rpnd53WHT', function(){
		$om.Rpnd53WHT = Ext.create('Account.Rpnd53WHT.MainWindow');
		$om.Rpnd53WHT.show();
	});
});
</script>

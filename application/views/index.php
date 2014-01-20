<script type="text/javascript">
var arrPermit;

Ext.onReady(function() {
       // $om.invoiceDialog = Ext.create('Account.Invoice.MainWindow');
		//$om.invoiceDialog.show();

//<<<<<<< HEAD

	$om.viewport.on('click_customer', function(){
		if(!UMS.CAN.DISPLAY('CS')){
			UMS.ALERT("You don't have permission for Customer Master.");
			return;
		}
		if(!$om.customerDialog)
			$om.customerDialog = Ext.create('Account.Customer.MainWindow');
		$om.customerDialog.show();
	});

	$om.viewport.on('click_vendor', function(){
		if(!UMS.CAN.DISPLAY('VD')){
			UMS.ALERT("You don't have permission for Vendor Master.");
			return;
		}
		if(!$om.vendorDialog)
			$om.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		$om.vendorDialog.show();
	});

//=======
	//Sale Module
	$om.viewport.on('click_projectnew', function(){
		if(!UMS.CAN.DISPLAY('PJ')){
			UMS.ALERT("You don't have permission for Project.");
			return;
		}

		if(!$om.projectnewDialog)
			$om.projectnewDialog = Ext.create('Account.Project.Item.Window');
		$om.projectnewDialog.form.reset();
		$om.projectnewDialog.show();
	});
	$om.viewport.on('click_project', function(){
		if(!UMS.CAN.DISPLAY('PJ')){
			UMS.ALERT("You don't have permission for Project.");
			return;
		}

		if(!$om.projectDialog)
			$om.projectDialog = Ext.create('Account.Project.MainWindow');
		$om.projectDialog.show();
	});
	$om.viewport.on('click_quotationnew', function(){
		if(!UMS.CAN.DISPLAY('QT')){
			UMS.ALERT("You don't have permission for Quotation.");
			return;
		}

		//if(!$om.quotationnewDialog)
		//	$om.quotationnewDialog = Ext.create('Account.Quotation.Item.Window');
		//$om.quotationnewDialog.show();
		if(!$om.quotationDialog)
			$om.quotationDialog = Ext.create('Account.Quotation.MainWindow');

		$om.quotationDialog.addAct.execute();
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
			$om.saleCreditNoteDialog = Ext.create('Account.SaleCreditNote.MainWindow');
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
//Account Module
    $om.viewport.on('click_chart_account', function(){
   		if(!UMS.CAN.DISPLAY('CA')){
			UMS.ALERT("You don't have permission for Chart of Account.");
			return;
		}

		if(!$om.chartOfAccountDialog)
			$om.chartOfAccountDialog = Ext.create('Account.ChartOfAccounts.MainWindow');
		$om.chartOfAccountDialog.show();
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

    $om.viewport.on('click_income', function(){
		if(!$om.incomeDialog)
			$om.incomeDialog = Ext.create('Account.OtherIncome.MainWindow');
		$om.incomeDialog.show();
	});

	$om.viewport.on('click_expense', function(){
		if(!$om.expenseDialog)
			$om.expenseDialog = Ext.create('Account.OtherExpense.MainWindow');
		$om.expenseDialog.show();
	});

	$om.viewport.on('click_asset-regist', function(){
		if(!UMS.CAN.DISPLAY('FA')){
			UMS.ALERT("You don't have permission for Asset Register.");
			return;
		}

		if(!$om.assetregitDialog)
			$om.assetregitDialog = Ext.create('Account.RAssetRegister.MainWindow');
		$om.assetregitDialog.show();
	});

	$om.viewport.on('click_rjournal', function(){
		if(!$om.rjournalDialog)
			$om.rjournalDialog = Ext.create('Account.RJournal.MainWindow');
		$om.rjournalDialog.show();
	});

//Master Module
	$om.viewport.on('click_customer_type', function(){
		if(!UMS.CAN.DISPLAY('CT')){
	 		UMS.ALERT("You don't have permission for Customer Type.");
	  		return;
		}
		$om.customertypeDialog = Ext.create('Account.Customertype.Window');
		$om.customertypeDialog.show();
	});

	$om.viewport.on('click_vendor_type', function(){
		if(!UMS.CAN.DISPLAY('VT')){
	 		UMS.ALERT("You don't have permission for Vendor Type.");
	  		return;
		}
		$om.vendortypeDialog = Ext.create('Account.Vendortype.Window');
		$om.vendortypeDialog.show();
	});

	$om.viewport.on('click_material_type', function(){
		if(!UMS.CAN.DISPLAY('MT')){
	 		UMS.ALERT("You don't have permission for Material Type.");
	  		return;
		}
		$om.materialtypeDialog = Ext.create('Account.Materialtype.Window');
		$om.materialtypeDialog.show();
	});

	$om.viewport.on('click_material_group', function(){
		if(!UMS.CAN.DISPLAY('MG')){
	 		UMS.ALERT("You don't have permission for Material Group.");
	  		return;
		}
		$om.materialgrpDialog = Ext.create('Account.Materialgrp.Window');
		$om.materialgrpDialog.show();
	});

	$om.viewport.on('click_asset_type', function(){
		if(!UMS.CAN.DISPLAY('AT')){
	 		UMS.ALERT("You don't have permission for Asset Type.");
	  		return;
		}
		$om.assettypeDialog = Ext.create('Account.Assettype.Window');
		$om.assettypeDialog.show();
	});

	$om.viewport.on('click_asset_group', function(){
		if(!UMS.CAN.DISPLAY('AH')){
	 		UMS.ALERT("You don't have permission for Asset Group.");
	  		return;
		}
		$om.assetgrpDialog = Ext.create('Account.Assetgrp.Window');
		$om.assetgrpDialog.show();
	});

	$om.viewport.on('click_bankname_setting', function(){

	  	if(!UMS.CAN.DISPLAY('BN')){
	 		UMS.ALERT("You don't have permission for Bank Name Setting.");
	  		return;
		}
		$om.bankNameDialog = Ext.create('Account.Bankname.MainWindow');
		$om.bankNameDialog.show();
	});

	$om.viewport.on('click_department', function(){

	  	if(!UMS.CAN.DISPLAY('DM')){
	 		UMS.ALERT("You don't have permission for Department master.");
	  		return;
		}
		$om.departDialog = Ext.create('Account.Department.MainWindow');
		$om.departDialog.show();
	});

	$om.viewport.on('click_position', function(){

	  	if(!UMS.CAN.DISPLAY('PS')){
	 		UMS.ALERT("You don't have permission for Position master.");
	  		return;
		}
		$om.positionDialog = Ext.create('Account.Position.MainWindow');
		$om.positionDialog.show();
	});

	$om.viewport.on('click_employee', function(){

	  	if(!UMS.CAN.DISPLAY('EP')){
	 		UMS.ALERT("You don't have permission for Employee master.");
	  		return;
		}
		$om.employeeDialog = Ext.create('Account.Employee.MainWindow');
		$om.employeeDialog.show();
	});

	$om.viewport.on('click_unit', function(){
		if(!UMS.CAN.DISPLAY('UN')){
	 		UMS.ALERT("You don't have permission for Unit.");
	  		return;
		}
		$om.unitDialog = Ext.create('Account.Unit.Window');
		$om.unitDialog.show();
	});

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

	$om.viewport.on('click_asset-master', function(){
		if(!UMS.CAN.DISPLAY('FA')){
			UMS.ALERT("You don't have permission for Asset Master.");
			return;
		}

		if(!$om.assetDialog)
			$om.assetDialog = Ext.create('Account.Asset.MainWindow');
		$om.assetDialog.show();
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
		if(!UMS.CAN.DISPLAY('FI')){
	 		UMS.ALERT("You don't have permission for Financial Statement Report.");
	  		return;
		}
		$om.RGeneralJournal = Ext.create('Account.RGeneralLedger.MainWindow');
		$om.RGeneralJournal.show();
	});

	$om.viewport.on('click_report_gr', function(){
		if(!UMS.CAN.DISPLAY('JR')){
	 		UMS.ALERT("You don't have permission for Journal Report.");
	  		return;
		}
		$om.RGeneralJournal = Ext.create('Account.RGeneralJournal.MainWindow');
		$om.RGeneralJournal.show();
	});

	$om.viewport.on('click_report_pj', function(){
		if(!UMS.CAN.DISPLAY('JR')){
	 		UMS.ALERT("You don't have permission for Journal Report.");
	  		return;
		}
		$om.RPettyCashJournal = Ext.create('Account.RPettyCashJournal.MainWindow');
		$om.RPettyCashJournal.show();
	});

	$om.viewport.on('click_report_sj', function(){
		if(!UMS.CAN.DISPLAY('JR')){
	 		UMS.ALERT("You don't have permission for Journal Report.");
	  		return;
		}
		$om.RSaleJournal = Ext.create('Account.RSaleJournal.MainWindow');
		$om.RSaleJournal.show();
	});

	$om.viewport.on('click_report_purchasej', function(){
		if(!UMS.CAN.DISPLAY('JR')){
	 		UMS.ALERT("You don't have permission for Journal Report.");
	  		return;
		}
		$om.RPurchaseJournal = Ext.create('Account.RPurchaseJournal.MainWindow');
		$om.RPurchaseJournal.show();
	});
	
	$om.viewport.on('click_report_receiptj', function(){
		if(!UMS.CAN.DISPLAY('JR')){
	 		UMS.ALERT("You don't have permission for Journal Report.");
	  		return;
		}
		$om.RReceiptJournal = Ext.create('Account.RReceiptJournal.MainWindow');
		$om.RReceiptJournal.show();
	});
	
	$om.viewport.on('click_report_paymentj', function(){
		if(!UMS.CAN.DISPLAY('JR')){
	 		UMS.ALERT("You don't have permission for Journal Report.");
	  		return;
		}
		$om.RPaymentJournal = Ext.create('Account.RPaymentJournal.MainWindow');
		$om.RPaymentJournal.show();
	});

	$om.viewport.on('click_report_tb', function(){
		if(!UMS.CAN.DISPLAY('FI')){
	 		UMS.ALERT("You don't have permission for Financial Statement Report.");
	  		return;
		}
		$om.RTrialBalance = Ext.create('Account.RTrialBalance.MainWindow');
		$om.RTrialBalance.show();
	});

	$om.viewport.on('click_report_income', function(){
		if(!UMS.CAN.DISPLAY('FI')){
	 		UMS.ALERT("You don't have permission for Financial Statement Report.");
	  		return;
		}
		$om.RIncome = Ext.create('Account.RIncome.MainWindow');
		$om.RIncome.show();
	});

	$om.viewport.on('click_report_balance_sheet', function(){
		if(!UMS.CAN.DISPLAY('FI')){
	 		UMS.ALERT("You don't have permission for Financial Statement Report.");
	  		return;
		}
		$om.RBalanceSheet = Ext.create('Account.RBalanceSheet.MainWindow');
		$om.RBalanceSheet.show();
	});

	$om.viewport.on('click_RSumVat', function(){
		if(!UMS.CAN.DISPLAY('TF')){
	 		UMS.ALERT("You don't have permission for Tax From.");
	  		return;
		}

		$om.RSumVat = Ext.create('Account.RSumVat.MainWindow');
		$om.RSumVat.show();
	});

	$om.viewport.on('click_Rpp30Vat', function(){
		if(!UMS.CAN.DISPLAY('TF')){
	 		UMS.ALERT("You don't have permission for Tax From.");
	  		return;
		}

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
		if(!UMS.CAN.DISPLAY('TF')){
	 		UMS.ALERT("You don't have permission for Tax From.");
	  		return;
		}

		$om.Rpnd50WHT = Ext.create('Account.Rpnd50WHT.MainWindow');
		$om.Rpnd50WHT.show();
	});

	$om.viewport.on('click_Rpnd53WHT', function(){
		$om.Rpnd53WHT = Ext.create('Account.Rpnd53WHT.MainWindow');
		$om.Rpnd53WHT.show();
	});

	/* ** Interval check session */
	var msgSessionExpire = null;
	var checkSession = function(){
		setTimeout(function(){
			Ext.Ajax.request({
				method: 'post',
			    url: __site_url+'ums/check_session',
			    success: function(response){
			        var text = response.responseText;
			        // process server response here
			        var o = Ext.decode(text);
			        if(o===false){
						msgSessionExpire = Ext.Msg.show({
							title:'Session is expire',
							msg: 'Your session has expired.<br /> Please log in again.',
							buttons: Ext.Msg.OK,
							icon: Ext.Msg.ERROR,
							closable: false,
							fn: function(bId){
								self.location.href=__site_url+'ums/login';
							}
						});
			        }else
			        	checkSession();
			    },
			    failure: function(){
			    	checkSession();
			    }
			});
		}, 10000);
	}
	checkSession();
	/* ** END Interval check session */
});
</script>

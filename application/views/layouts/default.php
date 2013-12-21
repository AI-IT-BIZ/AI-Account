<?php
$USER_PERMISSIONS = X::getUMSSession();

function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}
	return (substr($haystack, -$length) === $needle);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>AI Account</title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/ext/resources/css/ext-all.css') ?>" />
	<script type="text/javascript" src="<?= base_url('assets/ext/ext-all.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/ext/ux/NumericField.js') ?>"></script>
	<script type="text/javascript">
		Ext.form.field.ComboBox.override({
			setValue: function(v) {
				var _this=this,
					args = arguments;
				//v = (v && v.toString) ? v.toString() : v;
				if(!this.store.isLoaded && this.queryMode == 'remote') {
					this.store.addListener('load', function(store, rs) {
						this.store.isLoaded = true;

						//_this.setValue(v);
					}, this);
					this.store.load();
				} else {
					this.callOverridden(args);
				}
			}
		});
	</script>
	<script type="text/javascript">
		var __base_url = '<?= base_url() ?>',
			__site_url = '<?= endsWith(site_url(), '/')?site_url().'' : site_url().'/' ?>',
			__user_state = <?= json_encode($USER_PERMISSIONS) ?>;

		var UMSClass = function(){
			function checkPermission(docty, type){
				if(__user_state){
					var have = false;
					for(var i=0;i<__user_state.Permission.length;i++){
						var p = __user_state.Permission[i];
						if(p[type]==1 && p.docty==docty){
							have = true; break;
						}
					}
					return have;
				}else
					return false;
			}

			this.CAN = {
				DISPLAY : function(docty){ return checkPermission(docty, 'display'); },
				CREATE : function(docty){ return checkPermission(docty, 'create'); },
				EDIT : function(docty){ return checkPermission(docty, 'edit'); },
				DELETE : function(docty){ return checkPermission(docty, 'delete'); },
				EXPORT : function(docty){ return checkPermission(docty, 'export'); },
				APPROVE : function(docty){ return checkPermission(docty, 'approve'); }
			};

			this.ALERT = function(msg, title){
				title = title||'Permission is required.'
				Ext.Msg.show({
					title: title,
					msg: msg,
					buttons: Ext.Msg.OK,
					icon: Ext.MessageBox.ERROR
				});
			};
		}

		var UMS = new UMSClass();

		//console.log(UMS);
	</script>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>" />

	<style type="text/css">
		#center-wrap-body { background-color:#014051; }

		.box { position:absolute; cursor:pointer; }
		.box-blue { background-color:#2875eb; }
		.box-blue:hover { background-color:#418eff; }
		.box-orange { background-color:#dd9016; }
		.box-orange:hover { background-color:#f6a92f; }
		.box-purple { background-color:#5435ad; }
		.box-purple:hover { background-color:#6242be; }
		.box-brown { background-color:#8b5e3b; }
		.box-brown:hover { background-color:#a3734e; }
		.box-green { background-color:#008b16; }
		.box-green:hover { background-color:#0fa52f; }
		.box-red { background-color:#e04444; }
		.box-red:hover { background-color:#de5151; }
		.box-base { background-color:#004d61; }
		.box-base:hover { background-color:#0c6177; }

		#div1-1-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-1-container div span { position:absolute; bottom:10px; left:10px; }
		#div-project,#div-sales-project { top:30px; left:30px; width: 210px; height:100px; }
		#div-quotation,#div-sales-quotation { top:160px; left:30px; width: 90px; height:90px; }
		#div-customer { top:160px; left:150px; width: 90px; height:90px; }
		#div-deposit1,#div-sales-deposit1 { top:280px; left:30px; width: 90px; height:90px; }
		#div-saleorder { top:280px; left:150px; width: 90px; height:90px; }
		#div-invoice { top:400px; left:150px; width: 90px; height:90px; }
		#div-billto { top:400px; left:30px; width: 90px; height:90px; }
		#div-receipt { top:520px; left:30px; width: 210px; height:100px; }

		#div-rinvoice { position:absolute; top:630px; left:30px; width: 100px; height:100px; }
		#div-rreceipt { position:absolute; top:630px; left:140px; width: 100px; height:100px; }
		#div-config { position:absolute; top:740px; left:30px; width: 210px; height:100px; }

		#div-sales-saleorder2 { top:160px; left:150px; width: 130px; height:210px; }
		#div-sales-saleorder3 { top:160px; left:310px; width: 90px; height: 90px; }

		#div-sales-invoice2 { top:280px; left:310px; width: 90px; height: 90px; }
		#div-sales-invoice3 { top:160px; left:430px; width: 130px; height:210px; }

		#div-sales-billto2 { top:160px; left:590px; width: 90px; height: 90px; }

		#div-sales-receipt2 { top:280px; left:590px; width: 90px; height: 90px; }
		#div-sales-receipt3 { top:160px; left:710px; width: 130px; height:210px; }

		#div1-2-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-2-container div span { position:absolute; bottom:10px; left:10px; }
		#div-pr { top:30px; left:280px; width: 210px; height:100px; }
		#div-po { top:160px; left:280px; width: 90px; height:90px; }
		#div-vendor { top:160px; left:400px; width: 90px; height:90px; }
		#div-deposit2 { top:280px; left:280px; width: 90px; height:90px; }
		#div-gr { top:280px; left:400px; width: 90px; height:90px; }
		#div-ap { top:400px; left:400px; width: 90px; height:90px; }
	    #div-apxx { top:400px; left:400px; width: 90px; height:90px; cursor:default; }
		#div-billfrom { top:400px; left:280px; width: 90px; height:90px; }
		#div-payment { top:520px; left:280px; width: 210px; height:100px; }

		#div-rap { position:absolute; top:630px; left:280px; width: 100px; height:100px; }
		#div-rpayment { position:absolute; top:630px; left:390px; width: 100px; height:100px; }
		#div-employee { position:absolute; top:740px; left:280px; width: 100px; height:100px; }

		#div-purchase-pr2 { top:30px; left:30px; width: 210px; height:100px; }
		#div-purchase-po2 { top:160px; left:30px; width: 90px; height:90px; }
		#div-purchase-deposit21 { top:280px; left:30px; width: 90px; height:90px; }

		#div-purchase-gr2 { top:160px; left:150px; width: 130px; height:210px; }
		#div-purchase-gr3 { top:160px; left:310px; width: 90px; height: 90px; }

		#div-purchase-ap2 { top:280px; left:310px; width: 90px; height: 90px; }
		#div-purchase-ap3 { top:160px; left:430px; width: 130px; height:210px; }

		#div-purchase-billfrom2 { top:160px; left:590px; width: 90px; height: 90px; }

		#div-purchase-payment2 { top:280px; left:590px; width: 90px; height: 90px; }
		#div-purchase-payment3 { top:160px; left:710px; width: 130px; height:210px; }


		#div1-3-container { width: 240px; height:500px; color:white; font-weight:bold; }
		#div1-3-container div span { position:absolute; bottom:10px; left:10px; }
		#div-income { top:30px; left:530px; width: 100px; height:100px; }
		#div-journaltemp { top:30px; left:640px; width: 100px; height:100px; }
		#div-journal { top:140px; left:530px; width: 210px; height:100px; }
		#div-manage-costcenter { top:250px; left:530px; width: 100px; height:100px; }
		#div-chart-account { position:absolute; top:250px; left:640px; width: 100px; height:100px; }
		#div-asset-regist { top:360px; left:530px; width: 100px; height:100px; }
		#div-dep-amort { position:absolute; top:360px; left:640px; width: 100px; height:100px; }

		#div-rjournal { position:absolute; top:510px; left:530px; width: 100px; height:100px; }
		#div-rgl { position:absolute; top:510px; left:640px; width: 100px; height:100px; }
		#div-rar-aging { position:absolute; top:620px; left:530px; width: 100px; height:100px; }
		#div-rap-aging { position:absolute; top:620px; left:640px; width: 100px; height:100px; }
		#div-rmm-aging { position:absolute; top:730px; left:530px; width: 100px; height:100px; }
		#div-rmm-stockcard { position:absolute; top:730px; left:640px; width: 100px; height:100px; }

		#div-income2 { top:30px; left:150px; width: 100px; height:100px; }
		#div-journaltemp2 { top:30px; left:260px; width: 100px; height:100px; }
		#div-journal2 { top:140px; left:150px; width: 210px; height:100px; }
		#div-manage-costcenter2 { top:250px; left:150px; width: 100px; height:100px; }
		#div-chart-account2 { position:absolute; top:250px; left:260px; width: 100px; height:100px; }
		#div-asset-regist2 { top:360px; left:150px; width: 100px; height:100px; }
		#div-dep-amort2 { position:absolute; top:360px; left:260px; width: 100px; height:100px; }

		#div-rjournal2 { position:absolute; top:510px; left:150px; width: 100px; height:100px; }
		#div-rgl2 { position:absolute; top:510px; left:260px; width: 100px; height:100px; }
		#div-rar-aging2 { position:absolute; top:620px; left:150px; width: 100px; height:100px; }
		#div-rap-aging2 { position:absolute; top:620px; left:260px; width: 100px; height:100px; }

		#div1-4-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-4-container div span { position:absolute; bottom:10px; left:10px; }
		#div-transaction { top:30px; left:780px; width: 100px; height:100px; }
		#div-balance { top:30px; left:890px; width: 100px; height:100px; }
		#div-material { top:140px; left:780px; width: 100px; height:100px; }
		#div-service { top:140px; left:890px; width: 100px; height:100px; }
		#div-otincome { top:250px; left:780px; width: 100px; height:100px; }
		#div-otexpense { top:250px; left:890px; width: 100px; height:100px; }

		#div-rtransaction { position:absolute; top:400px; left:780px; width: 100px; height:100px; }
		#div-rbalance { position:absolute; top:400px; left:890px; width: 100px; height:100px; }

		#div-transaction2 { top:30px; left:150px; width: 100px; height:100px; }
		#div-balance2 { top:30px; left:260px; width: 100px; height:100px; }
		#div-material2 { top:140px; left:150px; width: 100px; height:100px; }
		#div-service2 { top:140px; left:260px; width: 100px; height:100px; }
		#div-otincome2 { top:250px; left:150px; width: 100px; height:100px; }
		#div-otexpense2 { top:250px; left:260px; width: 100px; height:100px; }

		#div-rtransaction2 { position:absolute; top:400px; left:150px; width: 100px; height:100px; }
		#div-rbalance2 { position:absolute; top:400px; left:260px; width: 100px; height:100px; }

		/* Toolbar */
		/* move toolbar css into style.css  */

		/* Arrow */
		.arrow { width:11px; border:0px solid #f00; position:absolute; background:#014051 url('<?= base_url('assets/images/arrow/arrow-line.gif') ?>') repeat-y center center; }
		.arrow-down span { display:block; width:11px; height:6px; position:absolute; bottom:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-down.gif') ?>') repeat-y center center;
		}
		.arrow-up span { display:block; width:11px; height:6px; position:absolute; top:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-up.gif') ?>') repeat-y center center;
		}
		.arrow-right,
		.arrow-left { height:11px;background:#014051 url('<?= base_url('assets/images/arrow/arrow-line-h.gif') ?>') repeat-x center center; }
		.arrow-left span { display:block; width:6px; height:11px; position:absolute; left:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-left.gif') ?>') repeat-y center center;
		}
		.arrow-right span {
			display:block; width:6px; height:11px; position:absolute; right:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-right.gif') ?>') repeat-y center center;
		}
		#arrow-home-01 { height:30px; top:130px; left:71px; }
		#arrow-home-02 { height:30px; top:130px; left:190px; }
		#arrow-home-03 { width:30px; top:200px; left:120px; }
		#arrow-home-04 { height:30px; top:250px; left:71px; }
		#arrow-home-05 { width:30px; top:321px; left:120px; }
		#arrow-home-06 { height:30px; top:370px; left:190px; }
		#arrow-home-07 { width:30px; top:441px; left:120px; }
		#arrow-home-15 { height:30px; top:490px; left:71px; }
		#arrow-home-17 { height:30px; top:490px; left:190px; }

		#arrow-home-08 { height:30px; top:130px; left:320px; }
		#arrow-home-09 { height:30px; top:130px; left:440px; }
		#arrow-home-10 { width:30px; top:199px; left:370px; }
		#arrow-home-11 { height:30px; top:250px; left:320px; }
		#arrow-home-12 { width:30px; top:321px; left:370px; }
		#arrow-home-13 { height:30px; top:370px; left:440px; }
		#arrow-home-14 { width:30px; top:440px; left:370px; }
		#arrow-home-16 { height:30px; top:490px; left:320px; }
		#arrow-home-18 { height:30px; top:490px; left:440px; }

		#arrow-sale-01 { width:30px; top:200px; left:280px; }
		#arrow-sale-02 { width:150px; top:260px; left:280px; }
		#arrow-sale-03 { width:30px; top:321px; left:280px; }

		#arrow-sale-04 { width:30px; top:200px; left:400px; }
		#arrow-sale-05 { width:30px; top:321px; left:400px; }

		#arrow-sale-06 { width:30px; top:200px; left:560px; }
		#arrow-sale-07 { width:150px; top:260px; left:560px; }
		#arrow-sale-08 { width:30px; top:321px; left:560px; }

		#arrow-sale-09 { width:30px; top:200px; left:680px; }
		#arrow-sale-10 { width:30px; top:321px; left:680px; }

		#arrow-purc-01 { width:30px; top:200px; left:280px; }
		#arrow-purc-02 { width:150px; top:260px; left:280px; }
		#arrow-purc-03 { width:30px; top:321px; left:280px; }

		#arrow-purc-04 { width:30px; top:200px; left:400px; }
		#arrow-purc-05 { width:30px; top:321px; left:400px; }

		#arrow-purc-06 { width:30px; top:200px; left:560px; }
		#arrow-purc-07 { width:150px; top:260px; left:560px; }
		#arrow-purc-08 { width:30px; top:321px; left:560px; }

		#arrow-purc-09 { width:30px; top:200px; left:680px; }
		#arrow-purc-10 { width:30px; top:321px; left:680px; }
	</style>
</head>
<body>
	<script type="text/javascript">
		var $om = {};
		requires: ['*'];
		Ext.onReady(function() {

			// MENU TREE
			var nodeTutorials = {
				text: 'View tutorials on using BizNet Accounts',
				leaf: true
			};
			var nodeSetup = {
				text: 'Config BizNet Accounts',
				leaf: true
			};
	        var nodeLogin = {
				text: 'Login',
				leaf: true
			};
			var groupNodeTodo = {
				text: 'TO-DO',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeTutorials,
					nodeSetup,
					nodeLogin
				]
			};

			var nodeProject = {
				text: 'Create New Projects',
				leaf: true
			};
			var nodeQuotation = {
				text: 'Create New Quotations',
				leaf: true
			};
			var nodeSaleOrder = {
				text: 'Create New Sale Orders',
				leaf: true
			};
			var nodeInvoice = {
				text: 'Create New Invoices',
				leaf: true
			};
			var nodeReceipt = {
				text: 'Create New Receipts',
				leaf: true
			};
			var nodeCustomer = {
				text: 'Create New Customers',
				leaf: true
			};
			var nodeSalePerson = {
				text: 'Create New Sale Persons',
				leaf: true
			};

			var groupSale = {
				text: 'Sales',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeProject,
					nodeQuotation,
					nodeSaleOrder,
					nodeInvoice,
					nodeReceipt,
					nodeCustomer,
					nodeSalePerson
				]
			};
			
			var nodePR = {
				text: 'Create New Purchase Requisitions',
				leaf: true
			};
			var nodePO = {
				text: 'Create New Purchase Orders',
				leaf: true
			};
			var nodeGR = {
				text: 'Create New Goods Receipts',
				leaf: true
			};
			var nodeAP = {
				text: 'Create New Account Payables',
				leaf: true
			};
			var nodePayment = {
				text: 'Create New Payments',
				leaf: true
			};
			var nodeVendor = {
				text: 'Create New Vendors',
				leaf: true
			};

			var groupPurchase = {
				text: 'Purchases',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodePR,
					nodePO,
					nodeGR,
					nodeAP,
					nodePayment,
					nodeVendor
				]
			};

			//var nodeIncome = {
			//	text: 'Create New Income Statements',
			//	leaf: true
			//};
			var nodeJTemplate = {
				text: 'Create New Journal Templates',
				leaf: true
			};
			var nodeJournal = {
				text: 'Create New Journals',
				leaf: true
			};
			//var nodeBudget = {
			//	text: 'Create New Manage Bugets',
			//	leaf: true
			//};
			var nodeAccChart = {
				text: 'Chart of Accounts',
				leaf: true
			};

			var groupAccount = {
				text: 'Accounts',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					//nodeIncome,
					nodeJTemplate,
					nodeJournal,
					//nodeBudget,
					nodeAccChart
				]
			};

			var nodeTrans = {
				text: 'Create New Material Transactions',
				leaf: true
			};
			var nodeBalances = {
				text: 'Create New Material Balances',
				leaf: true
			};
			var nodeOtherIn = {
				text: 'Create New Other Incomes',
				leaf: true
			};
			var nodeOtherEx = {
				text: 'Create New Other Expenses',
				leaf: true
			};
			var nodeMaterial = {
				text: 'Create New Materials',
				leaf: true
			};
			var nodeService = {
				text: 'Create New Services',
				leaf: true
			};

			var groupMaterial = {
				text: 'Material Management',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeTrans,
					nodeBalances,
					nodeOtherIn,
					nodeOtherEx,
					nodeMaterial,
					nodeService
				]
			};

			var nodeReport1 = {
				text: 'Report 1',
				leaf: true
			};
			var nodeReport2 = {
				text: 'Report 2',
				leaf: true
			};
			var nodeReport3 = {
				text: 'Report 3',
				leaf: true
			};
			
			var groupReport = {
				text: 'Reports',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeReport1,
					nodeReport2,
					nodeReport3,
					{
						text: 'Report General Journal',
						leaf: true
					}
				]
			};

            var nodeCompany = {
				text: 'Company Define',
				leaf: true
			};
			var nodeInit = {
				text: 'Initail Doc No.',
				leaf: true
			};
			var nodeUser = {
				text: 'User Define',
				leaf: true
			};
			var nodeAuth = {
				text: 'Authorize Setting',
				leaf: true
			};
			var nodeChart = {
				text: 'Chart of Accounts',
				leaf: true
			};
			var nodeEmployee = {
				text: 'Employee',
				leaf: true
			};

			var groupConfig = {
				text: 'Configuration',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
				    nodeCompany,
				    nodeInit,
				    nodeUser,
				    nodeAuth,
					nodeChart,
					nodeEmployee
				]
			};

			var tree = new Ext.tree.TreePanel({
				region: 'west',
				collapsible: false,
				width: 230,
				autoScroll: true,
				split: true,
				useArrows:true,
				rootVisible: false,
				root: {
					expanded: true,
					children: [
						groupNodeTodo,
						groupSale,
						groupPurchase,
						groupAccount,
						groupMaterial,
						groupReport,
						groupConfig
					]
				}
			});

			tree.on('cellclick', function (tree, td, cellIndex, rec, tr, rowIndex, e, eOpts ) {
               if(tr.innerHTML.indexOf('Chart of Accounts') > -1)
               {
               	  if(!UMS.CAN.DISPLAY('CA')){
				  UMS.ALERT("You don't have permission for Chart of Accounts.");
				  return;
				  }	

                  $om.chartOfAccountDialog = Ext.create('Account.ChartOfAccounts.MainWindow')
                  $om.chartOfAccountDialog.show();
                  return;
               }
//<<<<<<< HEAD
			if(tr.innerHTML.indexOf('Create New Sale Persons') > -1)
			{
				//if(!UMS.CAN.DISPLAY('PJ')){
				//UMS.ALERT("You don't have permission for Project.");
				//return;
				//}		
				if(!$om.salepersonDialog)
					$om.salepersonDialog = Ext.create('Account.Saleperson.MainWindow');
				$om.salepersonDialog.show();
			}
            if(tr.innerHTML.indexOf('Create New Projects') > -1)
			{
				if(!UMS.CAN.DISPLAY('PJ')){
				UMS.ALERT("You don't have permission for Project.");
				return;
				}		
				if(!$om.projectDialog)
					$om.projectDialog = Ext.create('Account.Project.MainWindow');
				$om.projectDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Quotations') > -1)
			{
				if(!UMS.CAN.DISPLAY('QT')){
				UMS.ALERT("You don't have permission for Quotation.");
				return;
				}		
				if(!$om.projectDialog)
					$om.quotationDialog = Ext.create('Account.Quotation.MainWindow');
				$om.quotationDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Sale Orders') > -1)
			{
				if(!UMS.CAN.DISPLAY('SO')){
				UMS.ALERT("You don't have permission for Sale Order.");
				return;
				}		
				if(!$om.saleorderDialog)
					$om.saleorderDialog = Ext.create('Account.Saleorder.MainWindow');
				$om.saleorderDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Invoices') > -1)
			{
				if(!UMS.CAN.DISPLAY('IV')){
				UMS.ALERT("You don't have permission for Invoice.");
				return;
				}		
				if(!$om.invoiceDialog)
					$om.invoiceDialog = Ext.create('Account.Invoice.MainWindow');
				$om.invoiceDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Receipts') > -1)
			{
				if(!UMS.CAN.DISPLAY('RD')){
				UMS.ALERT("You don't have permission for Receipt.");
				return;
				}		
				if(!$om.receiptDialog)
					$om.receiptDialog = Ext.create('Account.Receipt.MainWindow');
				$om.receiptDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Customers') > -1)
			{
				if(!UMS.CAN.DISPLAY('CS')){
				UMS.ALERT("You don't have permission for Customer.");
				return;
				}		
				if(!$om.customerDialog)
				$om.customerDialog = Ext.create('Account.Customer.MainWindow');
				$om.customerDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Purchase Requisitions') > -1)
			{
				if(!UMS.CAN.DISPLAY('PR')){
				UMS.ALERT("You don't have permission for Purchase Requisition.");
				return;
				}		
				if(!$om.prDialog)
				$om.prDialog = Ext.create('Account.PR.MainWindow');
				$om.prDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Purchase Orders') > -1)
			{
				if(!UMS.CAN.DISPLAY('PO')){
				UMS.ALERT("You don't have permission for Purchase Order.");
				return;
				}		
				if(!$om.poDialog)
				$om.poDialog = Ext.create('Account.PO.MainWindow');
				$om.poDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Goods Receipts') > -1)
			{
				if(!UMS.CAN.DISPLAY('GR')){
				UMS.ALERT("You don't have permission for Goods Receipts.");
				return;
				}		
				if(!$om.grDialog)
				$om.grDialog = Ext.create('Account.GR.MainWindow');
				$om.grDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Account Payables') > -1)
			{
				if(!UMS.CAN.DISPLAY('AP')){
				UMS.ALERT("You don't have permission for Account Payables.");
				return;
				}		
				if(!$om.apDialog)
				$om.apDialog = Ext.create('Account.AP.MainWindow');
				$om.apDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Payments') > -1)
			{
				if(!UMS.CAN.DISPLAY('PD')){
				UMS.ALERT("You don't have permission for Account Payment.");
				return;
				}		
				if(!$om.paymentDialog)
				$om.paymentDialog = Ext.create('Account.Payment.MainWindow');
				$om.paymentDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Account Vendors') > -1)
			{
				if(!UMS.CAN.DISPLAY('VD')){
				UMS.ALERT("You don't have permission for Vendor.");
				return;
				}		
				if(!$om.vendorDialog)
				$om.vendorDialog = Ext.create('Account.Vendor.MainWindow');
				$om.vendorDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Journal Templates') > -1)
			{
				if(!UMS.CAN.DISPLAY('JT')){
				UMS.ALERT("You don't have permission for Journal Template.");
				return;
				}		
				if(!$om.journaltempDialog)
				$om.journaltempDialog = Ext.create('Account.Journaltemp.MainWindow');
				$om.journaltempDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Journals') > -1)
			{
				if(!UMS.CAN.DISPLAY('JN')){
				UMS.ALERT("You don't have permission for Journal.");
				return;
				}		
				if(!$om.journaltempDialog)
				$om.journalDialog = Ext.create('Account.Journal.MainWindow');
				$om.journalDialog.show();
			}
			if(tr.innerHTML.indexOf('Authorize Setting') > -1)
			{
			  	if(!UMS.CAN.DISPLAY('AU')){
			 	UMS.ALERT("You don't have permission for Authorize Setting.");
			  	return;
				}
				$om.configDialog = Ext.create('Account.UMS.MainWindow');
				$om.configDialog.show();
				//$om.configDialog = Ext.create('Account.Configauthen.MainWindow')
				//$om.configDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Materials') > -1)
			{
			  	if(!UMS.CAN.DISPLAY('MM')){
			 	UMS.ALERT("You don't have permission for Material.");
			  	return;
				}
				$om.materialDialog = Ext.create('Account.Material.MainWindow');
				$om.materialDialog.show();
			}
			if(tr.innerHTML.indexOf('Create New Services') > -1)
			{
			  	if(!UMS.CAN.DISPLAY('SV')){
			 	UMS.ALERT("You don't have permission for Services.");
			  	return;
				}
				$om.serviceDialog = Ext.create('Account.Service.MainWindow');
				$om.serviceDialog.show();
			}
			if(tr.innerHTML.indexOf('User Define') > -1)
			{
				$om.configDialog = Ext.create('Account.Configauthen.MainWindow')
				$om.configDialog.show();
				//$om.configDialog = Ext.create('Account.Configauthen.WinUserDefine')
				//$om.configDialog.show();
			}
			if(tr.innerHTML.indexOf('Login') > -1)
			{
				//$om.configDialog = Ext.create('Account.Configauthen.Main')
				$om.loginDialog = Ext.create('Account.Login.MainWindow');
				$om.loginDialog.show();
			}
			// $om.configDialog = Ext.create('Account.Configauthen.MainWindow')
			// $om.configDialog.show();
//=======
				if(tr.innerHTML.indexOf('Authorize Setting') > -1)
				{
					$om.configDialog = Ext.create('Account.UMS.MainWindow');
					$om.configDialog.show();
					//$om.configDialog = Ext.create('Account.Configauthen.MainWindow')
					//$om.configDialog.show();
				}
				if(tr.innerHTML.indexOf('User Define') > -1)
				{
					$om.configDialog = Ext.create('Account.Configauthen.MainWindow')
					$om.configDialog.show();
					//$om.configDialog = Ext.create('Account.Configauthen.WinUserDefine')
					//$om.configDialog.show();
				}
				if(tr.innerHTML.indexOf('Login') > -1)
				{
					//$om.configDialog = Ext.create('Account.Configauthen.Main')
					$om.loginDialog = Ext.create('Account.Login.MainWindow');
					$om.loginDialog.show();
				}
				// $om.configDialog = Ext.create('Account.Configauthen.MainWindow')
				// $om.configDialog.show();
				
				if(tr.innerHTML.indexOf('Report General Journal') > -1){
					$om.RGeneralJournal = Ext.create('Account.RGeneralJournal.MainWindow');
					$om.RGeneralJournal.show();					
				}
//>>>>>>> 8f5d4b9d573dccfeabaacb36a517b16949eeebf5
            });

			// CENTER PANEL
			var centerPanel = new Ext.Panel({
				region:'center',
				layout: 'border',
				border: false,
				items: [
					tree,
					{
						id:'center-wrap', region:'center',
						layout:'fit', border:true,
						autoScroll: true,
						html : [
							'<div id="home-container">',
								//Sale Module
								'<div id="div1-1-container">',
									'<div id="div-project" class="box box-green"><span>Create New Projects</span></div>',
									'<div id="div-quotation" class="box box-green"><span>Quotations</span></div>',
									'<div id="div-saleorder" class="box box-green"><span>Sale Orders</span></div>',
									'<div id="div-invoice" class="box box-green"><span>Invoices</span></div>',
									'<div id="div-billto" class="box box-green"><span>Billing Note</span></div>',
									'<div id="div-receipt" class="box box-green"><span>Receipts</span></div>',
									'<div id="div-deposit1" class="box box-green"><span>Deposit Receipts</span></div>',
									'<div id="div-customer" class="box box-green"><span>Customers</span></div>',

									'<div id="div-rinvoice" class="box box-orange"><span>Invoices Report</span></div>',
									'<div id="div-rreceipt" class="box box-orange"><span>Receipt Report</span></div>',
									'<div id="div-config" class="box box-base"><span>Configure BizNet Accounts</span></div>',
								'</div>',
								//Purchase Module
								'<div id="div1-2-container">',
									'<div id="div-pr" class="box box-red"><span>Purchase Requisitions</span></div>',
									'<div id="div-po" class="box box-red"><span>Purchase Orders</span></div>',
									'<div id="div-gr" class="box box-red"><span>Goods Receipts</span></div>',
									'<div id="div-vendor" class="box box-red"><span>Vendors</span></div>',
									'<div id="div-ap" class="box box-red"><span>Account Payable</span></div>',
									'<div id="div-apxx" style="visibility:hidden;" class="box box-red"><span>Account Payable</span></div>',
									'<div id="div-payment" class="box box-red"><span>Payments</span></div>',
									'<div id="div-deposit2" class="box box-red"><span>Deposit Payments</span></div>',
									'<div id="div-billfrom" class="box box-red"><span>Billing Receipts</span></div>',

									'<div id="div-rap" class="box box-orange"><span>AP Report</span></div>',
									'<div id="div-rpayment" class="box box-orange"><span>Payment Report</span></div>',
									'<div id="div-employee" class="box box-orange"><span>Employee</span></div>',
								'</div>',
								//Account Module
								'<div id="div1-3-container">',
									'<div id="div-income" class="box box-blue"><span>Income Statement</span></div>',
									'<div id="div-journaltemp" class="box box-blue"><span>Journal Template</span></div>',
									'<div id="div-journal" class="box box-blue"><span>Journal</span></div>',
									'<div id="div-manage-costcenter" class="box box-blue"><span>Manage Cost Center</span></div>',
									'<div id="div-chart-account" class="box box-blue"><span>Chart of Account</span></div>',
									'<div id="div-asset-regist" class="box box-blue"><span>Fixed Asset Register</span></div>',
									'<div id="div-dep-amort" class="box box-blue"><span>Depreciation& Amortization</span></div>',

									'<div id="div-rjournal" class="box box-orange"><span>Journal Report</span></div>',
									'<div id="div-rgl" class="box box-orange"><span>GL Report</span></div>',
									'<div id="div-rar-aging" class="box box-orange"><span>AR Aging Report</span></div>',
									'<div id="div-rap-aging" class="box box-orange"><span>AP Aging Report</span></div>',
									'<div id="div-rmm-aging" class="box box-orange"><span>Inventory Aging Report</span></div>',
									'<div id="div-rmm-stockcard" class="box box-orange"><span>Stock Card Report</span></div>',
								'</div>',
								//Material Module
								'<div id="div1-4-container">',
								    '<div id="div-transaction" class="box box-purple"><span>Inventory Transactions</span></div>',
									'<div id="div-balance" class="box box-purple"><span>Inventory Balances</span></div>',
									'<div id="div-otincome" class="box box-purple"><span>Other Incomes</span></div>',
									'<div id="div-otexpense" class="box box-purple"><span>Other Expenses</span></div>',
									'<div id="div-material" class="box box-purple"><span>Materials Master</span></div>',
									'<div id="div-service" class="box box-purple"><span>Services Master</span></div>',

									'<div id="div-rtransaction" class="box box-orange"><span>Transaction Report</span></div>',
									'<div id="div-rbalance" class="box box-orange"><span>Balance Report</span></div>',
								'</div>',
								// arrow
								'<div id="arrow-home-01" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-02" class="arrow arrow-up"><span></span></div>',
								'<div id="arrow-home-03" class="arrow arrow-left"><span></span></div>',
								'<div id="arrow-home-04" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-05" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-home-06" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-07" class="arrow arrow-left"><span></span></div>',

								'<div id="arrow-home-08" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-09" class="arrow arrow-up"><span></span></div>',
								'<div id="arrow-home-10" class="arrow arrow-left"><span></span></div>',
								'<div id="arrow-home-11" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-12" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-home-13" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-14" class="arrow arrow-left"><span></span></div>',
								'<div id="arrow-home-15" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-16" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-17" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-18" class="arrow arrow-down"><span></span></div>',
							'</div>',
							'<div id="sales-container" style="display:none;">',
								'<div id="div1-1-container">',
									'<div id="div-sales-project" class="box box-green"><span>Create New Projects</span></div>',
									'<div id="div-sales-quotation" class="box box-green"><span>Quotations</span></div>',
									'<div id="div-sales-saleorder2" class="box box-green"><span>Create New Sale Order</span></div>',
									'<div id="div-sales-saleorder3" class="box box-green"><span>Sale Orders</span></div>',
									'<div id="div-sales-invoice2" class="box box-green"><span>invoices</span></div>',
									'<div id="div-sales-invoice3" class="box box-green"><span>Create New Invoice</span></div>',
									'<div id="div-sales-billto2" class="box box-green"><span>Bill to Customers</span></div>',
									'<div id="div-sales-receipt2" class="box box-green"><span>Receipts</span></div>',
									'<div id="div-sales-receipt3" class="box box-green"><span>Create New Receipt</span></div>',
									'<div id="div-sales-deposit1" class="box box-green"><span>Deposit Receipts</span></div>',

								'</div>',
								// arrow
								'<div id="arrow-home-01" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-03" class="arrow arrow-left"><span></span></div>',
								'<div id="arrow-home-04" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-05" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-01" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-02" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-03" class="arrow arrow-right"><span></span></div>',

								'<div id="arrow-sale-04" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-05" class="arrow arrow-left"><span></span></div>',

								'<div id="arrow-sale-06" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-07" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-08" class="arrow arrow-right"><span></span></div>',

								'<div id="arrow-sale-09" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-10" class="arrow arrow-left"><span></span></div>',
							'</div>',
							'<div id="purchase-container" style="display:none;">',
								'<div id="div1-2-container">',
									'<div id="div-purchase-pr2" class="box box-red"><span>Create New Purchase Requisitions</span></div>',
									'<div id="div-purchase-po2" class="box box-red"><span>Purchase Orders</span></div>',
									'<div id="div-purchase-gr2" class="box box-red"><span>Create New Goods Receipt</span></div>',
									'<div id="div-purchase-gr3" class="box box-red"><span>Goods Receipts</span></div>',
									'<div id="div-purchase-ap2" class="box box-red"><span>Account Payables</span></div>',
									'<div id="div-purchase-ap3" class="box box-red"><span>Create New Account Payable</span></div>',
									'<div id="div-purchase-billfrom2" class="box box-red"><span>Bill from Vendors</span></div>',
									'<div id="div-purchase-payment2" class="box box-red"><span>Payments</span></div>',
									'<div id="div-purchase-payment3" class="box box-red"><span>Create New Payment</span></div>',
									'<div id="div-purchase-deposit21" class="box box-red"><span>Deposit Payments</span></div>',

								'</div>',
								// arrow
								'<div id="arrow-home-01" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-03" class="arrow arrow-left"><span></span></div>',
								'<div id="arrow-home-04" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-home-05" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-01" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-02" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-03" class="arrow arrow-right"><span></span></div>',

								'<div id="arrow-purc-04" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-05" class="arrow arrow-left"><span></span></div>',

								'<div id="arrow-purc-06" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-07" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-08" class="arrow arrow-right"><span></span></div>',

								'<div id="arrow-purc-09" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-10" class="arrow arrow-left"><span></span></div>',
							'</div>',
							'</div>',
							'<div id="account-container" style="display:none;">',
								'<div id="div1-3-container">',
									'<div id="div-account-income2" class="box box-blue"><span>Income Statement</span></div>',
									'<div id="div-account-journaltemp2" class="box box-blue"><span>Journal Template</span></div>',
									'<div id="div-account-journal2" class="box box-blue"><span>Journal</span></div>',
									'<div id="div-account-manage-costcenter2" class="box box-blue"><span>Manage Cost Center</span></div>',
									'<div id="div-account-chart-account2" class="box box-blue"><span>Chart of Account</span></div>',
									'<div id="div-account-asset-regist2" class="box box-blue"><span>Fixed Asset Register</span></div>',
									'<div id="div-account-dep-amort2" class="box box-blue"><span>Depreciation& Amortization</span></div>',

									'<div id="div-account-rjournal2" class="box box-orange"><span>Journal Report</span></div>',
									'<div id="div-account-rgl2" class="box box-orange"><span>GL Report</span></div>',
									'<div id="div-account-rar-aging2" class="box box-orange"><span>AR Aging Report</span></div>',
									'<div id="div-account-rap-aging2" class="box box-orange"><span>AP Aging Report</span></div>',
								'</div>',
							'</div>',
							'<div id="material-container" style="display:none;">',
								'<div id="div1-4-container">',
								    '<div id="div-material-transaction2" class="box box-purple"><span>Inventory Transactions</span></div>',
									'<div id="div-material-balance2" class="box box-purple"><span>Inventory Balances</span></div>',
									'<div id="div-material-otincome2" class="box box-purple"><span>Other Incomes</span></div>',
									'<div id="div-material-otexpense2" class="box box-purple"><span>Other Expenses</span></div>',
									'<div id="div-material-material2" class="box box-purple"><span>Inventories Master</span></div>',
									'<div id="div-material-service2" class="box box-purple"><span>Services Master</span></div>',

									'<div id="div-rtransaction2" class="box box-orange"><span>Transaction Report</span></div>',
									'<div id="div-rbalance2" class="box box-orange"><span>Balance Report</span></div>',
								'</div>',
							'</div>',
							'<div id="config-container" style="display:none;">',
								//'<img src="'+__base_url+'assets/images/temp/bg-reports.gif?v=1" />',
							'</div>',
							'<div id="reports-container" style="display:none;">',
								//'<img src="'+__base_url+'assets/images/temp/bg-reports.gif?v=1" />',
							'</div>'
						].join(''),
						listeners : {
							render : function(c) {
								pEl = c.getEl();

								pEl.getById('div-income').on('click', function(){ $om.viewport.fireEvent('click_income', c); }, c);
								pEl.getById('div-journaltemp').on('click', function(){ $om.viewport.fireEvent('click_journaltemp', c); }, c);
								pEl.getById('div-journal').on('click', function(){ $om.viewport.fireEvent('click_journal', c); }, c);

                                pEl.getById('div-rjournal').on('click', function(){ $om.viewport.fireEvent('click_rjournal', c); }, c);
								pEl.getById('div-rgl').on('click', function(){ $om.viewport.fireEvent('click_rgl', c); }, c);
								pEl.getById('div-rar-aging').on('click', function(){ $om.viewport.fireEvent('click_rar-aging', c); }, c);
								pEl.getById('div-rap-aging').on('click', function(){ $om.viewport.fireEvent('click_rap-aging', c); }, c);
								pEl.getById('div-rmm-aging').on('click', function(){ $om.viewport.fireEvent('click_rmm-aging', c); }, c);
								pEl.getById('div-rmm-stockcard').on('click', function(){ $om.viewport.fireEvent('click_rmm-stockcard', c); }, c);
								pEl.getById('div-chart-account').on('click', function(){ $om.viewport.fireEvent('click_chart-account', c); }, c);
								//Sales Module
								pEl.getById('div-project').on('click', function(){ $om.viewport.fireEvent('click_project', c); }, c);
								pEl.getById('div-quotation').on('click', function(){ $om.viewport.fireEvent('click_quotation', c); }, c);
								pEl.getById('div-invoice').on('click', function(){ $om.viewport.fireEvent('click_invoice', c); }, c);
								pEl.getById('div-receipt').on('click', function(){ $om.viewport.fireEvent('click_receipt', c); }, c);
								pEl.getById('div-customer').on('click', function(){ $om.viewport.fireEvent('click_customer', c); }, c);
								pEl.getById('div-saleorder').on('click', function(){ $om.viewport.fireEvent('click_saleorder', c); }, c);
								pEl.getById('div-billto').on('click', function(){ $om.viewport.fireEvent('click_billto', c); }, c);
								pEl.getById('div-deposit1').on('click', function(){ $om.viewport.fireEvent('click_deposit1', c); }, c);

								pEl.getById('div-rinvoice').on('click', function(){ $om.viewport.fireEvent('click_rinvoice', c); }, c);
								pEl.getById('div-rreceipt').on('click', function(){ $om.viewport.fireEvent('click_rreceipt', c); }, c);
								pEl.getById('div-config').on('click', function(){ $om.viewport.fireEvent('click_config', c); }, c);
								//Purchases Module
								pEl.getById('div-pr').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
								pEl.getById('div-po').on('click', function(){ $om.viewport.fireEvent('click_po', c); }, c);
								pEl.getById('div-gr').on('click', function(){ $om.viewport.fireEvent('click_gr', c); }, c);
								pEl.getById('div-vendor').on('click', function(){ $om.viewport.fireEvent('click_vendor', c); }, c);
								pEl.getById('div-ap').on('click', function(){ $om.viewport.fireEvent('click_ap', c); }, c);
								pEl.getById('div-payment').on('click', function(){ $om.viewport.fireEvent('click_payment', c); }, c);
								pEl.getById('div-billfrom').on('click', function(){ $om.viewport.fireEvent('click_billfrom', c); }, c);
								pEl.getById('div-deposit2').on('click', function(){ $om.viewport.fireEvent('click_deposit2', c); }, c);

								pEl.getById('div-rap').on('click', function(){ $om.viewport.fireEvent('click_rap', c); }, c);
								pEl.getById('div-rpayment').on('click', function(){ $om.viewport.fireEvent('click_rpayment', c); }, c);
								pEl.getById('div-employee').on('click', function(){ $om.viewport.fireEvent('click_employee', c); }, c);
								//Material Module
								pEl.getById('div-material').on('click', function(){ $om.viewport.fireEvent('click_material', c); }, c);
								pEl.getById('div-service').on('click', function(){ $om.viewport.fireEvent('click_service', c); }, c);
								pEl.getById('div-otincome').on('click', function(){ $om.viewport.fireEvent('click_otincome', c); }, c);
                                pEl.getById('div-otexpense').on('click', function(){ $om.viewport.fireEvent('click_otexpense', c); }, c);
                                pEl.getById('div-transaction').on('click', function(){ $om.viewport.fireEvent('click_transaction', c); }, c);
                                pEl.getById('div-balance').on('click', function(){ $om.viewport.fireEvent('click_balance', c); }, c);
                                pEl.getById('div-rtransaction').on('click', function(){ $om.viewport.fireEvent('click_rtransaction', c); }, c);
                                pEl.getById('div-rbalance').on('click', function(){ $om.viewport.fireEvent('click_rbalance', c); }, c);
                                //Sales Tab
                                pEl.getById('div-sales-project').on('click', function(){ $om.viewport.fireEvent('click_project', c); }, c);
                                pEl.getById('div-sales-quotation').on('click', function(){ $om.viewport.fireEvent('click_quotation', c); }, c);
                                pEl.getById('div-sales-saleorder2').on('click', function(){ $om.viewport.fireEvent('click_saleorder', c); }, c);
                                pEl.getById('div-sales-saleorder3').on('click', function(){ $om.viewport.fireEvent('click_saleorder', c); }, c);
                                pEl.getById('div-sales-invoice2').on('click', function(){ $om.viewport.fireEvent('click_invoice', c); }, c);
                                pEl.getById('div-sales-invoice3').on('click', function(){ $om.viewport.fireEvent('click_invoice', c); }, c);
                                pEl.getById('div-sales-billto2').on('click', function(){ $om.viewport.fireEvent('click_billto', c); }, c);
                                pEl.getById('div-sales-receipt2').on('click', function(){ $om.viewport.fireEvent('click_receipt', c); }, c);
                                pEl.getById('div-sales-receipt3').on('click', function(){ $om.viewport.fireEvent('click_receipt', c); }, c);
                                pEl.getById('div-sales-deposit1').on('click', function(){ $om.viewport.fireEvent('click_deposit1', c); }, c);
                                //Purchase Tab
                                pEl.getById('div-purchase-pr2').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
                                pEl.getById('div-purchase-po2').on('click', function(){ $om.viewport.fireEvent('click_po', c); }, c);
                                pEl.getById('div-purchase-gr2').on('click', function(){ $om.viewport.fireEvent('click_gr', c); }, c);
                                pEl.getById('div-purchase-gr3').on('click', function(){ $om.viewport.fireEvent('click_gr', c); }, c);
                                pEl.getById('div-purchase-ap2').on('click', function(){ $om.viewport.fireEvent('click_ap', c); }, c);
                                pEl.getById('div-purchase-ap3').on('click', function(){ $om.viewport.fireEvent('click_ap', c); }, c);
                                pEl.getById('div-purchase-billfrom2').on('click', function(){ $om.viewport.fireEvent('click_billfrom', c); }, c);
                                pEl.getById('div-purchase-payment2').on('click', function(){ $om.viewport.fireEvent('click_payment', c); }, c);
                                pEl.getById('div-purchase-payment3').on('click', function(){ $om.viewport.fireEvent('click_payment', c); }, c);
                                pEl.getById('div-purchase-deposit21').on('click', function(){ $om.viewport.fireEvent('click_deposit2', c); }, c);
							}
						}
					}
				]
			});

			var changeCenterView = function(tab){
				var cEl = centerPanel.getEl(),
					homeCtnr = cEl.getById('home-container'),
					salesCtnr = cEl.getById('sales-container'),
					purchCtnr = cEl.getById('purchase-container'),
					accountCtnr = cEl.getById('account-container'),
					matCtnr = cEl.getById('material-container'),
					configCtnr = cEl.getById('config-container'),
					reportsCtnr = cEl.getById('reports-container');

				homeCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				salesCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				purchCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				accountCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				matCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				configCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				reportsCtnr.setVisibilityMode(Ext.Element.DISPLAY);

				homeCtnr.hide();
				salesCtnr.hide();
				purchCtnr.hide();
				accountCtnr.hide();
				matCtnr.hide();
				configCtnr.hide();
				reportsCtnr.hide();

				switch(tab.title){
					case 'Home': homeCtnr.show(); break;
					case 'Sales': salesCtnr.show(); break;
					case 'Purchases': purchCtnr.show(); break;
					case 'Accounts': accountCtnr.show(); break;
					case 'Materials': matCtnr.show(); break;
					case 'Configuration': configCtnr.show(); break;
					case 'Reports': reportsCtnr.show(); break;
					default: homeCtnr.show();
				}
			};

			var lblUserName = Ext.create('Ext.form.Label', {
				id:'lblUserName-default',
				// width:200,
				text:'<?= XUMS::DISPLAYNAME() ?>'
			});

			var btnLogout = Ext.create('Ext.Button', {
				text: 'Logout',
	            scale: 'large',
	            iconAlign: 'top',
	            iconCls: 'g-logout',
	            handler: function(){
	            	location.href = __site_url+'ums/do_logout';
	            }
			});

// NORTH PANEL Menu
			var tabs = Ext.widget('tabpanel', {
				region:'north',
		        activeTab: 0,
		        border:false,
		        //width: 600,
		        //: 250,
		        plain: true,
		        items: [{
		                title: 'Home',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [{
				            text: 'Sale Orders',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-sale',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Invoices',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-invoice',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Receipts',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-receipt',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Purchase Orders',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-po',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Goods Receipts',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-gr',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Acc-Payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-ap',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Payments',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-pay',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Journal',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-journal',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-report',
                			cls: 'x-btn-as-arrow'
				        },
				        '->', lblUserName, '-', btnLogout]
		            },{
		                title: 'Sales',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [
		                {
				            text: 'Projects',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-proj',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Quotations',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-quot',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Deposit In',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-dep',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Sale Orders',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-sale',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Invoices',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-inv',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Bill to Cust',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-billto',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Receipts',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-recp',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-report',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Customer',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-cust',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Sale Person',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-sman',
                			cls: 'x-btn-as-arrow'
				        }]
		            },{
		                title: 'Purchases',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [{
				            text: 'Purchase Req',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-pr',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Purchase Orders',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-po',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Deposit Out',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-dep',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Goods Receipts',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-gr',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Acc-Payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-ap',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Bill from Vendor',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-billfr',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Payments',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-pay',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-report',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Vendor',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-vend',
                			cls: 'x-btn-as-arrow'
				        }]
		            },{
		                title: 'Accounts',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [{
				            text: 'Income Statement',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-income',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Journal Template',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-journalt',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Journals',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-journal',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Manage Cost Center',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-managec',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Chart of Account',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-charta',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Fixed Asset Register',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-fixasset',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Depreciation&Amortization',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-deprec',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Report',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-report',
                			cls: 'x-btn-as-arrow'
				        }]
		            },{
		                title: 'Materials',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [{
				            text: 'Inventory Transactions',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-inv-trans',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Inventory Balances',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-inv-balance',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Inventories Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-inv-master',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Services Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-ser-master',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Other Incomes',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-oth-income',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Other Expenses',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-oth-expense',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-report',
                			cls: 'x-btn-as-arrow'
				        }]
		            },{
		                title: 'Configuration',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [{
				            text: 'Company Define',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-comp',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Initial Doc No',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-init',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'User Define',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-user',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Autorize Setting',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-auth',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Employee',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-empl',
                			cls: 'x-btn-as-arrow'
				        }]
		            },{
		                title: 'Reports',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [{
				            text: 'Reports1',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report1',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports2',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report2',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports3',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report3',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports4',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report4',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports5',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report5',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports6',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report6',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports7',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report7',
                			cls: 'x-btn-as-arrow'
				        }]
		            }
		        ]
		    });

			////////////////////////////////////////////
			// VIEWPORT
			$om.viewport = Ext.create('Ext.Viewport', {
				layout: {
					type: 'border',
					padding: 5
				},
				defaults: {
					split: true
				},
				items: [
					centerPanel,
					tabs
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
	<?=$view?>
</body>
</html>

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

	<?php if(ENVIRONMENT=='production' || ENVIRONMENT=='testing'): ?>
	<script type="text/javascript" src="<?= base_url('assets/jsdeploy/all-base.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/jsdeploy/all-js.js') ?>"></script>
	<?php endif; ?>

	<script type="text/javascript">
		var __base_url = '<?= base_url() ?>',
			__site_url = '<?= endsWith(site_url(), '/')?site_url().'' : site_url().'/' ?>',
			__user_state = <?= json_encode($USER_PERMISSIONS) ?>;

		<?php if(ENVIRONMENT=='development'): ?>
		Ext.Loader.setConfig({
			enabled: true,
			paths: {
				'BASE': __base_url+'assets/ext_base',
				'Account': __base_url+'assets/js'
			}
		});
		<?php endif; ?>

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
		#div-chart-account { top:30px; left:530px; width: 100px; height:100px; }
		#div-journaltemp { top:30px; left:640px; width: 100px; height:100px; }
		#div-journal { top:140px; left:530px; width: 210px; height:100px; }
		#div-other-income { top:250px; left:530px; width: 100px; height:100px; }
		#div-other-expense { position:absolute; top:250px; left:640px; width: 100px; height:100px; }
		#div-asset-master { top:360px; left:530px; width: 100px; height:100px; }
		#div-asset-regist { position:absolute; top:360px; left:640px; width: 100px; height:100px; }

		#div-rjournal { position:absolute; top:510px; left:530px; width: 100px; height:100px; }
		#div-rgl { position:absolute; top:510px; left:640px; width: 100px; height:100px; }
		#div-rar-aging { position:absolute; top:620px; left:530px; width: 100px; height:100px; }
		#div-rap-aging { position:absolute; top:620px; left:640px; width: 100px; height:100px; }

		#div-account-income2 { top:30px; left:150px; width: 100px; height:100px; }
		#div-account-journaltemp2 { top:30px; left:260px; width: 100px; height:100px; }
		#div-account-journal2 { top:140px; left:150px; width: 210px; height:100px; }
		#div-account-manage-costcenter2 { top:250px; left:150px; width: 100px; height:100px; }
		#div-account-chart-account2 { position:absolute; top:250px; left:260px; width: 100px; height:100px; }
		#div-account-asset-regist2 { top:360px; left:150px; width: 100px; height:100px; }
		#div-account-asset-master2 { position:absolute; top:360px; left:260px; width: 100px; height:100px; }

		#div-account-rjournal2 { position:absolute; top:510px; left:150px; width: 100px; height:100px; }
		#div-account-rgl2 { position:absolute; top:510px; left:260px; width: 100px; height:100px; }
		#div-account-rar-aging2 { position:absolute; top:620px; left:150px; width: 100px; height:100px; }
		#div-account-rap-aging2 { position:absolute; top:620px; left:260px; width: 100px; height:100px; }

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

		#div1-5-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-5-container div span { position:absolute; bottom:10px; left:10px; }
		#div-project-management

		#div-material-transaction2 { top:30px; left:150px; width: 100px; height:100px; }
		#div-material-balance2 { top:30px; left:260px; width: 100px; height:100px; }
		#div-material-material2 { top:140px; left:150px; width: 100px; height:100px; }
		#div-material-service2 { top:140px; left:260px; width: 100px; height:100px; }
		#div-material-otincome2 { top:250px; left:150px; width: 100px; height:100px; }
		#div-material-otexpense2 { top:250px; left:260px; width: 100px; height:100px; }

		#div-material-rtransaction2 { position:absolute; top:400px; left:150px; width: 100px; height:100px; }
		#div-material-rbalance2 { position:absolute; top:400px; left:260px; width: 100px; height:100px; }

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
		//requires: ['*'];
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
				leaf: true,
				id: 'click_project'
			};
			var nodeQuotation = {
				text: 'Create New Quotations',
				leaf: true,
				id: 'click_quotation'
			};
			var nodeDepositReceipt = {
				text: 'Create New Deposit Reciepts',
				leaf: true,
				id: 'click_deposit1'
			};
			var nodeSaleOrder = {
				text: 'Create New Sale Orders',
				leaf: true,
				id: 'click_saleorder'
			};
			var nodeInvoice = {
				text: 'Create New Invoices',
				leaf: true,
				id: 'click_invoice'
			};
			var nodeSaleDN = {
				text: 'Create New Debit Notes',
				leaf: true,
				id: 'click_sale_dn'
			};
			var nodeSaleCN = {
				text: 'Create New Credit Notes',
				leaf: true,
				id: 'click_sale_cn'
			};
			var nodeReceipt = {
				text: 'Create New Receipts',
				leaf: true,
				id: 'click_receipt'
			};
			var nodeCustomer = {
				text: 'Create New Customers',
				leaf: true,
				id: 'click_customer'
			};
			var nodeSalePerson = {
				text: 'Create New Salesperson',
				leaf: true,
				id: 'click_saleperson'
			};

			var groupSale = {
				text: 'Sales',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				id : 'groupSale',
				children: [
					nodeProject,
					nodeQuotation,
					nodeDepositReceipt,
					nodeSaleOrder,
					nodeInvoice,
					nodeSaleDN,
					nodeSaleCN,
					nodeReceipt,
					nodeCustomer,
					nodeSalePerson
				]
			};

			var nodePR = {
				text: 'Create New Purchase Requisitions',
				leaf: true,
				id: 'click_pr'
			};
			var nodePO = {
				text: 'Create New Purchase Orders',
				leaf: true,
				id: 'click_po'
			};
			var nodeDepositPayment = {
				text: 'Create New Deposit Payments',
				leaf: true,
				id: 'click_deposit2'
			};
			var nodeGR = {
				text: 'Create New Goods Receipts',
				leaf: true,
				id: 'click_gr'
			};
			var nodeAP = {
				text: 'Create New Accounting Payables',
				leaf: true,
				id: 'click_ap'
			};
			var nodePurchaseDN = {
				text: 'Create New Debit Notes',
				leaf: true,
				id: 'click_purchase_dn'
			};
			var nodePurchaseCN = {
				text: 'Create New Credit Notes',
				leaf: true,
				id: 'click_purchase_cn'
			};
			var nodePayment = {
				text: 'Create New Payments',
				leaf: true,
				id: 'click_payment'
			};
			var nodeVendor = {
				text: 'Create New Vendors',
				leaf: true,
				id: 'click_vendor'
			};

			var groupPurchase = {
				text: 'Purchases',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				id: 'groupPurchase',
				children: [
					nodePR,
					nodePO,
					nodeDepositPayment,
					nodeGR,
					nodeAP,
					nodePurchaseDN,
					nodePurchaseCN,
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
				leaf: true,
				id: 'click_journaltemp'
			};
			var nodeJournal = {
				text: 'Create New Journals',
				leaf: true,
				id: 'click_journal'
			};
			//var nodeBudget = {
			//	text: 'Create New Manage Bugets',
			//	leaf: true
			//};
			var nodeAccChart = {
				text: 'Chart of Accounting',
				leaf: true,
				id: 'click_chart_account'
			};
				var nodeRSumVat = {
					text: 'รายงานภาษีมูลค่าเพิ่ม (ภ.พ. 30)',
					leaf: true,
					id : 'click_RSumVat'
				};
				var nodeRpp30Vat = {
					text: 'ฟอร์มนำส่ง ภ.พ. 30',
					leaf: true,
					id : 'click_Rpp30Vat'
				};
				var nodeRpnd1WHT = {
					text: 'รายงานภาษีหัก ณ ที่จ่าย (ภ.ง.ด. 1)',
					leaf: true,
					id : 'click_Rpnd1WHT'
				};
				var nodeRpnd3WHT = {
					text: 'รายงานภาษีหัก ณ ที่จ่าย (ภ.ง.ด. 3)',
					leaf: true,
					id : 'click_Rpnd3WHT'
				};
				var nodeRpnd50WHT = {
					text: 'หนังสือรับรองการหักภาษี หัก ณ ที่จ่าย (50 ทวิ)',
					leaf: true,
					id : 'click_Rpnd50WHT'
				};
				var nodeRpnd53WHT = {
					text: 'รายงานภาษีหัก ณ ที่จ่าย (ภ.ง.ด. 53)',
					leaf: true,
					id : 'click_Rpnd53WHT'
				};
			var grouprAccount = {
				text: 'Accounting Reports',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				id: 'grouprAccount',
				children: [
					nodeRSumVat,
					nodeRpp30Vat,
					nodeRpnd1WHT,
					nodeRpnd3WHT,
					nodeRpnd50WHT,
					nodeRpnd53WHT
				]
			};

			var groupAccount = {
				text: 'Accounting',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				id: 'groupAccount',
				children: [
					//nodeIncome,
					nodeJTemplate,
					nodeJournal,
					//nodeBudget,
					nodeAccChart,
					grouprAccount
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
				leaf: true,
				id: 'click_material'
			};
			var nodeService = {
				text: 'Create New Services',
				leaf: true,
				id: 'click_service'
			};

			var groupMaterial = {
				text: 'Material Management',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				id: 'groupMaterial',
				children: [
					nodeTrans,
					nodeBalances,
					nodeOtherIn,
					nodeOtherEx,
					nodeMaterial,
					nodeService
				]
			};

			var nodeARLedger = {
				text: 'AR Ledger',
				leaf: true
			};
			var nodeARAging = {
				text: 'AR Aging',
				leaf: true
			};
			var nodeAPLedger = {
				text: 'AP Ledger',
				leaf: true
			};
			var nodeAPAging = {
				text: 'AP Aging',
				leaf: true
			};
			var nodeReportGJ = {
				text: 'Journal Reports',
				leaf: true,
				id: 'click_report_gr'
			};
			var nodeReportPJ = {
				text: 'Petty Cash Journal Report',
				leaf: true,
				id: 'click_report_pj'
			};
			var nodeReportSJ = {
				text: 'Sale Journal Report',
				leaf: true,
				id: 'click_report_sj'
			};
			var nodeReportGL = {
				text: 'General Ledger Report',
				leaf: true,
				id: 'click_report_gl'
			};

			var nodeReportTB = {
				text: 'Trial Balance Report',
				leaf: true,
				id: 'click_report_tb'
			};

			var nodeReportIncome = {
				text: 'Income Statement Report',
				leaf: true,
				id: 'click_report_income'
			};

			var nodeReportBalanceSheet = {
				text: 'Balance Sheet Report',
				leaf: true,
				id: 'click_report_balance_sheet'
			};

			var groupReport = {
				text: 'Reports',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				id: 'groupReport',
				children: [
					nodeARLedger,
					nodeARAging,
					nodeAPLedger,
					nodeAPAging,
					nodeReportPJ,
					nodeReportSJ,
					nodeReportGL,
					nodeReportTB,
					nodeReportIncome,
					nodeReportBalanceSheet
				]
			};

            var nodeCompany = {
				text: 'Company Define',
				leaf: true,
				id: 'click_company_setting'
			};
			var nodeInit = {
				text: 'Initail Doc No.',
				leaf: true,
				id: 'click_config'
			};
			var nodeLimit = {
				text: 'Limitation Setting',
				leaf: true,
				id: 'click_limitation_setting'
			};
			var nodeAuth = {
				text: 'Authorize Setting',
				leaf: true,
				id: 'click_authorize_setting'
			};
			var nodeChart = {
				text: 'Chart of Accounting',
				leaf: true,
				id: 'click_chart_account'
			};
			var nodeEmployee = {
				text: 'Employee master',
				leaf: true,
				id: 'click_employee'
			};
			var nodeBankname = {
				text: 'Bank master',
				leaf: true,
				id: 'click_bankname_setting'
			};

			var groupConfig = {
				text: 'Configuration',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				id: 'groupConfig',
				children: [
				    nodeCompany,
				    nodeInit,
				    nodeLimit,
				    nodeAuth,
					nodeChart,
					nodeEmployee,
					nodeBankname
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
				id: 'tree',
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

			tree.on('itemclick', function(tree, record, item){
				$om.viewport.fireEvent(record.data.id);
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
								'</div>',
								//Purchase Module
								'<div id="div1-2-container">',
									'<div id="div-pr" class="box box-red"><span>Purchase Requisitions</span></div>',
									'<div id="div-po" class="box box-red"><span>Purchase Orders</span></div>',
									'<div id="div-gr" class="box box-red"><span>Goods Receipts</span></div>',
									'<div id="div-vendor" class="box box-red"><span>Vendors</span></div>',
									'<div id="div-ap" class="box box-red"><span>Accounting Payable</span></div>',
									'<div id="div-apxx" style="visibility:hidden;" class="box box-red"><span>Accounting Payable</span></div>',
									'<div id="div-payment" class="box box-red"><span>Payments</span></div>',
									'<div id="div-deposit2" class="box box-red"><span>Deposit Payments</span></div>',
									'<div id="div-billfrom" class="box box-red"><span>Billing Receipts</span></div>',

									'<div id="div-rap" class="box box-orange"><span>AP Report</span></div>',
									'<div id="div-rpayment" class="box box-orange"><span>Payment Report</span></div>',
								'</div>',
								//Account Module
								'<div id="div1-3-container">',
									'<div id="div-other-income" class="box box-blue"><span>Other Incomes</span></div>',
									'<div id="div-other-expense" class="box box-blue"><span>Other Expenses</span></div>',
									'<div id="div-journaltemp" class="box box-blue"><span>Journal Template</span></div>',
									'<div id="div-journal" class="box box-blue"><span>Journals</span></div>',
									'<div id="div-chart-account" class="box box-blue"><span>Chart of Accounting</span></div>',
									'<div id="div-asset-regist" class="box box-blue"><span>Fixed Asset Register</span></div>',
									'<div id="div-asset-master" class="box box-blue"><span>Fixed Asset Master</span></div>',

									'<div id="div-rjournal" class="box box-orange"><span>Journal Report</span></div>',
									'<div id="div-rgl" class="box box-orange"><span>GL Report</span></div>',
									'<div id="div-rar-aging" class="box box-orange"><span>AR Aging Report</span></div>',
									'<div id="div-rap-aging" class="box box-orange"><span>AP Aging Report</span></div>',
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
									'<div id="div-purchase-ap2" class="box box-red"><span>Accounting Payables</span></div>',
									'<div id="div-purchase-ap3" class="box box-red"><span>Create New Accounting Payable</span></div>',
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
									'<div id="div-account-journal2" class="box box-blue"><span>Journals</span></div>',
									'<div id="div-account-manage-costcenter2" class="box box-blue"><span>Manage Cost Center</span></div>',
									'<div id="div-account-chart-account2" class="box box-blue"><span>Chart of Accounting</span></div>',
									'<div id="div-account-asset-regist2" class="box box-blue"><span>Fixed Asset Register</span></div>',
									'<div id="div-account-asset-master2" class="box box-blue"><span>Fixed Asset Master</span></div>',

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

									'<div id="div-material-rtransaction2" class="box box-orange"><span>Transaction Report</span></div>',
									'<div id="div-material-rbalance2" class="box box-orange"><span>Balance Report</span></div>',
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

								pEl.getById('div-other-income').on('click', function(){ $om.viewport.fireEvent('click_income', c); }, c);
								pEl.getById('div-other-expense').on('click', function(){ $om.viewport.fireEvent('click_expense', c); }, c);
								pEl.getById('div-journaltemp').on('click', function(){ $om.viewport.fireEvent('click_journaltemp', c); }, c);
								pEl.getById('div-journal').on('click', function(){ $om.viewport.fireEvent('click_journal', c); }, c);
								pEl.getById('div-asset-regist').on('click', function(){ $om.viewport.fireEvent('click_asset-regist', c); }, c);
								pEl.getById('div-asset-master').on('click', function(){ $om.viewport.fireEvent('click_asset-master', c); }, c);

                                pEl.getById('div-rjournal').on('click', function(){ $om.viewport.fireEvent('click_rjournal', c); }, c);
								pEl.getById('div-rgl').on('click', function(){ $om.viewport.fireEvent('click_rgl', c); }, c);
								pEl.getById('div-rar-aging').on('click', function(){ $om.viewport.fireEvent('click_rar-aging', c); }, c);
								pEl.getById('div-rap-aging').on('click', function(){ $om.viewport.fireEvent('click_rap-aging', c); }, c);
								pEl.getById('div-chart-account').on('click', function(){ $om.viewport.fireEvent('click_chart_account', c); }, c);
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
                                //Material Tab
                                //pEl.getById('div-material-transaction2').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
                                //pEl.getById('div-material-balance2').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
                                //pEl.getById('div-material-otincome2').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
                                //pEl.getById('div-material-otexpense2').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
                                pEl.getById('div-material-material2').on('click', function(){ $om.viewport.fireEvent('click_material', c); }, c);
                                pEl.getById('div-material-service2').on('click', function(){ $om.viewport.fireEvent('click_service', c); }, c);
                                //pEl.getById('div-material-rtransaction2').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
                                //pEl.getById('div-material-rbalance2').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
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
					case 'Accounting': accountCtnr.show(); break;
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_saleorder')}
				        },{
				            text: 'Invoices',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-invoice',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_invoice')}
				        },{
				            text: 'Receipts',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-receipt',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_receipt')}
				        },{
				            text: 'Purchase Orders',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-po',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_po')}
				        },{
				            text: 'Goods Receipts',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-gr',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_gr')}
				        },{
				            text: 'Acc-Payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-ap',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_ap')}
				        },{
				            text: 'Payments',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-pay',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_payment')}
				        },{
				            text: 'Journals',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-journal',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_journal')}
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_project')}
				        },{
				            text: 'Quotations',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-quot',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_quotation')}
				        },{
				            text: 'Deposit In',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-dep',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_deposit1')}
				        },{
				            text: 'Sale Orders',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-sale',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_saleorder')}
				        },{
				            text: 'Invoices',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-inv',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_invoice')}
				        },{
				            text: 'Bill to Cust',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-billto',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_billto')}
				        },{
				            text: 'Receipts',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-recp',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_receipt')}
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_customer')}
				        },{
				            text: 'Sale Person',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-sman',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_saleperson')}
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_pr')}
				        },{
				            text: 'Purchase Orders',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-po',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_po')}
				        },{
				            text: 'Deposit Out',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-dep',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_deposit2')}
				        },{
				            text: 'Goods Receipts',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-gr',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_gr')}
				        },{
				            text: 'Acc-Payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-ap',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_ap')}
				        },{
				            text: 'Bill from Vendor',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-billfr',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_billfrom')}
				        },{
				            text: 'Payments',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-pay',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_payment')}
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_vendor')}
				        }]
		            },{
		                title: 'Accounting',
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_journalt')}
				        },{
				            text: 'Journals',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-journal',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_journal')}
				        },{
				            text: 'Manage Cost Center',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-managec',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Chart of Accounting',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-charta',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_chart_account')}
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
				            text: 'Materials Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-inv-master',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_material')}
				        },{
				            text: 'Services Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-ser-master',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_service')}
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_config')}
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_employee')}
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
				]
			});
		});
	</script>
	<?=$view?>
</body>
</html>

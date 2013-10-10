<?php
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
			__site_url = '<?= endsWith(site_url(), '/')?site_url().'' : site_url().'/' ?>';
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
		#div-project { top:30px; left:30px; width: 210px; height:100px; }
		#div-quotation { top:160px; left:30px; width: 90px; height:90px; }
		#div-customer { top:160px; left:150px; width: 90px; height:90px; }
		#div-saleorder { top:280px; left:30px; width: 90px; height:90px; }
		#div-invoice { top:280px; left:150px; width: 90px; height:90px; }
		#div-receipt { top:400px; left:30px; width: 90px; height:90px; }
		#div-billto { top:400px; left:150px; width: 90px; height:90px; }

		#div-rproject { position:absolute; top:510px; left:30px; width: 100px; height:100px; }
		#div-rquotation { position:absolute; top:510px; left:140px; width: 100px; height:100px; }
		#div-rinvoice { position:absolute; top:620px; left:30px; width: 100px; height:100px; }
		#div-rreceipt { position:absolute; top:620px; left:140px; width: 100px; height:100px; }
		#div-config { position:absolute; top:730px; left:30px; width: 210px; height:100px; }

		#div1-2-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-2-container div span { position:absolute; bottom:10px; left:10px; }
		#div-pr { top:30px; left:280px; width: 210px; height:100px; }
		#div-po { top:160px; left:280px; width: 90px; height:90px; }
		#div-vendor { top:160px; left:400px; width: 90px; height:90px; }
		#div-gr { top:280px; left:280px; width: 90px; height:90px; }
		#div-ap { top:280px; left:400px; width: 90px; height:90px; }
		#div-payment { top:400px; left:280px; width: 90px; height:90px; }
		#div-billfrom { top:400px; left:400px; width: 90px; height:90px; }

		#div-rpr { position:absolute; top:510px; left:280px; width: 100px; height:100px; }
		#div-rpo { position:absolute; top:510px; left:390px; width: 100px; height:100px; }
		#div-rgr { position:absolute; top:620px; left:280px; width: 100px; height:100px; }
		#div-rap { position:absolute; top:620px; left:390px; width: 100px; height:100px; }
		#div-rpayment { position:absolute; top:730px; left:280px; width: 100px; height:100px; }


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

		/* Toolbar */
		.h-invoice { background-image: url('assets/images/tb-icons/document_add.png') !important; }
		.h-reciept { background-image: url('assets/images/tb-icons/document_into.png') !important; }
		.h-journal { background-image: url('assets/images/tb-icons/document_notebook.png') !important; }
		.h-report { background-image: url('assets/images/tb-icons/document_chart.png') !important; }

		.s-quot { background-image: url('assets/images/tb-icons/document_connection.png') !important; }
		.s-sale { background-image: url('assets/images/tb-icons/document_certificate.png') !important; }
		.b-pay { background-image: url('assets/images/tb-icons/money_envelope.png') !important; }

		/* Arrow */
		.arrow { width:11px; border:0px solid #f00; position:absolute; background:#014051 url('<?= base_url('assets/images/arrow/arrow-line.gif') ?>') repeat-y center center; }
		.arrow-down span { display:block; width:11px; height:6px; position:absolute; bottom:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-down.gif') ?>') repeat-y center center;
		}
		.arrow-up span { display:block; width:11px; height:6px; position:absolute; top:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-up.gif') ?>') repeat-y center center;
		}
		#arrow-01 { height:30px; top:130px; left:71px; }
		#arrow-02 { height:30px; top:130px; left:190px; }
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

			var groupNodeTodo = {
				text: 'TO-DO',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeTutorials,
					nodeSetup
				]
			};

			/*var nodeMakePayment = {
				text: 'Make a Payment',
				leaf: true
			};
			var nodeRecievePayment = {
				text: 'Recieve a Payment',
				leaf: true
			};

			var groupTransaction = {
				text: 'Transactions',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeMakePayment,
					nodeRecievePayment
				]
			};*/

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
					nodeCustomer
				]
			};

			var nodePR = {
				text: 'Create New Purcharse Requisitons',
				leaf: true
			};
			var nodePO = {
				text: 'Create New Purcharse Orders',
				leaf: true
			};
			var nodeGR = {
				text: 'Create New Goods Recieves',
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
			
			var nodeIncome = {
				text: 'Create New Income Statements',
				leaf: true
			};
			var nodeJTemplate = {
				text: 'Create New Journal Templates',
				leaf: true
			};
			var nodeJournal = {
				text: 'Create New Journals',
				leaf: true
			};
			var nodeBudget = {
				text: 'Create New Manage Bugets',
				leaf: true
			};
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
					nodeIncome,
					nodeJTemplate,
					nodeJournal,
					nodeBudget,
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
					nodeMaterial
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
					nodeReport3
				]
			};

			var nodeChart = {
				text: 'Chart of Accounts',
				leaf: true
			};
			var nodeOption = {
				text: 'Options',
				leaf: true
			};
			var groupConfig = {
				text: 'Configuration',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeChart,
					nodeOption
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
						html : [//Sale Module
								'<div id="div1-1-container">',
									'<div id="div-project" class="box box-green"><span>Create New Projects</span></div>',
									'<div id="div-quotation" class="box box-green"><span>Quotations</span></div>',
									'<div id="div-saleorder" class="box box-green"><span>Sale Orders</span></div>',
									'<div id="div-invoice" class="box box-green"><span>Invoices</span></div>',
									'<div id="div-billto" class="box box-green"><span>Bill to Customers</span></div>',
									'<div id="div-receipt" class="box box-green"><span>Receipt</span></div>',
									'<div id="div-customer" class="box box-green"><span>Customers</span></div>',

									'<div id="div-rproject" class="box box-orange"><span>Projects Report</span></div>',
									'<div id="div-rquotation" class="box box-orange"><span>Quotations Report</span></div>',
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
									'<div id="div-payment" class="box box-red"><span>Payment</span></div>',
									'<div id="div-billfrom" class="box box-red"><span>Bill from Vendors</span></div>',

									'<div id="div-rpr" class="box box-orange"><span>PR Report</span></div>',
									'<div id="div-rpo" class="box box-orange"><span>PO Report</span></div>',
									'<div id="div-rgr" class="box box-orange"><span>GR Report</span></div>',
									'<div id="div-rap" class="box box-orange"><span>AP Report</span></div>',
									'<div id="div-rpayment" class="box box-orange"><span>Payment Report</span></div>',
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
									'<div id="div-material" class="box box-purple"><span>Inventories Master</span></div>',
									'<div id="div-service" class="box box-purple"><span>Services Master</span></div>',

									'<div id="div-rtransaction" class="box box-orange"><span>Transaction Report</span></div>',
									'<div id="div-rbalance" class="box box-orange"><span>Balance Report</span></div>',
								'</div>',
								// arrow
								'<div id="arrow-01" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-02" class="arrow arrow-up"><span></span></div>'
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
								//Sales Module
								pEl.getById('div-project').on('click', function(){ $om.viewport.fireEvent('click_project', c); }, c);
								pEl.getById('div-quotation').on('click', function(){ $om.viewport.fireEvent('click_quotation', c); }, c);
								pEl.getById('div-invoice').on('click', function(){ $om.viewport.fireEvent('click_invoice', c); }, c);
								pEl.getById('div-receipt').on('click', function(){ $om.viewport.fireEvent('click_receipt', c); }, c);
								pEl.getById('div-customer').on('click', function(){ $om.viewport.fireEvent('click_customer', c); }, c);
								pEl.getById('div-saleorder').on('click', function(){ $om.viewport.fireEvent('click_saleorder', c); }, c);
								pEl.getById('div-billto').on('click', function(){ $om.viewport.fireEvent('click_billto', c); }, c);

								pEl.getById('div-rproject').on('click', function(){ $om.viewport.fireEvent('click_rproject', c); }, c);
								pEl.getById('div-rquotation').on('click', function(){ $om.viewport.fireEvent('click_rquotation', c); }, c);
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

								pEl.getById('div-rpo').on('click', function(){ $om.viewport.fireEvent('click_rpo', c); }, c);
								pEl.getById('div-rpr').on('click', function(){ $om.viewport.fireEvent('click_rpr', c); }, c);
								pEl.getById('div-rgr').on('click', function(){ $om.viewport.fireEvent('click_rgr', c); }, c);
								pEl.getById('div-rap').on('click', function(){ $om.viewport.fireEvent('click_rap', c); }, c);
								pEl.getById('div-rpayment').on('click', function(){ $om.viewport.fireEvent('click_rpayment', c); }, c);
								//Material Module
								pEl.getById('div-material').on('click', function(){ $om.viewport.fireEvent('click_material', c); }, c);
								pEl.getById('div-otincome').on('click', function(){ $om.viewport.fireEvent('click_otincome', c); }, c);
                                pEl.getById('div-otexpense').on('click', function(){ $om.viewport.fireEvent('click_otexpense', c); }, c);
                                pEl.getById('div-transaction').on('click', function(){ $om.viewport.fireEvent('click_transaction', c); }, c);
                                pEl.getById('div-balance').on('click', function(){ $om.viewport.fireEvent('click_balance', c); }, c);
                                pEl.getById('div-rtransaction').on('click', function(){ $om.viewport.fireEvent('click_rtransaction', c); }, c);
                                pEl.getById('div-rbalance').on('click', function(){ $om.viewport.fireEvent('click_rbalance', c); }, c);
							}
						}
					}
				]
			});

			// NORTH PANEL
			var tabs = Ext.widget('tabpanel', {
				region:'north',
		        activeTab: 0,
		        border:false,
		        //width: 600,
		        //: 250,
		        plain: true,
		        items: [{
		                title: 'Home',
		                tbar: [{
				            text: 'Invoice',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-invoice',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reciept',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-reciept',
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
				        }]
		            },{
		                title: 'Sales',
		                tbar: [{
				            text: 'Invoice',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-invoice',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reciept',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-reciept',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Quot',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-quot',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Sales',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-sale',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Reports',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-report',
                			cls: 'x-btn-as-arrow'
				        }]
		            },{
		                title: 'Purchases',
		                tbar: [{
				            text: 'Payment',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-invoice',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Enter Payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-reciept',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Pay payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'b-pay',
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
				        }]
		            },{
		                title: 'Materials',
		                tbar: [{
				            text: 'Payment',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-invoice',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Enter Payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-reciept',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Pay payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'b-pay',
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
				        }]
		            },{
		                title: 'Reports',
		                tbar: [{
				            text: 'Invoice',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-invoice',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Payment',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-invoice',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Enter Payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-reciept',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Pay payable',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'b-pay',
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
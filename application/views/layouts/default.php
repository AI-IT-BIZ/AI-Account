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
		Ext.form.field.ComboBox.override( {
			setValue: function(v) {
				var _this=this;
				v = (v && v.toString) ? v.toString() : v;
				if(!this.store.isLoaded && this.queryMode == 'remote') {
					this.store.addListener('load', function(store, rs) {
						this.store.isLoaded = true;
						Ext.each(rs, function(o){
							if(o.get(o.idProperty)==v){
								_this.setValue(o);
								return;
							}
						});
					}, this);
				   this.store.load();
				} else {
					this.callOverridden(arguments);
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
		.box-green { background-color:#179c30; }
		.box-green:hover { background-color:#2ba645; }
		.box-red { background-color:#e04444; }
		.box-red:hover { background-color:#de5151; }
		.box-base { background-color:#004d61; }
		.box-base:hover { background-color:#0c6177; }

		#div1-1-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-1-container div span { position:absolute; bottom:10px; left:10px; }
		#div-project { top:30px; left:30px; width: 210px; height:100px; }
		#div-quotation { top:160px; left:30px; width: 90px; height:90px; }
		#div-customer { top:160px; left:150px; width: 90px; height:90px; }
		#div-invoice { top:280px; left:30px; width: 210px; height:100px; }
		#div-rquotation { position:absolute; top:400px; left:30px; width: 100px; height:100px; }
		#div-rinvoice { position:absolute; top:400px; left:140px; width: 100px; height:100px; }
		#div-config { position:absolute; top:620px; left:30px; width: 210px; height:100px; }

		#div1-2-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-2-container div span { position:absolute; bottom:10px; left:10px; }
		#div-pr { top:30px; left:280px; width: 210px; height:100px; }
		#div-po { top:160px; left:280px; width: 90px; height:90px; }
		#div-vendor { top:160px; left:400px; width: 90px; height:90px; }
		#div-gr { top:280px; left:280px; width: 210px; height:100px; }
		#div-rpo { position:absolute; top:400px; left:280px; width: 100px; height:100px; }
		#div-rgr { position:absolute; top:400px; left:390px; width: 100px; height:100px; }

		#div1-3-container { width: 240px; height:500px; color:white; font-weight:bold; }
		#div1-3-container div span { position:absolute; bottom:10px; left:10px; }
		#div-income { top:30px; left:530px; width: 100px; height:100px; }
		#div-journal { top:30px; left:640px; width: 100px; height:100px; }
		#div-balance { top:140px; left:530px; width: 210px; height:100px; }
		#div-manage-budget { top:250px; left:530px; width: 100px; height:100px; }
		#div-chart-account { position:absolute; top:250px; left:640px; width: 100px; height:100px; }

		#div-reconsile { position:absolute; top:400px; left:530px; width: 100px; height:100px; }
		#div-transfer { position:absolute; top:400px; left:640px; width: 100px; height:100px; }

		#div1-4-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-4-container div span { position:absolute; bottom:10px; left:10px; }
		#div-deposit { top:30px; left:780px; width: 100px; height:100px; }
		#div-packing { top:30px; left:890px; width: 100px; height:100px; }
		#div-return { top:140px; left:780px; width: 100px; height:100px; }
		#div-salep { top:140px; left:890px; width: 100px; height:100px; }
		#div-material { top:250px; left:780px; width: 210px; height:100px; }

		#div-trans { position:absolute; top:400px; left:780px; width: 100px; height:100px; }
		#div-mat-balance { position:absolute; top:400px; left:890px; width: 100px; height:100px; }
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
			var nodeInvoice = {
				text: 'Create New Invoices',
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
					nodeInvoice,
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
					nodeVendor
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
			var nodeMaterial = {
				text: 'Create New Materials',
				leaf: true
			};

			var groupMaterial = {
				text: 'Material Master',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeTrans,
					nodeBalances,
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
						//groupTransaction,
						groupSale,
						groupPurchase,
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
				items: [
					tree,
					{
						id:'center-wrap', region:'center',
						layout:'fit', border:false,
						autoScroll: true,
						html : [//Sale Module
								'<div id="div1-1-container">',
									'<div id="div-project" class="box box-green"><span>Create New Projects</span></div>',
									'<div id="div-quotation" class="box box-green"><span>Quotations</span></div>',
									'<div id="div-invoice" class="box box-green"><span>Create New Invoices</span></div>',
									'<div id="div-customer" class="box box-green"><span>Customers</span></div>',

									'<div id="div-rquotation" class="box box-orange"><span>Quotations Report</span></div>',
									'<div id="div-rinvoice" class="box box-orange"><span>Invoices Report</span></div>',
									'<div id="div-config" class="box box-base"><span>Configure BizNet Accounts</span></div>',
								'</div>',
								//Purchase Module
								'<div id="div1-2-container">',
									'<div id="div-pr" class="box box-red"><span>Purchase Requisitions</span></div>',
									'<div id="div-po" class="box box-red"><span>Purchase Orders</span></div>',
									'<div id="div-gr" class="box box-red"><span>Create New Goods Receipts</span></div>',
									'<div id="div-vendor" class="box box-red"><span>Vendors</span></div>',

									'<div id="div-rpo" class="box box-orange"><span>PO Report</span></div>',
									'<div id="div-rgr" class="box box-orange"><span>GR Report</span></div>',
								'</div>',
								//Account Module
								'<div id="div1-3-container">',
									'<div id="div-income" class="box box-blue"><span>Income Statement</span></div>',
									'<div id="div-journal" class="box box-blue"><span>Journal</span></div>',
									'<div id="div-balance" class="box box-blue"><span>Balance Sheet</span></div>',
									'<div id="div-manage-budget" class="box box-blue"><span>Manage Budget</span></div>',
									'<div id="div-chart-account" class="box box-blue"><span>Chart of Account</span></div>',

									'<div id="div-reconsile" class="box box-orange"><span>Reconsile Account</span></div>',
									'<div id="div-transfer" class="box box-orange"><span>Transfer between account</span></div>',
								'</div>',
								//Sub Module
								'<div id="div1-4-container">',
									'<div id="div-deposit" class="box box-green"><span>Deposit Receipts</span></div>',
									'<div id="div-packing" class="box box-green"><span>Packing Lists</span></div>',
									'<div id="div-return" class="box box-green"><span>Product Returns</span></div>',
									'<div id="div-salep" class="box box-green"><span>Sale Persons</span></div>',
									'<div id="div-material" class="box box-green"><span>Create new Materials</span></div>',

									'<div id="div-trans" class="box box-orange"><span>Material Transactions</span></div>',
									'<div id="div-mat-balance" class="box box-orange"><span>Material Balances</span></div>',
								'</div>'
								].join(''),
						listeners : {
							render : function(c) {
								pEl = c.getEl();

								pEl.getById('div-income').on('click', function(){ $om.viewport.fireEvent('click_income', c); }, c);
								pEl.getById('div-journal').on('click', function(){ $om.viewport.fireEvent('click_journal', c); }, c);

								pEl.getById('div-balance').on('click', function(){ $om.viewport.fireEvent('click_balance', c); }, c);

								pEl.getById('div-customer').on('click', function(){ $om.viewport.fireEvent('click_customer', c); }, c);

								//Sales Module
								pEl.getById('div-project').on('click', function(){ $om.viewport.fireEvent('click_project', c); }, c);
								pEl.getById('div-quotation').on('click', function(){ $om.viewport.fireEvent('click_quotation', c); }, c);
								pEl.getById('div-invoice').on('click', function(){ $om.viewport.fireEvent('click_invoice', c); }, c);
								pEl.getById('div-customer').on('click', function(){ $om.viewport.fireEvent('click_customer', c); }, c);
								
								pEl.getById('div-rquotation').on('click', function(){ $om.viewport.fireEvent('click_rquotation', c); }, c);
								pEl.getById('div-rinvoice').on('click', function(){ $om.viewport.fireEvent('click_rinvoice', c); }, c);
								//Purchases Module
								pEl.getById('div-pr').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
								pEl.getById('div-po').on('click', function(){ $om.viewport.fireEvent('click_po', c); }, c);
								pEl.getById('div-gr').on('click', function(){ $om.viewport.fireEvent('click_gr', c); }, c);
								pEl.getById('div-vendor').on('click', function(){ $om.viewport.fireEvent('click_vendor', c); }, c);
								//Sub Module
								pEl.getById('div-deposit').on('click', function(){ $om.viewport.fireEvent('click_deposit', c); }, c);
								pEl.getById('div-return').on('click', function(){ $om.viewport.fireEvent('click_return', c); }, c);
								pEl.getById('div-material').on('click', function(){ $om.viewport.fireEvent('click_material', c); }, c);
								pEl.getById('div-packing').on('click', function(){ $om.viewport.fireEvent('click_return', c); }, c);
								pEl.getById('div-salep').on('click', function(){ $om.viewport.fireEvent('click_salep', c); }, c);

							}
						}
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
					{
						region: 'north',
						collapsible: true,
						title: 'North',
						//split: true,
						height: 100,
						minHeight: 60,
						html: 'north'
					}
				]
			});
		});
	</script>
	<?=$view?>
</body>
</html>
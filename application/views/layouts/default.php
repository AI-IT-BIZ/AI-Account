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

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/ext/resources/css/ext-all-neptune.css') ?>" />
	<script type="text/javascript" src="<?= base_url('assets/ext/ext-all.js') ?>"></script>
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

		#div1-1-container { width: 240px; height:500px; color:white; font-weight:bold; }
		#div1-1-container div span { position:absolute; bottom:10px; left:10px; }
		#div-income { top:30px; left:30px; width: 100px; height:100px; }
		#div-journal { top:30px; left:140px; width: 100px; height:100px; }
		#div-balance { top:140px; left:30px; width: 210px; height:100px; }
		#div-manage-budget { top:250px; left:30px; width: 100px; height:100px; }
		#div-chart-account { position:absolute; top:250px; left:140px; width: 100px; height:100px; }

		#div-reconsile { position:absolute; top:400px; left:30px; width: 100px; height:100px; }
		#div-transfer { position:absolute; top:400px; left:140px; width: 100px; height:100px; }
	</style>
</head>
<body>
	<script type="text/javascript">
		var $om = {};
		requires: ['*'];
		Ext.onReady(function() {

			// MENU TREE
			var nodeFirstInvoice = {
				text: 'Create first Invoice',
				leaf: true
			};
			var nodeFirstPayment = {
				text: 'Enter your first payment',
				leaf: true
			};

			var groupNodeTodo = {
				text: 'TO-DO',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeFirstInvoice,
					nodeFirstPayment
				]
			};

			var nodeMakePayment = {
				text: 'Make a Payment',
				leaf: true
			};
			var nodeRecievePayment = {
				text: 'Recieve a Payment',
				leaf: true
			};

			var groupTransaction = {
				text: 'Transaction',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeMakePayment,
					nodeRecievePayment
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
						groupTransaction
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
						html : ['<div id="div1-1-container">',
									'<div id="div-income" class="box box-blue"><span>Income Statement</span></div>',
									'<div id="div-journal" class="box box-blue"><span>Journal</span></div>',
									'<div id="div-balance" class="box box-blue"><span>Balance Sheet</span></div>',
									'<div id="div-manage-budget" class="box box-blue"><span>Manage Budget</span></div>',
									'<div id="div-chart-account" class="box box-blue"><span>Chart of Account</span></div>',

									'<div id="div-reconsile" class="box box-orange"><span>Reconsile Account</span></div>',
									'<div id="div-transfer" class="box box-orange"><span>Transfer between account</span></div>',
								'</div>'
								].join(''),
						listeners : {
							render : function(c) {
								pEl = c.getEl();

								pEl.getById('div-income').on('click', function(){ $om.viewport.fireEvent('click_income', c); }, c);
								pEl.getById('div-journal').on('click', function(){ $om.viewport.fireEvent('click_journal', c); }, c);
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
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
	<script type="text/javascript" src="<?= base_url('assets/jsdeploy/all-ux.js') ?>"></script>
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

		//console.log(UMS);//#d34827 4e9af1
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
		.box-blue2 { background-color:#4e9af1; }
		.box-blue2:hover { background-color:#418eff; }
		.box-base { background-color:#004d61; }
		.box-base:hover { background-color:#0c6177; }

		#div1-1-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-1-container div span { position:absolute; bottom:10px; left:10px; }
		#div-project { top:30px; left:30px; width: 210px; height:100px; }
		#div-quotation { top:160px; left:30px; width: 90px; height:90px; }
		#div-customer { top:160px; left:150px; width: 90px; height:90px; }
		#div-deposit1 { top:280px; left:30px; width: 90px; height:90px; }
		#div-saleorder { top:280px; left:150px; width: 90px; height:90px; }
		#div-invoice { top:400px; left:150px; width: 90px; height:90px; }
		#div-billto { top:400px; left:30px; width: 90px; height:90px; }
		#div-receipt { top:520px; left:30px; width: 210px; height:100px; }

		#div-rinvoice { position:absolute; top:630px; left:30px; width: 100px; height:100px; }
		#div-rreceipt { position:absolute; top:630px; left:140px; width: 100px; height:100px; }


		#div-sales-customer { top:30px; left:30px; width: 210px; height:100px; }
		#div-sales-projectnew { top:170px; left:30px; width: 180px; height:90px; }
		#div-sales-projectlist { top:300px; left:30px; width: 180px; height: 90px; }
		#div-sales-qtnew { top:170px; left:250px; width: 180px; height:90px; }
		#div-sales-qtlist { top:300px; left:250px; width: 180px; height: 90px; }
		#div-sales-dpnew { top:170px; left:470px; width: 180px; height:90px; }
		#div-sales-dplist { top:300px; left:470px; width: 180px; height:90px; }
		#div-sales-sonew { top:170px; left:690px; width: 180px; height:90px; }
		#div-sales-solist { top:170px; left:910px; width: 180px; height: 90px; }
		#div-sales-invnew { top:300px; left:690px; width: 180px; height:90px; }
		#div-sales-invlist { top:300px; left:910px; width: 180px; height: 90px; }

        #div-sales-dnnew { top:430px; left:560px; width: 180px; height:90px; }
		#div-sales-dnlist { top:430px; left:370px; width: 150px; height: 90px; }
		#div-sales-cnnew { top:430px; left:810px; width: 180px; height:90px; }
		#div-sales-cnlist { top:430px; left:1030px; width: 150px; height: 90px; }
		#div-sales-recnew { top:560px; left:690px; width: 180px; height:90px; }
		#div-sales-reclist { top:560px; left:910px; width: 180px; height: 90px; }
		#div-sales-rar-ledger { top:560px; left:180px; width: 150px; height:90px; }
		#div-sales-rar-aging { top:560px; left:370px; width: 150px; height: 90px; }

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

		#div-purchase-vendor { top:30px; left:30px; width: 210px; height:100px; }
		#div-purchase-prnew { top:170px; left:30px; width: 180px; height:90px; }
		#div-purchase-prlist { top:300px; left:30px; width: 180px; height: 90px; }
		#div-purchase-ponew { top:170px; left:250px; width: 180px; height:90px; }
		#div-purchase-polist { top:300px; left:250px; width: 180px; height: 90px; }
		#div-purchase-dpnew { top:170px; left:470px; width: 180px; height:90px; }
		#div-purchase-dplist { top:300px; left:470px; width: 180px; height:90px; }
		#div-purchase-grnew { top:170px; left:690px; width: 180px; height:90px; }
		#div-purchase-grlist { top:170px; left:910px; width: 180px; height: 90px; }
		#div-purchase-apnew { top:300px; left:690px; width: 180px; height:90px; }
		#div-purchase-aplist { top:300px; left:910px; width: 180px; height: 90px; }

        #div-purchase-dnnew { top:430px; left:560px; width: 180px; height:90px; }
		#div-purchase-dnlist { top:430px; left:370px; width: 150px; height: 90px; }
		#div-purchase-cnnew { top:430px; left:810px; width: 180px; height:90px; }
		#div-purchase-cnlist { top:430px; left:1030px; width: 150px; height: 90px; }
		#div-purchase-paynew { top:560px; left:690px; width: 180px; height:90px; }
		#div-purchase-paylist { top:560px; left:910px; width: 180px; height: 90px; }
		#div-purchase-rap-ledger { top:560px; left:180px; width: 150px; height:90px; }
		#div-purchase-rap-aging { top:560px; left:370px; width: 150px; height: 90px; }


		#div1-3-container { width: 240px; height:500px; color:white; font-weight:bold; }
		#div1-3-container div span { position:absolute; bottom:10px; left:10px; }
		#div-chart-account { top:30px; left:530px; width: 100px; height:100px; }
		#div-journaltemp { top:30px; left:640px; width: 100px; height:100px; }
		#div-journal { top:140px; left:530px; width: 210px; height:100px; }
		#div-other-income { top:250px; left:530px; width: 100px; height:100px; }
		#div-other-expense { position:absolute; top:250px; left:640px; width: 100px; height:100px; }

		#div-rgl { top:400px; left:530px; width: 100px; height:100px; }
		#div-rjournal { position:absolute; top:400px; left:640px; width: 100px; height:100px; }
		#div-asset-regist { position:absolute; top:510px; left:530px; width: 100px; height:100px; }
		#div-rtrail-balance { position:absolute; top:510px; left:640px; width: 100px; height:100px; }
		#div-rbalance-sheet { position:absolute; top:620px; left:530px; width: 100px; height:100px; }
		#div-rincome-statment { position:absolute; top:620px; left:640px; width: 100px; height:100px; }

		#div-account-chart { top:30px; left:30px; width: 180px; height:90px; }
		#div-account-journaltemp { top:30px; left:250px; width: 180px; height: 90px; }
		#div-account-otincome { top:170px; left:250px; width: 180px; height: 90px; }
		#div-account-otexpense { top:300px; left:250px; width: 180px; height: 90px; }

		#div-account-journalnew { top:30px; left:470px; width: 180px; height:90px; }
		#div-account-journallist { top:30px; left:690px; width: 180px; height: 90px; }
		#div-account-rgl { top:235px; left:470px; width: 180px; height:90px; }
		#div-account-rtb { top:365px; left:470px; width: 180px; height:90px; }

		#div-account-rbs { top:495px; left:340px; width: 180px; height:90px; }
		#div-account-rincome { top:495px; left:590px; width: 180px; height: 90px; }

		#div-account-assetlist { top:495px; left:70px; width: 180px; height:90px; }
		

		#div1-4-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-4-container div span { position:absolute; bottom:10px; left:10px; }
		#div-material { top:30px; left:780px; width: 100px; height:100px; }
		#div-service { top:30px; left:890px; width: 100px; height:100px; }
		#div-asset-master { top:140px; left:780px; width: 100px; height:100px; }
		#div-bankname { top:140px; left:890px; width: 100px; height:100px; }
		#div-employee { top:250px; left:780px; width: 100px; height:100px; }
		#div-saleperson { top:250px; left:890px; width: 100px; height:100px; }

		#div-rpp30 { position:absolute; top:400px; left:780px; width: 100px; height:100px; }
		#div-rpp30-form { position:absolute; top:400px; left:890px; width: 100px; height:100px; }
		#div-rpnd1 { position:absolute; top:510px; left:780px; width: 100px; height:100px; }
		#div-rpnd3 { position:absolute; top:510px; left:890px; width: 100px; height:100px; }
		#div-rpnd53 { position:absolute; top:620px; left:780px; width: 100px; height:100px; }
		#div-rpnd50-form { position:absolute; top:620px; left:890px; width: 100px; height:100px; }

		#div-master-custype { top:30px; left:250px; width: 180px; height: 90px; }
		#div-master-cusnew { top:30px; left:470px; width: 180px; height: 90px; }

		#div-master-ventype { top:160px; left:250px; width: 180px; height: 90px; }
		#div-master-vennew { top:160px; left:470px; width: 180px; height: 90px; }
		#div-master-mattype { top:345px; left:30px; width: 180px; height:90px; }
		#div-master-matgrp { top:345px; left:250px; width: 180px; height: 90px; }
		#div-master-matnew { top:280px; left:470px; width: 180px; height: 90px; }
		#div-master-sernew { top:410px; left:470px; width: 180px; height: 90px; }

		#div-master-assettype { top:530px; left:30px; width: 180px; height:90px; }
		#div-master-assetgrp { top:530px; left:250px; width: 180px; height: 90px; }
		#div-master-assetnew { top:530px; left:470px; width: 180px; height: 90px; }
		#div-master-depart { top:660px; left:30px; width: 180px; height:90px; }
		#div-master-position { top:660px; left:250px; width: 180px; height: 90px; }
		#div-master-employee { top:660px; left:470px; width: 180px; height: 90px; }
		#div-master-saleperson { top:660px; left:690px; width: 180px; height: 90px; }

		#div-master-bankname { top:30px; left:720px; width: 150px; height: 90px; }
		#div-master-unit { top:350px; left:720px; width: 150px; height: 90px; }

		#div1-5-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-5-container div span { position:absolute; bottom:10px; left:10px; }

        #div-config-company { top:30px; left:30px; width: 180px; height:90px; }
		#div-config-initial { top:30px; left:250px; width: 180px; height: 90px; }
		#div-config-authorize { top:160px; left:30px; width: 180px; height:90px; }
		#div-config-limit { top:160px; left:250px; width: 180px; height: 90px; }

		#div1-6-container { width: 240px; height:30px; color:white; font-weight:bold; }
		#div1-6-container div span { position:absolute; bottom:10px; left:10px; }

        #div-report-rinvoice { top:30px; left:30px; width: 180px; height:90px; }
		#div-report-rreceipt { top:30px; left:250px; width: 180px; height: 90px; }
		#div-report-rap { top:30px; left:470px; width: 180px; height:90px; }
		#div-report-rpayment { top:30px; left:690px; width: 180px; height: 90px; }
		#div-report-rar-ledger { top:160px; left:30px; width: 180px; height:90px; }
		#div-report-rar-aging { top:160px; left:250px; width: 180px; height: 90px; }
		#div-report-rap-ledger { top:160px; left:470px; width: 180px; height:90px; }
		#div-report-rap-aging { top:160px; left:690px; width: 180px; height: 90px; }

		#div-report-rincome { top:290px; left:30px; width: 180px; height:90px; }
		#div-report-rjounrnal { top:290px; left:250px; width: 180px; height: 90px; }
		#div-report-rpretty { top:290px; left:470px; width: 180px; height:90px; }
		#div-report-rsalej { top:290px; left:690px; width: 180px; height: 90px; }
		#div-report-rpurchasej { top:420px; left:30px; width: 180px; height:90px; }
		#div-report-rgeneral { top:420px; left:250px; width: 180px; height: 90px; }
		#div-report-rtb { top:420px; left:470px; width: 180px; height:90px; }
		#div-report-rbs { top:420px; left:690px; width: 180px; height: 90px; }

		#div-report-rassetlist { top:550px; left:30px; width: 180px; height: 90px; }
		#div-report-rassetdepre { top:550px; left:250px; width: 180px; height:90px; }

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
		.arrow-down2 { width:11px; border:0px solid #f00; position:absolute; background:#014051 url('<?= base_url('assets/images/arrow/arrow-line2.gif') ?>') repeat-y center center; }
		.arrow-down2 span { display:block; width:11px; height:6px; position:absolute; bottom:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-down.gif') ?>') repeat-y center center;
		}
		.arrow-right2,
		.arrow-left2 { height:11px;background:#014051 url('<?= base_url('assets/images/arrow/arrow-line-h2.gif') ?>') repeat-x center center; }
		.arrow-left2 span { display:block; width:6px; height:11px; position:absolute; left:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-left.gif') ?>') repeat-y center center;
		}
		.arrow-right2 span {
			display:block; width:6px; height:11px; position:absolute; right:0px;
			background:#014051 url('<?= base_url('assets/images/arrow/arrow-head-right.gif') ?>') repeat-y center center;
		}
		.arrow2 { width:7px; border:0px solid #f00; position:absolute; url('<?= base_url('assets/images/arrow/arrow-line.gif') ?>') repeat-y center center; }

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

		#arrow-sale-01 { height:40px; top:130px; left:110px; }
		#arrow-sale-02 { height:40px; top:260px; left:110px; }
		#arrow-sale-03 { width:40px; top:210px; left:210px; }
		#arrow-sale-04 { height:40px; top:260px; left:330px; }
		#arrow-sale-05 { width:40px; top:210px; left:430px; }
		#arrow-sale-06 { height:40px; top:260px; left:550px; }
		#arrow-sale-07 { width:40px; top:210px; left:650px; }
		#arrow-sale-08 { height:40px; top:260px; left:770px; }
		#arrow-sale-09 { width:40px; top:210px; left:870px; }
		#arrow-sale-10 { width:40px; top:340px; left:870px; }

		#arrow-sale-11 { height:170px; top:390px; left:770px; }
		#arrow-sale-12 { width:35px; top:470px; left:740px; }
		#arrow-sale-13 { width:35px; top:470px; left:775px; }
		#arrow-sale-14 { width:40px; top:600px; left:870px; }

		#arrow-sale-15 { width:40px; top:470px; left:520px; }
		#arrow-sale-16 { width:40px; top:470px; left:990px; }

		#arrow-purc-01 { height:40px; top:130px; left:110px; }
		#arrow-purc-02 { height:40px; top:260px; left:110px; }
		#arrow-purc-03 { width:40px; top:210px; left:210px; }
		#arrow-purc-04 { height:40px; top:260px; left:330px; }
		#arrow-purc-05 { width:40px; top:210px; left:430px; }
		#arrow-purc-06 { height:40px; top:260px; left:550px; }
		#arrow-purc-07 { width:40px; top:210px; left:650px; }
		#arrow-purc-08 { height:40px; top:260px; left:770px; }
		#arrow-purc-09 { width:40px; top:210px; left:870px; }
		#arrow-purc-10 { width:40px; top:340px; left:870px; }

		#arrow-purc-11 { height:170px; top:390px; left:770px; }
		#arrow-purc-12 { width:35px; top:470px; left:740px; }
		#arrow-purc-13 { width:35px; top:470px; left:775px; }
		#arrow-purc-14 { width:40px; top:600px; left:870px; }

		#arrow-purc-15 { width:40px; top:470px; left:520px; }
		#arrow-purc-16 { width:40px; top:470px; left:990px; }

		#arrow-acc-01 { width:40px; top:70px; left:210px; }
		#arrow-acc-02 { width:40px; top:70px; left:430px; }
		#arrow-acc-03 { width:40px; top:70px; left:650px; }
		#arrow-acc-04 { height:115px; top:120px; left:550px; }
		#arrow-acc-05 { height:40px; top:325px; left:550px; }
		#arrow-acc-06 { height:80px; top:455px; left:550px; }
		#arrow-acc-07 { width:35px; top:535px; left:520px; }
		#arrow-acc-08 { width:35px; top:535px; left:555px; }
		#arrow-acc-09 { width:130px; top:275px; left:340px; }
		#arrow-acc-10 { height:40px; top:260px; left:340px; }


		#arrow-mas-02 { width:40px; top:70px; left:430px; }
		#arrow-mas-03 { width:70px; top:70px; left:650px; }

		#arrow-mas-05 { width:40px; top:200px; left:430px; }
		#arrow-mas-06 { width:40px; top:385px; left:210px; }
		#arrow-mas-07 { width:125px; top:385px; left:430px; }
		#arrow-mas-08 { width:155px; top:385px; left:565px; }
		#arrow-mas-09 { width:40px; top:575px; left:210px; }
		#arrow-mas-10 { width:40px; top:575px; left:430px; }
		#arrow-mas-11 { width:40px; top:705px; left:210px; }
		#arrow-mas-12 { width:40px; top:705px; left:430px; }
		#arrow-mas-14 { height:20px; top:370px; left:555px; }
		#arrow-mas-13 { height:20px; top:390px; left:555px; }
		#arrow-mas-15 { width:40px; top:705px; left:650px; }

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
			var nodeAccChart = {
				text: 'Chart of Accounting',
				leaf: true,
				id: 'click_chart_account'
			};
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
			var nodeIncome = {
				text: 'Create New Other Income',
				leaf: true,
				id: 'click_income'
			};
			var nodeExpense = {
				text: 'Create New Other Expense',
				leaf: true,
				id: 'click_expense'
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

					nodeAccChart,
					nodeJTemplate,
					nodeJournal,
					nodeIncome,
					nodeExpense,
					grouprAccount
				]
			};

            var nodeCustomertype = {
				text: 'Customer Type',
				leaf: true,
				id: 'click_customer_type'
			};
			var nodeCustomer = {
				text: 'Customer Master',
				leaf: true,
				id: 'click_customer'
			};
			var nodeVendortype = {
				text: 'Vendor Type',
				leaf: true,
				id: 'click_vendor_type'
			};
			var nodeVendor = {
				text: 'Vendor Master',
				leaf: true,
				id: 'click_vendor'
			};
			var nodeMaterialtype = {
				text: 'Material type',
				leaf: true,
				id: 'click_material_type'
			};
			var nodeMaterialgrp = {
				text: 'Material group',
				leaf: true,
				id: 'click_material_group'
			};
			var nodeMaterial = {
				text: 'Material Master',
				leaf: true,
				id: 'click_material'
			};
			var nodeService = {
				text: 'Service Master',
				leaf: true,
				id: 'click_service'
			};
			var nodeAssettype = {
				text: 'Fixed Asset type',
				leaf: true,
				id: 'click_asset_type'
			};
			var nodeAssetgrp = {
				text: 'Fixed Asset group',
				leaf: true,
				id: 'click_asset_group'
			};
			var nodeFixedAsset = {
				text: 'Fixed Asset Master',
				leaf: true,
				id: 'click_fixedasset'
			};
			var nodeDepartment = {
				text: 'Deparment Master',
				leaf: true,
				id: 'click_department'
			};
			var nodePosition = {
				text: 'Position Master',
				leaf: true,
				id: 'click_position'
			};
			var nodeEmployee = {
				text: 'Employee Master',
				leaf: true,
				id: 'click_employee'
			};
			var nodeSaleperson = {
				text: 'Salesperson Master',
				leaf: true,
				id: 'click_saleperson'
			};
			var nodeBankname = {
				text: 'Bank Master',
				leaf: true,
				id: 'click_bankname_setting'
			};
			var nodeUnit = {
				text: 'Unit Master',
				leaf: true,
				id: 'click_unit'
			};


			var groupMaster = {
				text: 'Master Data',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				id: 'groupMaster',
				children: [
				    nodeCustomertype,
				    nodeCustomer,
				    nodeVendortype,
				    nodeVendor,
				    nodeMaterialtype,
					nodeMaterialgrp,
					nodeMaterial,
					nodeService,
					nodeAssettype,
					nodeAssetgrp,
					nodeFixedAsset,
					nodeDepartment,
					nodePosition,
					nodeEmployee,
					nodeSaleperson,
					nodeUnit,
					nodeBankname
				]
			};

			var nodeARLedger = {
				text: 'AR Ledger',
				leaf: true,
				id: 'click_ar_ledger'
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
			var nodeFixedRe = {
				text: 'Fixed Asset Register Report',
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
			var nodeReportPurchaseJ = {
				text: 'Purchase Journal Report',
				leaf: true,
				id: 'click_report_purchasej'
			};
			var nodeReportReceiptJ = {
				text: 'Receipt Journal Report',
				leaf: true,
				id: 'click_report_receiptj'
			};
			var nodeReportPaymentJ = {
				text: 'Payment Journal Report',
				leaf: true,
				id: 'click_report_paymentj'
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
					nodeFixedRe,
					nodeReportGJ,
					nodeReportPJ,
					nodeReportSJ,
					nodeReportPurchaseJ,
					nodeReportReceiptJ,
					nodeReportPaymentJ,
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
				    nodeAuth
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
						groupMaster,
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
								    '<div id="div-chart-account" class="box box-blue"><span>Chart of Accounting</span></div>',
									'<div id="div-journaltemp" class="box box-blue"><span>Journal Template</span></div>',
									'<div id="div-journal" class="box box-blue"><span>Journal Posting</span></div>',
									'<div id="div-other-income" class="box box-blue"><span>Other Incomes</span></div>',
									'<div id="div-other-expense" class="box box-blue"><span>Other Expenses</span></div>',

									'<div id="div-rgl" class="box box-orange"><span>GL Report</span></div>',
									'<div id="div-rjournal" class="box box-orange"><span>Journal Report</span></div>',
									'<div id="div-asset-regist" class="box box-orange"><span>Fixed Asset Register</span></div>',
									'<div id="div-rtrail-balance" class="box box-orange"><span>Trail Balance</span></div>',
									'<div id="div-rbalance-sheet" class="box box-orange"><span>Balance Sheet</span></div>',
									'<div id="div-rincome-statment" class="box box-orange"><span>Income Statment</span></div>',
								'</div>',
								//Material Module
								'<div id="div1-4-container">',
								    '<div id="div-material" class="box box-purple"><span>Materials Master</span></div>',
									'<div id="div-service" class="box box-purple"><span>Services Master</span></div>',
								    '<div id="div-asset-master" class="box box-purple"><span>Fixed Asset Master</span></div>',
									'<div id="div-employee" class="box box-purple"><span>Employee Master</span></div>',
									'<div id="div-bankname" class="box box-purple"><span>Bank Master</span></div>',
									'<div id="div-saleperson" class="box box-purple"><span>Salesperson Master</span></div>',

									'<div id="div-rpp30" class="box box-orange"><span>ภ.พ.30</span></div>',
									'<div id="div-rpp30-form" class="box box-orange"><span>ฟอร์ม ภ.พ.30</span></div>',
									'<div id="div-rpnd1" class="box box-orange"><span>ภ.ง.ด.1</span></div>',
									'<div id="div-rpnd3" class="box box-orange"><span>ภ.ง.ด.3</span></div>',
									'<div id="div-rpnd53" class="box box-orange"><span>ภ.ง.ด.53</span></div>',
									'<div id="div-rpnd50-form" class="box box-orange"><span>ฟอร์ม ภ.พ.50 ทวิ</span></div>',
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
									'<div id="div-sales-customer" class="box box-green"><span>Customer Master</span></div>',
									'<div id="div-sales-projectnew" class="box box-green"><span>Create New Project</span></div>',
									'<div id="div-sales-projectlist" class="box box-green"><span>Projects List</span></div>',
									'<div id="div-sales-qtnew" class="box box-green"><span>Create New Quotation</span></div>',
									'<div id="div-sales-qtlist" class="box box-green"><span>Quotations List</span></div>',
									'<div id="div-sales-dpnew" class="box box-green"><span>Create New Deposit Receipt</span></div>',
									'<div id="div-sales-dplist" class="box box-green"><span>Deposit Receipts List</span></div>',
									'<div id="div-sales-sonew" class="box box-green"><span>Create New Sale Order</span></div>',
									'<div id="div-sales-solist" class="box box-green"><span>Sale Orders List</span></div>',
									'<div id="div-sales-invnew" class="box box-green"><span>Create New Invoice</span></div>',
									'<div id="div-sales-invlist" class="box box-green"><span>Invoices List</span></div>',

									'<div id="div-sales-dnnew" class="box box-green"><span>Create New Debit Note</span></div>',
									'<div id="div-sales-dnlist" class="box box-green"><span>Debit Notes List</span></div>',
									'<div id="div-sales-cnnew" class="box box-green"><span>Create New Credit Note</span></div>',
									'<div id="div-sales-cnlist" class="box box-green"><span>Credit Notes List</span></div>',
                                    '<div id="div-sales-recnew" class="box box-green"><span>Create New Receipt</span></div>',
									'<div id="div-sales-reclist" class="box box-green"><span>Receipts List</span></div>',
									'<div id="div-sales-rar-ledger" class="box box-orange"><span>Invoice Report</span></div>',
									'<div id="div-sales-rar-aging" class="box box-orange"><span>Receipt Report</span></div>',

								'</div>',
								// arrow
								'<div id="arrow-sale-01" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-sale-02" class="arrow arrow-down2"><span></span></div>',
								'<div id="arrow-sale-03" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-04" class="arrow arrow-down2"><span></span></div>',
								'<div id="arrow-sale-05" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-06" class="arrow arrow-down2"><span></span></div>',
								'<div id="arrow-sale-07" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-08" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-sale-09" class="arrow arrow-right2"><span></span></div>',
								'<div id="arrow-sale-10" class="arrow arrow-right2"><span></span></div>',

								'<div id="arrow-sale-12" class="arrow arrow-left"><span></span></div>',
								'<div id="arrow-sale-13" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-sale-11" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-sale-14" class="arrow arrow-right2"><span></span></div>',

								'<div id="arrow-sale-15" class="arrow arrow-left2"><span></span></div>',
								'<div id="arrow-sale-16" class="arrow arrow-right2"><span></span></div>',

							'</div>',
							'<div id="purchase-container" style="display:none;">',
								'<div id="div1-2-container">',
									'<div id="div-purchase-vendor" class="box box-red"><span>Vendor Master</span></div>',
									'<div id="div-purchase-prnew" class="box box-red"><span>Create New Purchase Requisition</span></div>',
									'<div id="div-purchase-prlist" class="box box-red"><span>Purchase Requisitions List</span></div>',
									'<div id="div-purchase-ponew" class="box box-red"><span>Create New Purchase Order</span></div>',
									'<div id="div-purchase-polist" class="box box-red"><span>Purchase Orders List</span></div>',
									'<div id="div-purchase-dpnew" class="box box-red"><span>Create New Deposit Payment</span></div>',
									'<div id="div-purchase-dplist" class="box box-red"><span>Deposit Payments List</span></div>',
									'<div id="div-purchase-grnew" class="box box-red"><span>Create New Goods Receipt</span></div>',
									'<div id="div-purchase-grlist" class="box box-red"><span>Goods Receipts List</span></div>',
									'<div id="div-purchase-apnew" class="box box-red"><span>Create New Account Payable</span></div>',
									'<div id="div-purchase-aplist" class="box box-red"><span>Account Payables List</span></div>',

									'<div id="div-purchase-dnnew" class="box box-red"><span>Create New Debit Note</span></div>',
									'<div id="div-purchase-dnlist" class="box box-red"><span>Debit Notes List</span></div>',
									'<div id="div-purchase-cnnew" class="box box-red"><span>Create New Credit Note</span></div>',
									'<div id="div-purchase-cnlist" class="box box-red"><span>Credit Notes List</span></div>',
                                    '<div id="div-purchase-paynew" class="box box-red"><span>Create New Payment</span></div>',
									'<div id="div-purchase-paylist" class="box box-red"><span>Payments List</span></div>',
									'<div id="div-purchase-rap-ledger" class="box box-orange"><span>Account Payable Report</span></div>',
									'<div id="div-purchase-rap-aging" class="box box-orange"><span>Payment Report</span></div>',

								'</div>',
								// arrow
								'<div id="arrow-purc-01" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-purc-02" class="arrow arrow-down2"><span></span></div>',
								'<div id="arrow-purc-03" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-04" class="arrow arrow-down2"><span></span></div>',
								'<div id="arrow-purc-05" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-06" class="arrow arrow-down2"><span></span></div>',
								'<div id="arrow-purc-07" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-08" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-purc-09" class="arrow arrow-right2"><span></span></div>',
								'<div id="arrow-purc-10" class="arrow arrow-right2"><span></span></div>',

								'<div id="arrow-purc-12" class="arrow arrow-left"><span></span></div>',
								'<div id="arrow-purc-13" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-purc-11" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-purc-14" class="arrow arrow-right2"><span></span></div>',

								'<div id="arrow-purc-15" class="arrow arrow-left2"><span></span></div>',
								'<div id="arrow-purc-16" class="arrow arrow-right2"><span></span></div>',
							'</div>',

							'<div id="account-container" style="display:none;">',
								'<div id="div1-3-container">',
								    '<div id="div-account-chart" class="box box-blue"><span>Chart of Accounting</span></div>',
								    '<div id="div-account-journaltemp" class="box box-blue"><span>Journal Template</span></div>',
								    '<div id="div-account-journalnew" class="box box-blue"><span>Create New Journal Posting</span></div>',
								    '<div id="div-account-journallist" class="box box-blue"><span>Journals List</span></div>',
									'<div id="div-account-rgl" class="box box-orange"><span>GL Report</span></div>',
									'<div id="div-account-rtb" class="box box-orange"><span>Trail Balance Report</span></div>',
									'<div id="div-account-rincome" class="box box-orange"><span>Income Statement Report</span></div>',
									'<div id="div-account-rbs" class="box box-orange"><span>Balance Sheet Report</span></div>',
									'<div id="div-account-otincome" class="box box-blue"><span>Other Income</span></div>',
									'<div id="div-account-otexpense" class="box box-blue"><span>Other Expense</span></div>',

									'<div id="div-account-assetlist" class="box box-orange"><span>Fixed Asset Register</span></div>',

								'</div>',
								// arrow
								'<div id="arrow-acc-01" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-acc-02" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-acc-03" class="arrow arrow-right2"><span></span></div>',
								'<div id="arrow-acc-04" class="arrow arrow-down2"><span></span></div>',
								'<div id="arrow-acc-05" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-acc-06" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-acc-07" class="arrow arrow-left"><span></span></div>',
								'<div id="arrow-acc-08" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-acc-09" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-acc-10" class="arrow arrow2"><span></span></div>',
							'</div>',
							'<div id="master-container" style="display:none;">',
								'<div id="div1-4-container">',
								    '<div id="div-master-custype" class="box box-purple"><span>Customer Type</span></div>',

									'<div id="div-master-cusnew" class="box box-purple"><span>Customer Master</span></div>',
									'<div id="div-master-ventype" class="box box-purple"><span>Vendor Type</span></div>',

									'<div id="div-master-vennew" class="box box-purple"><span>Vendor Master</span></div>',

									'<div id="div-master-mattype" class="box box-purple"><span>Material Type</span></div>',
									'<div id="div-master-matgrp" class="box box-purple"><span>Mat&Service Group</span></div>',
									'<div id="div-master-matnew" class="box box-purple"><span>Material Master</span></div>',
									'<div id="div-master-sernew" class="box box-purple"><span>Service Master</span></div>',

									'<div id="div-master-assettype" class="box box-purple"><span>Fixed Asset Type</span></div>',
									'<div id="div-master-assetgrp" class="box box-purple"><span>Fixed Asset Group</span></div>',
									'<div id="div-master-assetnew" class="box box-purple"><span>Fixed Asset Master</span></div>',
									'<div id="div-master-depart" class="box box-purple"><span>Department</span></div>',
									'<div id="div-master-position" class="box box-purple"><span>Position</span></div>',
									'<div id="div-master-employee" class="box box-purple"><span>Employee Master</span></div>',
									'<div id="div-master-saleperson" class="box box-purple"><span>Salesperson Master</span></div>',

									'<div id="div-master-bankname" class="box box-purple"><span>Bank Master</span></div>',
									'<div id="div-master-unit" class="box box-purple"><span>Unit Master</span></div>',
								'</div>',
								// arrow

								'<div id="arrow-mas-02" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-mas-03" class="arrow arrow-left2"><span></span></div>',

								'<div id="arrow-mas-05" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-mas-06" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-mas-07" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-mas-08" class="arrow arrow-left2"><span></span></div>',
								'<div id="arrow-mas-09" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-mas-10" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-mas-11" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-mas-12" class="arrow arrow-right"><span></span></div>',
								'<div id="arrow-mas-13" class="arrow arrow-down"><span></span></div>',
								'<div id="arrow-mas-14" class="arrow arrow-up"><span></span></div>',
								'<div id="arrow-mas-15" class="arrow arrow-right"><span></span></div>',
							'</div>',
							'<div id="config-container" style="display:none;">',
								//'<img src="'+__base_url+'assets/images/temp/bg-reports.gif?v=1" />',
								'<div id="div1-5-container">',
								      '<div id="div-config-company" class="box box-base"><span>Company Define</span></div>',
									  '<div id="div-config-initial" class="box box-base"><span>Initial Document No</span></div>',

									  '<div id="div-config-authorize" class="box box-base"><span>Authorize Setting</span></div>',
									  '<div id="div-config-limit" class="box box-base"><span>Limitation Setting</span></div>',
								'</div>',
							'</div>',
							'<div id="reports-container" style="display:none;">',
								//'<img src="'+__base_url+'assets/images/temp/bg-reports.gif?v=1" />',
								'<div id="div1-6-container">',
								      '<div id="div-report-rinvoice" class="box box-orange"><span>Invoice Report</span></div>',
									  '<div id="div-report-rreceipt" class="box box-orange"><span>Receipt Report</span></div>',
									  '<div id="div-report-rap" class="box box-orange"><span>Account Payable Report</span></div>',
									  '<div id="div-report-rpayment" class="box box-orange"><span>Payment Report</span></div>',
									  '<div id="div-report-rar-ledger" class="box box-orange"><span>AR Ledger Report</span></div>',
									  '<div id="div-report-rar-aging" class="box box-orange"><span>AR Aging Report</span></div>',
									  '<div id="div-report-rap-ledger" class="box box-orange"><span>AP Ledger Report</span></div>',
									  '<div id="div-report-rap-aging" class="box box-orange"><span>AP Aging Report</span></div>',
									  '<div id="div-report-rassetlist" class="box box-orange"><span>Fixed Asset Register Report</span></div>',
									  '<div id="div-report-rjounrnal" class="box box-orange"><span>Journal Report</span></div>',
									  '<div id="div-report-rpretty" class="box box-orange"><span>Pretty Cash Journal Payable Report</span></div>',
									  '<div id="div-report-rsalej" class="box box-orange"><span>Sale Report</span></div>',

									  '<div id="div-report-rpurchasej" class="box box-orange"><span>Purchase Journal Report</span></div>',
									  '<div id="div-report-rgeneral" class="box box-orange"><span>General Report</span></div>',
									  '<div id="div-report-rtb" class="box box-orange"><span>Trail Balance Report</span></div>',
									  '<div id="div-report-rbs" class="box box-orange"><span>Balance Sheet Report</span></div>',

									  '<div id="div-report-rincome" class="box box-orange"><span>Income Statment Report</span></div>',
									  '<div id="div-report-rassetdepre" class="box box-orange"><span>Fixed Asset Depreciation Report</span></div>',
								'</div>',
							'</div>'
						].join(''),
						listeners : {
							render : function(c) {
								pEl = c.getEl();

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
								//Account Module
								pEl.getById('div-chart-account').on('click', function(){ $om.viewport.fireEvent('click_chart_account', c); }, c);
								pEl.getById('div-journaltemp').on('click', function(){ $om.viewport.fireEvent('click_journaltemp', c); }, c);
								pEl.getById('div-journal').on('click', function(){ $om.viewport.fireEvent('click_journal', c); }, c);
								pEl.getById('div-other-income').on('click', function(){ $om.viewport.fireEvent('click_income', c); }, c);
								pEl.getById('div-other-expense').on('click', function(){ $om.viewport.fireEvent('click_expense', c); }, c);

								pEl.getById('div-rgl').on('click', function(){ $om.viewport.fireEvent('click_rgl', c); }, c);
								pEl.getById('div-rjournal').on('click', function(){ $om.viewport.fireEvent('click_rjournal', c); }, c);
								pEl.getById('div-asset-regist').on('click', function(){ $om.viewport.fireEvent('click_asset-regist', c); }, c);
								pEl.getById('div-rtrail-balance').on('click', function(){ $om.viewport.fireEvent('click_rtrail-balance', c); }, c);
								pEl.getById('div-rbalance-sheet').on('click', function(){ $om.viewport.fireEvent('click_rbalance-sheet', c); }, c);
								pEl.getById('div-rincome-statment').on('click', function(){ $om.viewport.fireEvent('click_rincome-statment', c); }, c);

								//Master Module
								pEl.getById('div-material').on('click', function(){ $om.viewport.fireEvent('click_material', c); }, c);
								pEl.getById('div-service').on('click', function(){ $om.viewport.fireEvent('click_service', c); }, c);
                                pEl.getById('div-asset-master').on('click', function(){ $om.viewport.fireEvent('click_asset-master', c); }, c);
                                pEl.getById('div-employee').on('click', function(){ $om.viewport.fireEvent('click_employee', c); }, c);
                                pEl.getById('div-bankname').on('click', function(){ $om.viewport.fireEvent('click_bankname_setting', c); }, c);
                                pEl.getById('div-saleperson').on('click', function(){ $om.viewport.fireEvent('click_saleperson', c); }, c);

                                pEl.getById('div-rpp30').on('click', function(){ $om.viewport.fireEvent('click_RSumVat', c); }, c);
								pEl.getById('div-rpp30-form').on('click', function(){ $om.viewport.fireEvent('click_Rpp30Vat', c); }, c);
								pEl.getById('div-rpnd1').on('click', function(){ $om.viewport.fireEvent('click_Rpnd1WHT', c); }, c);
                                pEl.getById('div-rpnd3').on('click', function(){ $om.viewport.fireEvent('click_Rpnd3WHT', c); }, c);
                                pEl.getById('div-rpnd53').on('click', function(){ $om.viewport.fireEvent('click_Rpnd53WHT', c); }, c);
                                pEl.getById('div-rpnd50-form').on('click', function(){ $om.viewport.fireEvent('click_Rpnd50WHT', c); }, c);
                                //Sales Tab
                                pEl.getById('div-sales-customer').on('click', function(){ $om.viewport.fireEvent('click_customer', c); }, c);
                                pEl.getById('div-sales-projectnew').on('click', function(){ $om.viewport.fireEvent('click_projectnew', c); }, c);
                                pEl.getById('div-sales-projectlist').on('click', function(){ $om.viewport.fireEvent('click_project', c); }, c);
                                pEl.getById('div-sales-qtnew').on('click', function(){ $om.viewport.fireEvent('click_quotationnew', c); }, c);
                                pEl.getById('div-sales-qtlist').on('click', function(){ $om.viewport.fireEvent('click_quotation', c); }, c);

                                pEl.getById('div-sales-dpnew').on('click', function(){ $om.viewport.fireEvent('click_depositnew', c); }, c);
                                pEl.getById('div-sales-dplist').on('click', function(){ $om.viewport.fireEvent('click_deposit1', c); }, c);
                                pEl.getById('div-sales-sonew').on('click', function(){ $om.viewport.fireEvent('click_saleordernew', c); }, c);
                                pEl.getById('div-sales-solist').on('click', function(){ $om.viewport.fireEvent('click_saleorder', c); }, c);

                                pEl.getById('div-sales-invnew').on('click', function(){ $om.viewport.fireEvent('click_invoicenew', c); }, c);
                                pEl.getById('div-sales-invlist').on('click', function(){ $om.viewport.fireEvent('click_invoice', c); }, c);
                                pEl.getById('div-sales-dnnew').on('click', function(){ $om.viewport.fireEvent('click_sale_dnnew', c); }, c);
                                pEl.getById('div-sales-dnlist').on('click', function(){ $om.viewport.fireEvent('click_sale_dn', c); }, c);
                                pEl.getById('div-sales-cnnew').on('click', function(){ $om.viewport.fireEvent('click_sale_cnnew', c); }, c);
                                pEl.getById('div-sales-cnlist').on('click', function(){ $om.viewport.fireEvent('click_sale_cn', c); }, c);
                                pEl.getById('div-sales-recnew').on('click', function(){ $om.viewport.fireEvent('click_receiptnew', c); }, c);
                                pEl.getById('div-sales-reclist').on('click', function(){ $om.viewport.fireEvent('click_receipt', c); }, c);

                                pEl.getById('div-sales-rar-ledger').on('click', function(){ $om.viewport.fireEvent('click_rinvoice', c); }, c);
                                pEl.getById('div-sales-rar-aging').on('click', function(){ $om.viewport.fireEvent('click_rreceipt', c); }, c);


                                //Purchase Tab
                                pEl.getById('div-purchase-vendor').on('click', function(){ $om.viewport.fireEvent('click_vendor', c); }, c);
                                pEl.getById('div-purchase-prnew').on('click', function(){ $om.viewport.fireEvent('click_prnew', c); }, c);
                                pEl.getById('div-purchase-prlist').on('click', function(){ $om.viewport.fireEvent('click_pr', c); }, c);
                                pEl.getById('div-purchase-ponew').on('click', function(){ $om.viewport.fireEvent('click_ponew', c); }, c);
                                pEl.getById('div-purchase-polist').on('click', function(){ $om.viewport.fireEvent('click_po', c); }, c);
                                pEl.getById('div-purchase-dpnew').on('click', function(){ $om.viewport.fireEvent('click_deposit2new', c); }, c);
                                pEl.getById('div-purchase-dplist').on('click', function(){ $om.viewport.fireEvent('click_deposit2', c); }, c);
                                pEl.getById('div-purchase-grnew').on('click', function(){ $om.viewport.fireEvent('click_grnew', c); }, c);
                                pEl.getById('div-purchase-grlist').on('click', function(){ $om.viewport.fireEvent('click_gr', c); }, c);
                                pEl.getById('div-purchase-apnew').on('click', function(){ $om.viewport.fireEvent('click_apnew', c); }, c);
                                pEl.getById('div-purchase-aplist').on('click', function(){ $om.viewport.fireEvent('click_ap', c); }, c);
                                pEl.getById('div-purchase-dnnew').on('click', function(){ $om.viewport.fireEvent('click_purchase_dnnew', c); }, c);
                                pEl.getById('div-purchase-dnlist').on('click', function(){ $om.viewport.fireEvent('click_purchase_dn', c); }, c);
                                pEl.getById('div-purchase-cnnew').on('click', function(){ $om.viewport.fireEvent('click_purchase_cnnew', c); }, c);
                                pEl.getById('div-purchase-cnlist').on('click', function(){ $om.viewport.fireEvent('click_purchase_cn', c); }, c);
                                pEl.getById('div-purchase-paynew').on('click', function(){ $om.viewport.fireEvent('click_paymentnew', c); }, c);
                                pEl.getById('div-purchase-paylist').on('click', function(){ $om.viewport.fireEvent('click_payment', c); }, c);

                                pEl.getById('div-purchase-rap-ledger').on('click', function(){ $om.viewport.fireEvent('click_rap', c); }, c);
                                pEl.getById('div-purchase-rap-aging').on('click', function(){ $om.viewport.fireEvent('click_rpayment', c); }, c);


                                //Account Tab
                                pEl.getById('div-account-chart').on('click', function(){ $om.viewport.fireEvent('click_chart_account', c); }, c);
								pEl.getById('div-account-journaltemp').on('click', function(){ $om.viewport.fireEvent('click_journaltemp', c); }, c);
								pEl.getById('div-account-journalnew').on('click', function(){ $om.viewport.fireEvent('click_journal', c); }, c);
								pEl.getById('div-account-journallist').on('click', function(){ $om.viewport.fireEvent('click_journal', c); }, c);
								pEl.getById('div-account-otincome').on('click', function(){ $om.viewport.fireEvent('click_income', c); }, c);
								pEl.getById('div-account-otexpense').on('click', function(){ $om.viewport.fireEvent('click_expense', c); }, c);

								pEl.getById('div-account-rgl').on('click', function(){ $om.viewport.fireEvent('click_rgl', c); }, c);

								pEl.getById('div-account-assetlist').on('click', function(){ $om.viewport.fireEvent('click_asset-regist', c); }, c);
								pEl.getById('div-account-rtb').on('click', function(){ $om.viewport.fireEvent('click_rtrail-balance', c); }, c);
								pEl.getById('div-account-rbs').on('click', function(){ $om.viewport.fireEvent('click_rbalance-sheet', c); }, c);
								pEl.getById('div-account-rincome').on('click', function(){ $om.viewport.fireEvent('click_rincome-statment', c); }, c);

                                //Master Tab
                                pEl.getById('div-master-custype').on('click', function(){ $om.viewport.fireEvent('click_customer_type', c); }, c);

                                pEl.getById('div-master-cusnew').on('click', function(){ $om.viewport.fireEvent('click_customer', c); }, c);
                                pEl.getById('div-master-ventype').on('click', function(){ $om.viewport.fireEvent('click_vendor_type', c); }, c);

                                pEl.getById('div-master-matnew').on('click', function(){ $om.viewport.fireEvent('click_vendor', c); }, c);
                                pEl.getById('div-master-mattype').on('click', function(){ $om.viewport.fireEvent('click_material_type', c); }, c);
                                pEl.getById('div-master-matgrp').on('click', function(){ $om.viewport.fireEvent('click_material_group', c); }, c);
                                pEl.getById('div-master-matnew').on('click', function(){ $om.viewport.fireEvent('click_material', c); }, c);
								pEl.getById('div-master-sernew').on('click', function(){ $om.viewport.fireEvent('click_service', c); }, c);
                                pEl.getById('div-master-assettype').on('click', function(){ $om.viewport.fireEvent('click_asset_type', c); }, c);
                                pEl.getById('div-master-assetgrp').on('click', function(){ $om.viewport.fireEvent('click_asset_group', c); }, c);
                                pEl.getById('div-master-assetnew').on('click', function(){ $om.viewport.fireEvent('click_asset-master', c); }, c);
                                pEl.getById('div-master-depart').on('click', function(){ $om.viewport.fireEvent('click_department', c); }, c);
                                pEl.getById('div-master-position').on('click', function(){ $om.viewport.fireEvent('click_position', c); }, c);
                                pEl.getById('div-master-employee').on('click', function(){ $om.viewport.fireEvent('click_employee', c); }, c);
                                pEl.getById('div-master-bankname').on('click', function(){ $om.viewport.fireEvent('click_bankname_setting', c); }, c);
                                pEl.getById('div-master-saleperson').on('click', function(){ $om.viewport.fireEvent('click_saleperson', c); }, c);
                                pEl.getById('div-master-unit').on('click', function(){ $om.viewport.fireEvent('click_unit', c); }, c);
                                //Config Tab
                                pEl.getById('div-config-company').on('click', function(){ $om.viewport.fireEvent('click_company_setting', c); }, c);
                                pEl.getById('div-config-initial').on('click', function(){ $om.viewport.fireEvent('click_initail_setting', c); }, c);
                                pEl.getById('div-config-authorize').on('click', function(){ $om.viewport.fireEvent('click_authorize_setting', c); }, c);
                                pEl.getById('div-config-limit').on('click', function(){ $om.viewport.fireEvent('click_limitation_setting', c); }, c);
                                //Report Tab
                                pEl.getById('div-report-rinvoice').on('click', function(){ $om.viewport.fireEvent('click_rinvoice', c); }, c);
                                pEl.getById('div-report-rreceipt').on('click', function(){ $om.viewport.fireEvent('click_rreceipt', c); }, c);
                                pEl.getById('div-report-rap').on('click', function(){ $om.viewport.fireEvent('click_rap', c); }, c);
                                pEl.getById('div-report-rpayment').on('click', function(){ $om.viewport.fireEvent('click_rpayment', c); }, c);

                                pEl.getById('div-report-rar-ledger').on('click', function(){ $om.viewport.fireEvent('click_rinvoice', c); }, c);
                                pEl.getById('div-report-rar-aging').on('click', function(){ $om.viewport.fireEvent('click_rinvoice', c); }, c);
                                pEl.getById('div-report-rap-ledger').on('click', function(){ $om.viewport.fireEvent('click_rinvoice', c); }, c);
								pEl.getById('div-report-rap-aging').on('click', function(){ $om.viewport.fireEvent('click_rinvoice', c); }, c);
								pEl.getById('div-report-rassetdepre').on('click', function(){ $om.viewport.fireEvent('click_rassetdepre', c); }, c);

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
					masterCtnr = cEl.getById('master-container'),
					configCtnr = cEl.getById('config-container'),
					reportsCtnr = cEl.getById('reports-container');

				homeCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				salesCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				purchCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				accountCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				masterCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				configCtnr.setVisibilityMode(Ext.Element.DISPLAY);
				reportsCtnr.setVisibilityMode(Ext.Element.DISPLAY);

				homeCtnr.hide();
				salesCtnr.hide();
				purchCtnr.hide();
				accountCtnr.hide();
				masterCtnr.hide();
				configCtnr.hide();
				reportsCtnr.hide();

				switch(tab.title){
					case 'Home': homeCtnr.show(); break;
					case 'Sales': salesCtnr.show(); break;
					case 'Purchases': purchCtnr.show(); break;
					case 'Accounting': accountCtnr.show(); break;
					case 'Masters': masterCtnr.show(); break;
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
				            text: 'Customer',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-cust',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_customer')}
				        },{
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
				            text: 'Vendor',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-vend',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_vendor')}
				        },{
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
				            text: 'Payments',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-pay',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_payment')}
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
				            text: 'Debit Note',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-sdn',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_sale_dn')}
				        },{
				            text: 'Credit Note',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 's-scn',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_sale_cn')}
				        },{
				            text: 'Billing Note',
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
				            text: 'Debit Note',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-pcn',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_purchase_dn')}
				        },{
				            text: 'Credit Note',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'p-pdn',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_purchase_cn')}
				        },{
				            text: 'Billing Receipt',
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
				            text: 'Chart of Accounting',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-chart',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_chart_account')}
				        },{
				            text: 'Journal Template',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-journalt',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_journalt')}
				        },{
				            text: 'Journal Posting',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-journal',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_journal')}
				        },{
				            text: 'Other Income',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-income',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_income')}
				        },{
				            text: 'Other Expense',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-expense',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_expense')}
				        },{
				            text: 'GL Report',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'h-report',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_report_gl')}
				        },{
				            text: 'Journal Report',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-rjournal',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_rjournal')}
				        },{
				            text: 'Fixed Asset Register',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-fixasset',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_asset-regist')}
				        },{
				            text: 'Trail Balance',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-rtb',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Balance Sheet',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-rbalance',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Income Statment',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'a-rincome',
                			cls: 'x-btn-as-arrow'
				        }]
		            },{
		                title: 'Masters',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [{
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
				            text: 'Fixed Asset Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-ass-master',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_asset-master')}
				        },{
				            text: 'Bank Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-bank-master',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_bankname_setting')}
				        },{
				            text: 'Department Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-depart-master',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_department')}
				        },{
				            text: 'Position Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-posit-master',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_position')}
				        },{
				            text: 'Employee Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-empl',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_employee')}
				        },{
				            text: 'Salesperson Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-sale-master',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_saleperson')}
				        },{
				            text: 'Unit Master',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'm-unit',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_unit')}
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
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_company_setting')}
				        },{
				            text: 'Initial Doc No',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-init',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_config')}
				        },{
				            text: 'Limitation Setting',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-user',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_limitation_setting')}
				        },{
				            text: 'Authorize Setting',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'ms-auth',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_authorize_setting')}
				        }]
		            },{
		                title: 'Reports',
		                listeners: {
							activate: changeCenterView
						},
		                tbar: [{
				            text: 'Invoice Report',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report1',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_rinvoice')}
				        },{
				            text: 'Receipt Report',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report2',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_rreceipt')}
				        },{
				            text: 'AP Report',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report5',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_rap')}
				        },{
				            text: 'Payment Report',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report15',
                			cls: 'x-btn-as-arrow',
                			handler: function(){$om.viewport.fireEvent('click_rpayment')}
				        },{
				            text: 'AR Ledger',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report5',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'AR Aging',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report6',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'AP Ledger',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report16',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'AP Aging',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report17',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Fixed Asset Register',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report14',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Journal Report',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report8',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Pretty Cash Journal',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report9',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Sale Journal',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report10',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'Purchase Journal',
				            scale: 'large',
				            iconAlign: 'top',
				            iconCls: 'r-report11',
                			cls: 'x-btn-as-arrow'
				        },{
				            text: 'General Ledger Report',
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

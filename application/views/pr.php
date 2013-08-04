<script type="text/javascript">
Ext.Loader.setPath('Account', __base_url+'assets/js');

Ext.onReady(function() {

	$om.prDialog = Ext.create('Account.PR.MainWindow');

	$om.viewport.on('click_income', function(){
		$om.prDialog.show();
	});

});
</script>
<script type="text/javascript">
Ext.Loader.setPath('Account', __base_url+'assets/js');

Ext.onReady(function() {
	var loginDialog = Ext.create('Account.UMS.Login.Window');
	loginDialog.show();

	loginDialog.form.on('login_success', function(){
		self.location.href=__site_url+'index';
	});
});
</script>
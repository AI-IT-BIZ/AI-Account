Ext.define('Account.Rpnd1WHT.PreviewWindow2', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'แบบฟอร์มนำส่ง ภ.ง.ด.1',
			enableCopies: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		
		return this.callParent(arguments);
	},
	
	getFrameUrl: function(params, copies){
		copies = copies || 1;
		var q_str = '';
		params['copies'] = copies;
		return __site_url+'form/rsalarywht_docket/index?'+Ext.urlEncode(params);
	}
});
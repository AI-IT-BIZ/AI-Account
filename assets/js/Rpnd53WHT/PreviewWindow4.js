Ext.define('Account.Rpnd53WHT.PreviewWindow4', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'แบบฟอร์มนำส่ง ภ.ง.ด. 53',
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
		return __site_url+'form/rsumwht_docket/index?'+Ext.urlEncode(params);
	}
});
Ext.define('Account.Rpp30Vat.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'แบบฟอร์มนำส่ง ภ.พ.30',
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
		return __site_url+'form/rsumvat_docket/index?'+Ext.urlEncode(params);
	}
});
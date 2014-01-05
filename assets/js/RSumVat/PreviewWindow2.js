Ext.define('Account.RSumVat.PreviewWindow2', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
		var _this=this;

		Ext.apply(this, {
			title: 'รายงานภาษีขาย',

			enableCopies: true,

			getFrameUrl: function(params, copies){
				copies = copies || 1;
				var q_str = '';
				params['copies'] = copies;
				return __site_url+'form/rsalevat/index?'+Ext.urlEncode(params);
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {

		return this.callParent(arguments);
	}
});

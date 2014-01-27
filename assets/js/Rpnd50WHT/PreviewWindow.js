Ext.define('Account.Rpnd50WHT.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'หนังสือรับรองการหักภาษี ณ ที่จ่าย(50 ทวิ)',
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
		return __site_url+'form/rwht_docket/index?'+Ext.urlEncode(params);
	}
});
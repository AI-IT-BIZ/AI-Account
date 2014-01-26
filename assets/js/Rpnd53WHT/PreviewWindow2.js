Ext.define('Account.Rpnd53WHT.PreviewWindow2', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'รายงานภาษีหัก ณ ที่จ่าย(ฝั่งขาย)',
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
		return __site_url+'form/rsalewht/index?'+Ext.urlEncode(params);
	}
});
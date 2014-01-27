Ext.define('Account.RSumVat.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
		var _this=this;

		Ext.apply(this, {
			title: 'รายงานภาษีมูลค่าเพิ่ม',
			width: 1120,
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
		return __site_url+'form/rsumvat/index?'+Ext.urlEncode(params);
	}
});

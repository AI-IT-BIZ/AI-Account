Ext.define('Account.Rpnd1WHT.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'รายงานภาษีหัก ณ ที่จ่าย (ภ.ง.ด.1)',
			closeAction: 'hide',
			height: 600,
			width: 830,
			minHeight: 600,
			minWidth: 830,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true,
			buttonAlign:'center'
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
		return __site_url+'form/rsalarywht/index?'+Ext.urlEncode(params);
	}
});
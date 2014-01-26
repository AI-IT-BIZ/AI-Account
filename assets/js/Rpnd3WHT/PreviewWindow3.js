Ext.define('Account.Rpnd3WHT.PreviewWindow3', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'ใบแนบ ภ.ง.ด.3',
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
		return __site_url+'form/rpnd3wht_attach/index?'+Ext.urlEncode(params);
	}
});
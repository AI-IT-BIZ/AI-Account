Ext.define('Account.Rpnd53WHT.PreviewWindow3', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'ใบแนบ ภ.ง.ด.53',
			closeAction: 'hide',
			height: 600,
			width: 1000,
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
		return __site_url+'form/rpnd53wht_attach/index?'+Ext.urlEncode(params);
	}
});
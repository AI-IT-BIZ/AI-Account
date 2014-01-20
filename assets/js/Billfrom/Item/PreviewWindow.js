Ext.define('Account.Billfrom.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Bill from Vendor preview',
			closeAction: 'hide',
			enableCopies: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {

		return this.callParent(arguments);
	},
	
	getFrameUrl: function(id, copies){
		copies = copies || 1;
		return __site_url+'form/billfrom/index/'+id+'/'+copies;
	}
});
Ext.define('Account.AP.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'AP preview',
			enableCopies: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {

		return this.callParent(arguments);
	},
	getFrameUrl: function(id, copies){
		copies = copies || 1;
		return __site_url+'form/ap/index/'+id+'/'+copies;
	},
	
});
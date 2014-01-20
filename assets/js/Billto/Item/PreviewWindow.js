Ext.define('Account.Billto.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
        var _this=this;
        
		Ext.apply(this, {
			title: 'Billing Note preview',
			enableCopies: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		
		return this.callParent(arguments);
	},
	
	getFrameUrl: function(id, copies){
		copies = copies || 1;
		return __site_url+'form/billto/index/'+id+'/'+copies;
	}
});
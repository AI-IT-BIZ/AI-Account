Ext.define('Account.Invoice.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
        var _this=this;
        
		Ext.apply(this, {
			title: 'Invoice preview',
			enableCopies: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		
		return this.callParent(arguments);
	},
	
	getFrameUrl: function(id, copies){
		copies = copies || 1;
		return __site_url+'form/invoice/index/'+id+'/'+copies;
	}
});
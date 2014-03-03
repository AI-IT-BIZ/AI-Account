Ext.define('Account.Quotation.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
		var _this=this;

		Ext.apply(this, {
			title: 'Quotation preview',
			enableCopies: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {

		return this.callParent(arguments);
	},
	
	getFrameUrl: function(id, copies){
		copies = copies || 1;
		return __site_url+'form/quotation/index/'+id+'/'+copies;
	}

});

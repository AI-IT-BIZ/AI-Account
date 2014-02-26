Ext.define('Account.Quotation.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
		var _this=this;

		Ext.apply(this, {
			title: 'Quotation preview',
			enableCopies: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {

		return this.callParent(arguments);
	},
	/*
	getFrameUrl: function(id, copies){
		copies = copies || 1;
<<<<<<< HEAD
		return __site_url+'formbof/quotation/index/'+id+'/'+copies;
	}*/
=======
		return __site_url+'form/quotation/index/'+id+'/'+copies;
	}
>>>>>>> bd4b723668c4abe60a5c03c504efee580bddc08e
});

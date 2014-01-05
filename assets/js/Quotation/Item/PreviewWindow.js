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
	dialogId: null,
	openDialog:function(id){
		var _this=this;
		if(id){
			this.dialogId = id;
			this.show(false, function(){
				Ext.get('preview_frame').set({
					src:_this.getFrameUrl(id, _this.copies.getValue())
				});
				_this.showFrameLoad();
				_this.checkFrameReady(function(){
					_this.hideFrameLoad();
				});
			});
		}
	},
	getFrameUrl: function(id, copies){
		copies = copies || 1;
		return __site_url+'form/quotation/index/'+id+'/'+copies;
	}
});

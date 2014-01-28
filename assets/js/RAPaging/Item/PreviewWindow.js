Ext.define('Account.RAPaging.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
		var _this=this;

		Ext.apply(this, {
			title: 'AP Aging preview',
			maximizable: true,
			maximized: true,
			enableCopies: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {

		return this.callParent(arguments);
	}
});

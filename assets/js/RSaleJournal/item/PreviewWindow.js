Ext.define('Account.RSaleJournal.Item.PreviewWindow', {
	extend	: 'BASE.PreviewWindow',
	constructor:function(config) {
		var _this=this;

		Ext.apply(this, {
			title: 'Sale Journal preview',
			enableCopies: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {

		return this.callParent(arguments);
	}
});

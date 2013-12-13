Ext.define('Account.Employee.Import.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Employee Import',
			closeAction: 'hide',
			height: 600,
			minHeight: 480,
			width: 1000,
			minWidth: 600,
			resizable: true,
			modal: true,
			layout:'border',
			maximizable: true,
			border: false
		});

		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.Employee.Import.Form', {
			region: 'north',
			height: 80
		});

		this.grid = Ext.create('Account.Employee.Import.Grid', {
			region: 'center',
			disbled: true
		});

		this.items = [this.form, this.grid];

		// event
		this.form.on('upload_success', function(file_name){
			_this.grid.hideMask();
			_this.grid.load({
				file: file_name
			});
		});

		return this.callParent(arguments);
	},
	openDialog: function(){
		this.form.reset();
		this.grid.store.removeAll();
		this.show(false, function(){
			this.grid.showMask();
		});
	}
});

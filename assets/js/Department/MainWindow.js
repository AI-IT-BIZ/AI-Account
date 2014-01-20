Ext.define('Account.Department.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Department',
			closeAction: 'hide',
			height: 650,
			minHeight: 380,
			width: 600,
			minWidth: 500,
			resizable: true,
			modal: true,
			layout:'border',
			maximizable: true,
			defaultFocus: 'code'
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		// --- object ---
		/*
		this.addAct = new Ext.Action({
			text: 'เพิ่ม',
			iconCls: 'b-small-plus'
		});
		this.editAct = new Ext.Action({
			text: 'แก้ไข',
			iconCls: 'b-small-pencil'
		});
		this.deleteAct = new Ext.Action({
			text: 'ลบ',
			iconCls: 'b-small-minus'
		});
		*/
		//this.itemDialog = Ext.create('Account.PR.Item.Window');

		this.grid = Ext.create('Account.Department.Grid', {
			region:'center',
			border: false
		});

		this.items = [this.grid];

		//this.tbar = [this.addAct, this.editAct, this.deleteAct];

		// --- event ---
		this.buttons = [{
			text: 'Save',
			handler: function() {
				Ext.Msg.show({
					title : "Warning",
					msg : "Are you sure you want to update item(s) ?",
					icon : Ext.Msg.WARNING,
					buttons : Ext.Msg.YESNO,
					fn : function(bt) {
						if (bt == "yes") {
							_this.grid.save();
							//_this.grid.load();
						}
					}
				});
			}
		},{
			text: 'Cancel',
			handler: function() {
				//_this.grid.getForm().reset();
				_this.hide();
			}
		}];
		/*
		this.addAct.setHandler(function(){
			_this.itemDialog.show();

			// สั่ง pr_item grid load
			_this.itemDialog.grid.load({pr_id: 0});
		});

		this.editAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.show();
				_this.itemDialog.form.load(id);

				// สั่ง pr_item grid load
				_this.itemDialog.grid.load({pr_id: id});
			}
		});

		this.deleteAct.setHandler(function(){
			var sel = _this.grid.getView().getSelectionModel().getSelection()[0];
			var id = sel.data[sel.idField.name];
			if(id){
				_this.itemDialog.form.remove(id);
			}
		});
		this.itemDialog.form.on('afterSave', function(form){
			_this.itemDialog.hide();

			_this.grid.load();
		});

		this.itemDialog.form.on('afterDelete', function(form){
			_this.grid.load();
		});

		*/
		// --- after ---
		this.grid.load();

		return this.callParent(arguments);
	}
});
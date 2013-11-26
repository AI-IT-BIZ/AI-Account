Ext.define('Account.PO.Item.Window', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

        /*************************************/
        var btnPOPrint =  Ext.create('Ext.Button', {
            id:'btnPOPrint-PO-Window',
        	iconCls: 'b-small-print',
            text: 'Print',
            width: 50,
            handler: function() {
                     window.open("index.php/form_po");
            }
        });
        /************************************/
		Ext.apply(this, {
			title: 'Create/Edit Purchase Order',
			closeAction: 'hide',
			height: 650,
			width: 880,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true,
            tbar:[btnPOPrint]
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.form = Ext.create('Account.PO.Item.Form',{ region:'center' });

		this.items = [
		     this.form
		];
        
        

		this.buttons = [{
			text: 'Save',
			handler: function() {
				_this.form.save();
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}];
		return this.callParent(arguments);
	}
});
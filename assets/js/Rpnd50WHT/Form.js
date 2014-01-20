Ext.define('Account.Rpnd50WHT.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			//url: __site_url+'quotation/report',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 105
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
        // INIT Customer search popup ///////////////////////////////////
        this.paymentDialog = Ext.create('Account.SApWHT.MainWindow', {
			disableGridDoubleClick: true,
			isApproveOnly: true
		});
        
        this.trigPayment = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr',
			labelWidth: 130,
			fieldLabel: 'Account Payable No',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		// event trigPayment//
		this.trigPayment.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'ap/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.invnr);

						}else{
							o.markInvalid('Could not find Payment : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.paymentDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigPayment.setValue(record.data.invnr);

			grid.getSelectionModel().deselectAll();
			_this.paymentDialog.hide();
		});

		this.trigPayment.onTriggerClick = function(){
			_this.paymentDialog.show();
		};
        
		this.items = [this.trigPayment];		

		return this.callParent(arguments);
	},

	//load : function(id){
	//	this.getForm().load({
	//		params: { id: id },
	//		url:__site_url+'quotation/load'
	//	});
	//},


});


Ext.define('Account.RInvoice.MainWindow', {
	extend	: 'Ext.window.Window',

	constructor:function(config) {

		Ext.apply(this, {
			title: 'Invoice Selection',
			closeAction: 'hide',
			height: 270,
			width: 500,
			layout: 'border',
			//layout: 'accordion',
			resizable: true,
			modal: true
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		this.itemDialog = Ext.create('Account.RInvoice.Item.Window');

		this.form = Ext.create('Account.RInvoice.Form',{ region:'center' });

		this.items = [
		     this.form
				];

		this.buttons = [{
			text: 'Report',
			handler: function() {

			    _this.itemDialog.show();
                       
                            
                            var doc_start_from = _this.form.dateDoc1.getRawValue();
                            var doc_start_to = _this.form.dateDoc2.getRawValue();
                            var invoice_from = _this.form.trigInvoice.getRawValue();
                            var invoice_to = _this.form.trigInvoice2.getRawValue();
                            var so_no_from = _this.form.trigSaleorder.getRawValue();
                            var so_no_to = _this.form.trigSaleorder2.getRawValue();
                            var cus_code_from  = _this.form.trigCustomer.getRawValue();
                            var cus_code_to = _this.form.trigCustomer2.getRawValue();
                            var saleperson_from = _this.form.comboPSale.getValue();
                            var saleperson_to = _this.form.comboPSale2.getValue() ;
                            var invoice_status = _this.form.comboQStatus.getValue() ;
                            if(_this.form.comboPSale.getRawValue() == "")
                            {
                                saleperson_from = "";
                            }
                            if(_this.form.comboPSale2.getRawValue() == "")
                            {
                                saleperson_to = "";
                            }
                             if(_this.form.comboQStatus.getRawValue() == "")
                            {
                                invoice_status = "";
                            }
                          //  alert(saleperson_from);
                            var param = {doc_start_from : doc_start_from,
                                        doc_start_to : doc_start_to,
                                        invoice_from : invoice_from,
                                        invoice_to : invoice_to,
                                        so_no_from : so_no_from,
                                        so_no_to : so_no_to,
                                        cus_code_from : cus_code_from,
                                        cus_code_to : cus_code_to,
                                        saleperson_from : saleperson_from,
                                        saleperson_to : saleperson_to,
                                        invoice_status : invoice_status
                                       };
			    _this.itemDialog.grid.load(param);
                            
                            var strParam = "doc_start_from="+ doc_start_from ;
                            strParam = strParam + "&doc_start_to="+ doc_start_to ;
                            strParam = strParam + "&invoice_from="+ invoice_from ;
                            strParam = strParam + "&invoice_to="+ invoice_to;
                            strParam = strParam + "&so_no_from="+ so_no_from;
                            strParam = strParam + "&so_no_to="+ so_no_to;
                            strParam = strParam + "&cus_code_from="+  cus_code_from;
                            strParam = strParam + "&cus_code_to="+ cus_code_to;
                            strParam = strParam + "&saleperson_from="+ saleperson_from;
                            strParam = strParam + "&saleperson_to="+ saleperson_to;
                            strParam = strParam + "&invoice_status="+ invoice_status;
                         
                            
                           // alert(strParam);
                            _this.itemDialog.txtParam.setValue(strParam);
			}
		}, {
			text: 'Cancel',
			handler: function() {
				_this.form.getForm().reset();
				_this.hide();
			}
		}];
		
		// set handler for item grid store
		this.itemDialog.grid.store.on('beforeload', function(store){
			var formValues = _this.form.getForm().getValues();
			store.getProxy().extraParams = formValues;
		});
		return this.callParent(arguments);
	}
});
Ext.define('Account.RAssetRegister.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			//url: __site_url+'quotation/loads',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 105
				//width:300,
				//labelStyle: 'font-weight:bold'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
        // INIT Customer search popup ///////////////////////////////////

		this.assetDialog = Ext.create('Account.SAsset.MainWindow');

		this.assetDialog2 = Ext.create('Account.SAsset.MainWindow');
        
        
           this.dateDoc1 = Ext.create('Ext.form.field.Date', {
			fieldLabel: 'Document Date',
			name: 'bldat',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			});
                        
            /*this.dateDoc2 = Ext.create('Ext.form.field.Date', {
			name: 'bldat2',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			});*/
     
		
		this.trigAsset = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr',
			labelWidth: 100,
			fieldLabel: 'Asset No',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigAsset2 = Ext.create('Ext.form.field.Trigger', {
			name: 'invnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});

		this.items = [{

// Project Code
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[ this.dateDoc1,{
			
		   }]
		},{
	    xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigAsset,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigAsset2]  
// Quotation Code
		/*},{
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigSaleorder,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigSaleorder2]*/
// Customer Code
		}
////////////////////////////////////////////////		
		];
		
		// event trigInvoice///
		this.trigAsset.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'invoice/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.matnr);
							
						}else{
							o.markInvalid('Could not find asset code : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		this.trigAsset2.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'asset/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.matnr);
							
						}else{
							o.markInvalid('Could not find asset code : '+o.getValue());
						}
					}
				});
			}
		}, this);


		_this.assetDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigAsset.setValue(record.data.invnr);

			grid.getSelectionModel().deselectAll();
			_this.assetDialog.hide();
		});
		
		_this.assetDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigAsset2.setValue(record.data.invnr);

			grid.getSelectionModel().deselectAll();
			_this.assetDialog2.hide();
		});

		this.trigAsset.onTriggerClick = function(){
			_this.assetDialog.show();
		};
		
		this.trigAsset2.onTriggerClick = function(){
			_this.assetDialog2.show();
		};

		return this.callParent(arguments);
	},

	//load : function(id){
	//	this.getForm().load({
	//		params: { id: id },
	//		url:__site_url+'quotation/load'
	//	});
	//},

	});
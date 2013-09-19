Ext.define('Account.Payment.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'payment/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		// INIT Customer search popup ///////////////////////////////
		//this.quotationDialog = Ext.create('Account.Quotation.MainWindow');
		this.vendorDialog = Ext.create('Account.Vendor.MainWindow');
		
		this.gridItem = Ext.create('Account.Payment.Item.Grid_i',{
			//title:'Invoice Items',
			height: 320,
			region:'center'
		});
		this.gridGL = Ext.create('Account.Payment.Item.Grid_gl',{
			border: true,
			region:'center',
			title: 'GL Posting'
		});
		this.gridPM = Ext.create('Account.Payment.Item.Grid_pm',{
			border: true,
			region:'center',
			title: 'Payment'
		});
		this.formTotal = Ext.create('Account.Payment.Item.Form_t', {
			border: true,
			split: true,
			title:'Total PY',
			region:'south'
		});


/*---ComboBox Payment type----------------------------
		this.comboPtype = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Payment type',
			name: 'ptype',
			//width:185,
			//labelWidth: 80,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'payment/loads_combo/ptyp/ptype/paytx',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'ptype'
					}
				},
				fields: [
					'ptype',
					'paytx'
				],
				remoteSort: true,
				sorters: 'ptype ASC'
			}),
			queryMode: 'remote',
			displayField: 'paytx',
			valueField: 'ptype'
		});	
/* End combo------------------------------------------------*/		
		this.hdnPyItem = Ext.create('Ext.form.Hidden', {
			name: 'ebbp'
		});
		
		this.hdnPpItem = Ext.create('Ext.form.Hidden', {
			name: 'paym',
		});
		
		//this.hdnGlItem = Ext.create('Ext.form.Hidden', {
		//	name: 'bsid',
		//});
		
		this.trigVendor = Ext.create('Ext.form.field.Trigger', {
			name: 'lifnr',
			labelAlign: 'letf',
			width:240,
			fieldLabel: 'Vendor Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});
		
// Start Write Forms
		var mainFormPanel = {
			xtype: 'panel',
			border: true,
			region:'north',
			bodyPadding: '5 10 0 10',
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',
				labelWidth: 105
			},
			items: [this.hdnPyItem,this.hdnPpItem,
			{
			xtype:'fieldset',
            title: 'Header Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
// Vendor Code            
     items:[{
     	xtype: 'container',
                layout: 'hbox',
                //margin: '0 0 5 0',
     items: [{
                xtype: 'container',
                layout: 'anchor',
     items :[{
     	        xtype: 'container',
                layout: 'hbox',
               // margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},this.trigVendor,{
			xtype: 'displayfield',
			name: 'name1',
			margins: '0 0 0 6',
			width:350,
            allowBlank: true
		}]
		},{
			xtype: 'textarea',
			fieldLabel: 'Bill To',
			name: 'adr01',
			anchor:'90%',
			width:350,
			rows:2,
			labelAlign: 'top'
		}]
		},{
			xtype: 'container',
                layout: 'anchor',
     items :[{
			xtype: 'displayfield',
            fieldLabel: 'Payment No',
            name: 'payno',
            //flex: 3,
            value: 'PYXXXX-XXXX',
            labelAlign: 'right',
			//name: 'qt',
			width:240,
			//margins: '0 0 0 10',
            //emptyText: 'Customer',
            readOnly: true,
			labelStyle: 'font-weight:bold'
	    },{
			xtype: 'datefield',
			fieldLabel: 'Date',
			name: 'bldat',
			//anchor:'80%',
			labelAlign: 'right',
			width:240,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
	    },{
			xtype: 'datefield',
			fieldLabel: 'Payment Date',
			name: 'duedt',
			//anchor:'80%',
			labelAlign: 'right',
			width:240,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d',
			allowBlank: false
		}]
		}]
		}]
		}]
		};
		
		this.items = [mainFormPanel,this.gridItem,
		{
			xtype:'tabpanel',
			region:'south',
			activeTab: 0,
			height:170,
			items: [
				this.formTotal,
				this.gridPM,
				this.gridGL
			]
		}
			
		];
		
		// event trigVendor///
		this.trigVendor.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'vendor/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.lifnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
							var _addr = r.data.adr01;
						   if(!Ext.isEmpty(r.data.distx))
                             _addr += ' '+r.data.distx;
                           if(!Ext.isEmpty(r.data.pstlz))
                             _addr += ' '+r.data.pstlz;
                           if(!Ext.isEmpty(r.data.telf1))
                            _addr += '\n'+'Tel: '+r.data.telf1;
                           if(!Ext.isEmpty(r.data.telfx))
                             _addr += ' '+'Fax: '+r.data.telfx;
                           if(!Ext.isEmpty(r.data.email))
                            _addr += '\n'+'Email: '+r.data.email;
                            _this.getForm().findField('adr01').setValue(_addr);
                            //_this.getForm().findField('adr11').setValue(_addr);
							
						}else{
							o.markInvalid('Could not find vendor code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.vendorDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigVendor.setValue(record.data.lifnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			
			var _addr = record.data.adr01;
			if(!Ext.isEmpty(record.data.distx))
              _addr += ' '+record.data.distx;
            if(!Ext.isEmpty(record.data.pstlz))
              _addr += ' '+record.data.pstlz;
            if(!Ext.isEmpty(record.data.telf1))
               _addr += '\n'+'Tel: '+record.data.telf1;
             if(!Ext.isEmpty(record.data.telfx))
               _addr += ' '+'Fax: '+record.data.telfx;
             if(!Ext.isEmpty(record.data.email))
               _addr += '\n'+'Email: '+record.data.email;
             _this.getForm().findField('adr01').setValue(_addr);
             //_this.getForm().findField('adr11').setValue(_addr);

			grid.getSelectionModel().deselectAll();
			_this.vendorDialog.hide();
		});

		this.trigVendor.onTriggerClick = function(){
			_this.vendorDialog.show();
		};
		
	// grid event
		this.gridItem.store.on('update', this.calculateTotal, this);
		this.gridItem.store.on('load', this.calculateTotal, this);
		this.on('afterLoad', this.calculateTotal, this);

		return this.callParent(arguments);
	},	
	
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'payment/load',
			success: function(form, act){
				_this.fireEvent('afterLoad', form, act);
			}
		});
	},
	
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();
		
		// add grid data to json
		var rsItem = this.gridItem.getData();
		this.hdnPyItem.setValue(Ext.encode(rsItem));
		// add grid paym data to json
		var rsItem2 = this.gridPM.getData();
		this.hdnPpItem.setValue(Ext.encode(rsItem2));
/*
		this.getForm().getFields().each(function(f){
			//console.log(f.name);
    		 if(!f.validate()){
    		 	var p = f.up();
    		 	console.log(p);
    			 console.log('invalid at : '+f.name);
    		 }
    	 });
*/
		if (_form_basic.isValid()) {
			_form_basic.submit({
				success: function(form_basic, action) {
					form_basic.reset();
					_this.fireEvent('afterSave', _this);
				},
				failure: function(form_basic, action) {
					Ext.Msg.alert('Failed', action.result ? action.result.message : 'No response');
				}
			});
		}
	},
	
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'payment/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ payno: 0 });
		this.gridPM.load({ recnr: 0 });

		// default status = wait for approve
		//this.comboQStatus.setValue('05');
		//this.comboCond.setValue('01');
	},
	
	// calculate total functions
	calculateTotal: function(){
		var store = this.gridItem.store;
		var sum = 0;
		store.each(function(r){
			var itamt = parseFloat(r.data['itamt']),
				pay = parseFloat(r.data['payrc']);
			itamt = isNaN(itamt)?0:itamt;
			pay = isNaN(pay)?0:pay;

			var amt = itamt - pay;

			sum += amt;
		});
		this.formTotal.getForm().findField('beamt').setValue(Ext.util.Format.usMoney(sum).replace(/\$/, ''));
		this.formTotal.calculate();
	}
});
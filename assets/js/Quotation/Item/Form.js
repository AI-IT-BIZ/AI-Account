Ext.define('Account.Quotation.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'quotation/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		// INIT other components ///////////////////////////////////
		this.projectDialog = Ext.create('Account.Project.MainWindow');
		this.customerDialog = Ext.create('Account.Customer.MainWindow');

		this.gridItem = Ext.create('Account.Quotation.Item.Grid_i',{
			title:'Quotation Items'
		});
		this.gridPayment = Ext.create('Account.Quotation.Item.Grid_p',{
			border: true,
			region:'center'
		});
		this.formTotal = Ext.create('Account.Quotation.Item.Form_t', {
			border: true,
			split: true,
			region:'south'
		});
		// END INIT other components ////////////////////////////////

		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'QT Status',
			name : 'statu',
			labelAlign: 'right',
			//labelWidth: 95,
			width: 240,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			//disabled: true,
			margin: '0 0 0 -17',
			//allowBlank : false,
			clearFilterOnReset: true,
			emptyText: '-- Select Status --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_acombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'statu'
					}
				},
				fields: [
					'statu',
					'statx'
				],
				remoteSort: true,
				sorters: 'statu ASC'
			}),
			queryMode: 'remote',
			displayField: 'statx',
			valueField: 'statu'
		});

		this.comboPSale = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Saleperson',
			name : 'salnr',
			//labelWidth: 95,
			width: 350,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please select Saleperson --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_scombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'salnr'
					}
				},
				fields: [
					'salnr',
					'name1'
				],
				remoteSort: true,
				sorters: 'salnr ASC'
			}),
			queryMode: 'remote',
			displayField: 'name1',
			valueField: 'salnr'
		});

		this.comboPay = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Payments',
			name : 'ptype',
			//labelWidth: 95,
			width: 350,
			//anchor:'80%',
			//labelAlign: 'right',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please Select Payments --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_tcombo',
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

		this.comboTax = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Tax',
			name : 'taxnr',
			//labelWidth: 70,
			//anchor:'90%',
			width: 240,
			margin: '0 0 0 8',
			labelAlign: 'right',
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Select Tax --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'quotation/loads_taxcombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'taxnr'
					}
				},
				fields: [
					'taxnr',
					'taxtx'
				],
				remoteSort: true,
				sorters: 'taxnr ASC'
			}),
			queryMode: 'remote',
			displayField: 'taxtx',
			valueField: 'taxnr'
		});

		this.hdnQtItem = Ext.create('Ext.form.Hidden', {
			name: 'vbap',
		});

		this.hdnPpItem = Ext.create('Ext.form.Hidden', {
			name: 'payp',
		});

		this.trigProject = Ext.create('Ext.form.field.Trigger', {
			name: 'jobnr',
			fieldLabel: 'Project Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});

		this.trigCustomer = Ext.create('Ext.form.field.Trigger', {
			name: 'kunnr',
			fieldLabel: 'Customer Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});

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
			items: [this.hdnQtItem, this.hdnPpItem,
			{
				xtype:'fieldset',
				title: 'Header Data',
				collapsible: true,
				defaultType: 'textfield',
				layout: 'anchor',
				defaults: {
					anchor: '100%'
				},
				items:[{
					// Project Code
	 				xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
	 				items :[{
						xtype: 'hidden',
						name: 'id'
					},
					this.trigProject,
					{
						xtype: 'displayfield',
						name: 'jobtx',
						width:350,
						margins: '0 0 0 6',
						allowBlank: true
					},{
						xtype: 'displayfield',
						fieldLabel: 'Quotation No',
						name: 'vbeln',
						//flex: 3,
						value: 'QTXXXX-XXXX',
						labelAlign: 'right',
						//name: 'qt',
						width:240,
						readOnly: true,
						labelStyle: 'font-weight:bold'
						//disabled: true
					}]
				// Customer Code
				},{
					xtype: 'container',
					layout: 'hbox',
					margin: '0 0 5 0',
					items :[this.trigCustomer,
					{
						xtype: 'displayfield',
						//fieldLabel: '',
						//flex: 3,
						//value: '<span style="color:green;"></span>'
						name: 'name1',
						//labelAlign: 'l',
						margins: '0 0 0 6',
						width:350,
						//emptyText: 'Customer',
						allowBlank: true
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
					}]
				// Address Bill&Ship
				},{
					xtype: 'container',
					layout: 'hbox',
					defaultType: 'textfield',
					margin: '0 0 5 0',
					items: [{
						xtype: 'textarea',
						fieldLabel: 'Bill To',
						name: 'adr01',
						anchor:'90%',
						width:350,
						rows:2,
						labelAlign: 'top',
						allowBlank: true
					},{
						xtype: 'textarea',
						fieldLabel: 'Ship To',
						name: 'adr11',
						anchor:'90%',
						width:350,
						rows:2,
						labelAlign: 'right',
						labelAlign: 'top',
						margin: '0 0 0 145',
						allowBlank: true
					 }]
				// Sale Person
				},{
					xtype: 'container',
					layout: 'hbox',
					defaultType: 'textfield',
					margin: '0 0 5 0',
					items: [this.comboPSale,
					{
						xtype: 'numberfield',
						fieldLabel: 'Terms',
						name: 'terms',
						//anchor:'80%',
						labelAlign: 'right',
						width:200,
						align: 'right',
						margin: '0 0 0 35',
						allowBlank: true
					},{
						xtype: 'displayfield',
						margin: '0 0 0 5',
						width:10,
						value: 'Days',
						allowBlank: true
					},
					this.comboTax
				]
				// Tax&Ref no.
			 },{
			 	xtype: 'container',
				layout: 'hbox',
				defaultType: 'textfield',
				margin: '0 0 5 0',
				items: [this.comboPay,{
					xtype: 'textfield',
					fieldLabel: 'Reference No',
					name: 'refnr',
					//anchor:'90%',
					width:240,
					labelAlign: 'right',
					margin: '0 0 0 35',
					//width:450,
					allowBlank: true
				},
				this.comboQStatus]
				}]

			}]
		};

		this.items = [mainFormPanel,
		{
			xtype:'tabpanel',
			region:'center',
			activeTab: 0,
			border: false,
			items: [this.gridItem,
			{
				xtype: 'panel',
				border: false,
				title: 'Partial Payment',
				layout: 'border',
				items:[
					this.gridPayment
				]
			  }]
			},
			this.formTotal
		];

		// event trigCustomer///
		this.trigCustomer.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'customer/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.kunnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
							var _addr = r.data.adr01;
							if(!Ext.isEmpty(r.data.distx))
			                    _addr += ' '+r.data.distx;
							if(!Ext.isEmpty(r.data.pstlz))
								_addr += ' '+r.data.pstlz;
							if(!Ext.isEmpty(r.data.telf1))
								_addr += '\n'+'Tel: '+r.data.telf1;
							if(!Ext.isEmpty(r.data.telfx))
								_addr += '\n'+'Fax: '+r.data.telfx;
							if(!Ext.isEmpty(r.data.email))
							_addr += '\n'+'Email: '+r.data.email;
							_this.getForm().findField('adr01').setValue(_addr);
							_this.getForm().findField('adr11').setValue(_addr);
							//_this.getForm().findField('adr01').setValue(r.data.adr01
							//+' '+r.data.distx+' '+r.data.pstlz+'\n'+'Tel '+r.data.telf1+'\n'+'Fax '
							//+r.data.telfx+'\n'+'Email '+r.data.email);
						}else{
							o.markInvalid('Could not find customer code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.customerDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCustomer.setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);

			var _addr = record.data.adr01;
			if(!Ext.isEmpty(record.data.distx))
			  _addr += ' '+record.data.distx;
			if(!Ext.isEmpty(record.data.pstlz))
			  _addr += ' '+record.data.pstlz;
			if(!Ext.isEmpty(record.data.telf1))
				_addr += '\n'+'Tel: '+record.data.telf1;
			 if(!Ext.isEmpty(record.data.telfx))
				_addr += '\n'+'Fax: '+record.data.telfx;
			 if(!Ext.isEmpty(record.data.email))
				_addr += '\n'+'Email: '+record.data.email;
			 _this.getForm().findField('adr01').setValue(_addr);
			 _this.getForm().findField('adr11').setValue(_addr);
			//_this.getForm().findField('adr01').setValue(record.data.adr01
			//+' '+record.data.distx+' '+record.data.pstlz+'\n'+'Tel '+record.data.telf1+'\n'+'Fax '
			//+record.data.telfx+'\n'+'Email '+record.data.email);

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.show();
		};

		// event trigProject///
		this.trigProject.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'project/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.jobnr);
							_this.getForm().findField('jobtx').setValue(r.data.jobtx);

			_this.getForm().findField('kunnr').setValue(r.data.kunnr);
			_this.getForm().findField('name1').setValue(r.data.name1);
			_this.getForm().findField('salnr').setValue(r.data.salnr);

			var _addr = r.data.adr01;
			if(!Ext.isEmpty(r.data.distx))
			  _addr += ' '+r.data.distx;
			if(!Ext.isEmpty(r.data.pstlz))
			  _addr += ' '+r.data.pstlz;
			if(!Ext.isEmpty(r.data.telf1))
				_addr += '\n'+'Tel: '+r.data.telf1;
			 if(!Ext.isEmpty(r.data.telfx))
				_addr += '\n'+'Fax: '+r.data.telfx;
			 if(!Ext.isEmpty(r.data.email))
				_addr += '\n'+'Email: '+r.data.email;
			 _this.getForm().findField('adr01').setValue(_addr);
			 _this.getForm().findField('adr11').setValue(_addr);
						}else{
							o.markInvalid('Could not find project code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.projectDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigProject.setValue(record.data.jobnr);
			_this.getForm().findField('jobtx').setValue(record.data.jobtx);

			_this.getForm().findField('kunnr').setValue(record.data.kunnr);
			_this.getForm().findField('name1').setValue(record.data.name1);
			_this.getForm().findField('salnr').setValue(record.data.salnr);

			var _addr = record.data.adr01;
			if(!Ext.isEmpty(record.data.distx))
			  _addr += ' '+record.data.distx;
			if(!Ext.isEmpty(record.data.pstlz))
			  _addr += ' '+record.data.pstlz;
			if(!Ext.isEmpty(record.data.telf1))
				_addr += '\n'+'Tel: '+record.data.telf1;
			 if(!Ext.isEmpty(record.data.telfx))
				_addr += '\n'+'Fax: '+record.data.telfx;
			 if(!Ext.isEmpty(record.data.email))
				_addr += '\n'+'Email: '+record.data.email;
			_this.getForm().findField('adr01').setValue(_addr);
			_this.getForm().findField('adr11').setValue(_addr);

			grid.getSelectionModel().deselectAll();
			_this.projectDialog.hide();
		});

		this.trigProject.onTriggerClick = function(){
			_this.projectDialog.show();
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
			url:__site_url+'quotation/load',
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
		this.hdnQtItem.setValue(Ext.encode(rsItem));

		var rsPayment = _this.gridPayment.getData();
		this.hdnPpItem.setValue(Ext.encode(rsPayment));
/*
		this.getForm().getFields().each(function(f){
			console.log(f.name);
    		 if(!f.validate()){
    			 console.log(f.name);
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
			url:__site_url+'quotation/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ vbeln: 0 });
		this.gridPayment.load({ vbeln: 0 });

		// default status = wait for approve
		this.comboQStatus.setValue('01');
	},
	// calculate total functions
	calculateTotal: function(){
		var store = this.gridItem.store;
		var sum = 0;
		store.each(function(r){
			var qty = parseFloat(r.data['menge']),
				price = parseFloat(r.data['unitp']),
				discount = parseFloat(r.data['dismt']);
			qty = isNaN(qty)?0:qty;
			price = isNaN(price)?0:price;
			discount = isNaN(discount)?0:discount;

			var amt = (qty * price) - discount;

			sum += amt;
		});
		this.formTotal.getForm().findField('beamt').setValue(Ext.util.Format.usMoney(sum).replace(/\$/, ''));
		var net = this.formTotal.calculate();

		// set value to grid payment
		this.gridPayment.netValue = net;
	}
});
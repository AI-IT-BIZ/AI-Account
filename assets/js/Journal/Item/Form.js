Ext.define('Account.Journal.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'journal/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		// INIT Customer search popup ///////////////////////////////
		
		this.journalDialog = Ext.create('Account.Journaltemp.MainWindow', {
			disableGridDoubleClick: true
		});
		
		this.gridItem = Ext.create('Account.Journal.Item.Grid_gl',{
			//title:'Invoice Items',
			height: 320,
			region:'center'
		});
		this.formTotal = Ext.create('Account.Journal.Item.Form_t', {
			border: true,
			split: true,
			//title:'Total Invoice',
			region:'south'
		});
		
		this.comboType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Journal Type',
			name : 'ttype',
			labelAlign: 'letf',
			width: 240,
			labelWidth: 90,
			allowBlank : false,
			editable: false,
			triggerAction : 'all',
			clearFilterOnReset: true,
			emptyText: '-- Please Select Type --',
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'journal/loads_jtypecombo',
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'ttype'
					}
				},
				fields: [
					'ttype',
					'typtx'
				],
				remoteSort: true,
				sorters: 'ttype ASC'
			}),
			listeners: {
              select: function(combo, record, index){
                //Ext.Msg.alert('Title',i);
                var value = combo.getValue();
                //_this.trigJournal.load({ttype: value });
              }
            },
			queryMode: 'remote',
			displayField: 'typtx',
			valueField: 'ttype'
		});
		
		this.trigJournal = Ext.create('Ext.form.field.Trigger', {
			name: 'tranr',
			labelAlign: 'letf',
			width:240,
			labelWidth: 90,
			fieldLabel: 'Template Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true//,
			//allowBlank : false
		});
		
		this.hdnTrItem = Ext.create('Ext.form.Hidden', {
			name: 'bsid'
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
			items: [this.hdnTrItem,{
			xtype:'fieldset',
            title: 'Header Data',
            collapsible: true,
            defaultType: 'textfield',
            layout: 'anchor',
            defaults: {
                anchor: '100%'
            },
// Quotation Code            
     items:[{
     	xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'hidden',
			name: 'id'
		},this.comboType,{
			xtype: 'displayfield',
			width:255,
			margins: '0 0 0 6'
		},{
			xtype: 'displayfield',
            fieldLabel: 'Journal Code',
            name: 'belnr',
            value: 'XXXXXX-XXXXX',
            labelAlign: 'right',
			width:240,
            readOnly: true,
			labelStyle: 'font-weight:bold'
		}]

// Journal Template
		},{
            xtype: 'container',
            layout: 'hbox',
            margin: '0 0 5 0',
     items :[this.trigJournal,{
			xtype: 'displayfield',
            name: 'txz02',
            margins: '0 0 0 6',
            width: 255
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
// Description
		},{
            xtype: 'container',
            layout: 'hbox',
            margin: '0 0 5 0',
     items :[ {
     	    xtype: 'textfield',
			fieldLabel: 'Description',
			name: 'txz00',
			labelWidth: 90,
			labelAlign: 'left',
			width:450
		},{
			xtype: 'textfield',
			fieldLabel: 'Reference No',
			name: 'refnr',
			margins: '0 0 0 50',
			width:240
		}]		
        }]
		}]
		};
		
		this.items = [mainFormPanel,this.gridItem,this.formTotal];
		
		// event trigJournal///
		this.trigJournal.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'journaltemp/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.tranr);
							
                            _this.getForm().findField('txz02').setValue(r.data.txz01);
							
						   //---Load PRitem to POitem Grid-----------
			              var tranr = _this.trigJournal.value;
			             // alert(tranr);
			              _this.gridItem.load({tranr1: tranr });
						
						}else{
							o.markInvalid('Could not find Journal Template : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.journalDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigJournal.setValue(record.data.tranr);
			
             _this.getForm().findField('txz02').setValue(record.data.txz01);

			grid.getSelectionModel().deselectAll();
			//---Load PRitem to POitem Grid-----------
			var tranr = _this.trigJournal.value;
			//alert(qtnr);
			_this.gridItem.load({tranr1: tranr });
			_this.journalDialog.hide();
		});

		this.trigJournal.onTriggerClick = function(){
			_this.journalDialog.show();
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
			url:__site_url+'journal/load',
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
		this.hdnTrItem.setValue(Ext.encode(rsItem));
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
        var net = _this.getForm().findField('netwr1').getValue();
		//alert (net);
		if (net==0){
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
		}else{
			Ext.Msg.alert('Balance result not equal');
		}
	},
	
	remove : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'journal/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		//this.gridItem.load({ belnr: 0 });
		//this.gridPayment.load({ vbeln: 0 });
		
		// สร้างรายการเปล่า 5 รายการใน grid item
		this.gridItem.addDefaultRecord();
		this.getForm().findField('bldat').setValue(new Date());

		// default status = wait for approve
		//this.comboQStatus.setValue('05');
		//this.comboCond.setValue('01');
	},
	
	// calculate total functions
	calculateTotal: function(){
		var store = this.gridItem.store;
		var debsum = 0;
		var cresum = 0;
		store.each(function(r){
			var debit = parseFloat(r.data['debit']),
				credit = parseFloat(r.data['credi']);
			debit = isNaN(debit)?0:debit;
			credit = isNaN(credit)?0:credit;

			debsum += debit;
			cresum += credit;
			//sum += amt;
		});
		this.formTotal.getForm().findField('debit')
		.setValue(Ext.util.Format.usMoney(debsum).replace(/\$/, ''));
		this.formTotal.getForm().findField('credi')
		.setValue(Ext.util.Format.usMoney(cresum).replace(/\$/, ''));
		this.formTotal.calculate();
	}
});
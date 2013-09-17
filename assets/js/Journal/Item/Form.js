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
		this.journalDialog = Ext.create('Account.Journaltemp.MainWindow');
		
		this.gridItem = Ext.create('Account.Journal.Item.Grid_gl',{
			//title:'Invoice Items',
			height: 320,
			region:'center'
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
			name: 'trpo'
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
			width:200,
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

// Customer Code
		},{
            xtype: 'container',
            layout: 'hbox',
            margin: '0 0 5 0',
     items :[this.trigJournal,{
			xtype: 'displayfield',
            name: 'txz01',
            margins: '0 0 0 6',
            width: 205
		},{
			xtype: 'textfield',
			fieldLabel: 'Template Name',
			name: 'txz01',
			//anchor:'80%',
			labelAlign: 'right',
			width:350
		}]
// Description
		},{
            xtype: 'container',
            layout: 'hbox',
            margin: '0 0 5 0',
     items :[ {
     	    xtype: 'textfield',
			fieldLabel: 'Description',
			name: 'txz01',
			//anchor:'80%',
			labelAlign: 'right',
			width:350
		},{
			xtype: 'displayfield',
            margins: '0 0 0 6',
            width: 205
		}]		
        }]
		}]
		};
		
		this.items = [mainFormPanel,this.gridItem];
		
		// event trigCustomer///
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
							
                            _this.getForm().findField('txz01').setValue(record.data.txz01);
							
						}else{
							o.markInvalid('Could not find Journal Template : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.customerDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigCustomer.setValue(record.data.kunnr);
			
             _this.getForm().findField('adr11').setValue(_addr);

			grid.getSelectionModel().deselectAll();
			_this.customerDialog.hide();
		});

		this.trigCustomer.onTriggerClick = function(){
			_this.customerDialog.show();
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
			url:__site_url+'journal/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		this.gridItem.load({ belnr: 0 });
		//this.gridPayment.load({ vbeln: 0 });

		// default status = wait for approve
		//this.comboQStatus.setValue('05');
		//this.comboCond.setValue('01');
	},
	
});
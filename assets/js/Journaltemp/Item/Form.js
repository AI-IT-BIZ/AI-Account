Ext.define('Account.Journaltemp.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'journaltemp/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		
		// INIT Customer search popup ///////////////////////////////
		
		this.gridItem = Ext.create('Account.Journaltemp.Item.Grid_gl',{
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
					url: __site_url+'journaltemp/loads_jtypecombo',
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
			margins: '0 0 0 6',
            allowBlank: true
		},{
			xtype: 'displayfield',
            fieldLabel: 'Template Code',
            name: 'tranr',
            //flex: 3,
            value: 'XXXX',
            labelAlign: 'right',
			//name: 'qt',
			width:240,
            readOnly: true,
			labelStyle: 'font-weight:bold'
		}]

// Customer Code
		},{
                xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'displayfield',
            //fieldLabel: '',
            width: 445
		},{
			xtype: 'textfield',
			fieldLabel: 'Template Name',
			name: 'txz01',
			//anchor:'80%',
			labelAlign: 'right',
			width:350,
			allowBlank: false
		}]
        }]
		}]
		};
		
		this.items = [mainFormPanel,this.gridItem];

		return this.callParent(arguments);
	},	
	
	load : function(id){
		var _this=this;
		this.getForm().load({
			params: { id: id },
			url:__site_url+'journaltemp/load',
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
			url:__site_url+'journaltemp/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
	reset: function(){
		this.getForm().reset();

		// สั่ง grid load เพื่อเคลียร์ค่า
		//this.gridItem.load({ tranr: 0 });
		//this.gridPayment.load({ vbeln: 0 });
		
		// สร้างรายการเปล่า 5 รายการใน grid item
		this.gridItem.addDefaultRecord();

		// default status = wait for approve
		//this.comboQStatus.setValue('05');
		//this.comboCond.setValue('01');
	},
	
});
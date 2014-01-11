Ext.define('Account.Saleperson.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'saleperson/save',
			border: false,
			//bodyPadding: 10,
			fieldDefaults: {
				//labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 130,
				//width:300,
				//labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:15px;'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		this.employeeDialog = Ext.create('Account.SEmployee.MainWindow');
		this.trigEmployee = Ext.create('Ext.form.field.Trigger', {
			name: 'empnr',
			labelAlign: 'letf',
			width:240,
			fieldLabel: 'Employee No',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			allowBlank : false
		});
		
		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Sale Person Status',
			name : 'statu',
			//labelAlign: 'right',
			//width: 286,
			editable: false,
			allowBlank : false,
			triggerAction : 'all',
			//margin: '0 0 0 54',
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
		
		this.numberLevf1 = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Level 1',
			name: 'levf1',
			hideTrigger:false,
			emptyText: '0',
			width:250
         });
         this.numberLevf2 = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Level 2',
			name: 'levf2',
			hideTrigger:false,
			emptyText: '0',
			width:250
         });
         this.numberLevf3 = Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Level 3',
			name: 'levf3',
			hideTrigger:false,
			emptyText: '0',
			width:250
         });
         this.numberLevt1 = Ext.create('Ext.ux.form.NumericField', {
			//fieldLabel: 'Credit Limit Amt',
			name: 'levt1',
			hideTrigger:false,
			width:120,
		    margin: '0 0 0 5',
			emptyText: '0'
         });
         this.numberLevt2 = Ext.create('Ext.ux.form.NumericField', {
			//fieldLabel: 'Credit Limit Amt',
			name: 'levt2',
			hideTrigger:false,
			width:120,
		    margin: '0 0 0 5',
			emptyText: '0'
         });
         this.numberLevt3 = Ext.create('Ext.ux.form.NumericField', {
			//fieldLabel: 'Credit Limit Amt',
			name: 'levt3',
			hideTrigger:false,
			width:120,
		    margin: '0 0 0 5',
			emptyText: '0'
         });
         
         this.numberPerc1 = Ext.create('Ext.ux.form.NumericField', {
			//fieldLabel: 'Credit Limit Amt',
			name: 'perc1',
			hideTrigger:false,
			width:50,
		    margin: '0 0 0 145',
			emptyText: '0'
		 });
         this.numberPerc2 = Ext.create('Ext.ux.form.NumericField', {
			//fieldLabel: 'Credit Limit Amt',
			name: 'perc2',
			hideTrigger:false,
			width:50,
		    margin: '0 0 0 145',
			emptyText: '0'
         });
         this.numberPerc3 = Ext.create('Ext.ux.form.NumericField', {
			//fieldLabel: 'Credit Limit Amt',
			name: 'perc3',
			width:50,
		    margin: '0 0 0 145',
			hideTrigger:false,
			emptyText: '0'
         });
         this.numberPerc4 = Ext.create('Ext.ux.form.NumericField', {
			//fieldLabel: 'Credit Limit Amt',
			name: 'percs',
			hideTrigger:false,
			width:50,
		    margin: '0 0 5 20',
			emptyText: '0'
         });
         
         this.numberGoal= Ext.create('Ext.ux.form.NumericField', {
			fieldLabel: 'Special rate',
			name: 'goals',
		    width:250,
		    emptyText: '0'//,
		    //maskRe: /[\d\-]/,
		    //regex: /^\d{6}$/,
		    //regexText: 'Must be in the format Number'
         });
         
         /*---Commission----------------------------*/
		this.radioType = Ext.create('Ext.form.RadioGroup', {
			//xtype: 'radiogroup',
            fieldLabel: 'Comission type',
            cls: 'x-check-group-alt',
            items: [
                {boxLabel: 'Levels', width:70, name: 'ctype', inputValue: 1},
                {boxLabel: 'Step', width:50,  name: 'ctype', inputValue: 2, checked: true}
            ]
		});

/*(2)---Hidden id-------------------------------*/
		this.items = [{
			xtype: 'hidden',
			name: 'id'
		},{
/*(3)---Start Form-------------------------------*/	
/*---Sale Person Head fieldset 1 --------------------------*/
/*------------------------------------------------------*/
xtype:'fieldset',
title: 'Sale Person Head',
//collapsible: true,
defaultType: 'textfield',
layout: 'anchor',
//defaults: {anchor: '100%'},
	items:[{
			xtype: 'container',
            layout: 'hbox',
            margin: '0 0 5 0',
			items :[{
					xtype: 'displayfield',
					fieldLabel: 'Sale Person Code',
					labelWidth: 130,
					name: 'salnr',
					width:200,
					value: 'XXXXX',
					labelStyle: 'font-weight:bold',
					readOnly: true
					},{
					
			}]
	},{
                xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigEmployee,{
			xtype: 'displayfield',
			name: 'name1',
			margins: '0 0 0 6',
			width:350,
            allowBlank: true
		}]
		}]
/*---Sale Person Data fieldset 2--------------------------*/
/*-----------------------------*/
},{
xtype: 'fieldset',
title: 'Commission',
layout: 'anchor',
collapsible: true,
        items: [this.radioType]
/*---Customer Note fieldset 3--------------------------*/
/*-----------------------------------------------------*/
},{
xtype:'fieldset',
title: 'Sale Person Data',
//collapsible: true,
defaultType: 'textfield',
layout: 'anchor',
defaults: {anchor: '100%'},
	items:[{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[{
					xtype: 'displayfield',
		            name: 'qqq',
		            //fieldLabel: '',
					width:250,
		            value: '<span style="color:green; padding-left:180px">From</span>'		
					},{
					xtype: 'displayfield',
		            name: 'www',
		            //fieldLabel: '',
					width:250,
		            value: '<span style="color:green; padding-left:60px">To</span>'		
					},{
					xtype: 'displayfield',
		            name: 'eee',
		            ///fieldLabel: '',
					width:50,
		            value: '<span style="color:green; padding-left:35px">%</span>',
			}]
	/*=======================*/
	},{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[this.numberLevf1,this.numberLevt1,this.numberPerc1]
	/*=======================*/
	},{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[this.numberLevf2,this.numberLevt2,this.numberPerc2]
	/*=======================*/
	},{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[this.numberLevf3,this.numberLevt3,this.numberPerc3]
	/*=======================*/
	},{
	
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[{
					xtype: 'displayfield',
		            name: 'aaa',
		            //fieldLabel: '',
					width:250,
		            value: '<span style="color:green; padding-left:145px">Sale Goal (Baht)</span>'		
					},{
					xtype: 'displayfield',
		            name: 'sss',
		            //fieldLabel: '',
					width:100,
		            value: '<span style="color:green; padding-left:30px">Start Date</span>'		
					},{
					xtype: 'displayfield',
		            name: 'ddd',
		            //fieldLabel: '',
					width:120,
		            value: '<span style="color:green; padding-left:65px">End Date</span>'	
					},{
					xtype: 'displayfield',
		            name: 'fff',
		            fieldLabel: '',
					width:100,
		            value: '<span style="color:green; padding-left:70px">%</span>',
			}]
				
	/*=======================*/
	},{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[this.numberGoal,{
		            xtype: 'datefield',
		            name: 'stdat',
					width:120,
		    		margin: '0 0 5 5',
					format:'d/m/Y',
					altFormats:'Y-m-d|d/m/Y',
					submitFormat:'Y-m-d'
					},{
		            xtype: 'datefield',
		            name: 'endat',
					width:120,
		    		margin: '0 0 5 5',
					format:'d/m/Y',
					altFormats:'Y-m-d|d/m/Y',
					submitFormat:'Y-m-d'
					//allowBlank: false
					},this.numberPerc4]
	}]

/*---End Form--------------------------*/	
},this.comboQStatus];
   // event trigEmployee///
		this.trigEmployee.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'employee/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.empnr);
							_this.getForm().findField('name1').setValue(r.data.name1);
						}else{
							o.markInvalid('Could not find Employee code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.employeeDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigEmployee.setValue(record.data.empnr);
			_this.getForm().findField('name1').setValue(record.data.name1);

			grid.getSelectionModel().deselectAll();
			_this.employeeDialog.hide();
		});

		this.trigEmployee.onTriggerClick = function(){
			_this.employeeDialog.show();
		};     
/*(4)---Buttons-------------------------------*/
		this.buttons = [{
			text: 'Save',
			handler: function() {
				var _form_basic = this.up('form').getForm();
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
			}
		},{
			text: 'Cancel',
			handler: function() {
				this.up('form').getForm().reset();
				this.up('window').hide();
			}
		}];
		
		this.radioType.on('change', this.selectType, this);

		return this.callParent(arguments);
	},


/*(5)---Call Function-------------------------------*/	
	load : function(salnr){
		this.getForm().load({
			params: { salnr: salnr },
			url:__site_url+'saleperson/load'
		});
		this.numberLevf1.setValue(0);
		this.numberLevf1.disable();
	},
	reset: function(){
		this.getForm().reset();

		// default status = wait for approve
		this.comboQStatus.setValue('01');
	},
	remove : function(salnr){
		var _this=this;
		this.getForm().load({
			params: { salnr: salnr },
			url:__site_url+'saleperson/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	
// Type Value
	selectType: function(radio, record){
		var _this=this;
		var selection = record['ctype'];
		//alert(selection);
		
		if(selection==1){
			this.numberLevf2.setValue(0);
			this.numberLevf3.setValue(0);
			this.numberLevf2.disable();
			this.numberLevf3.disable();
		}else{
			this.numberLevf2.enable();
			this.numberLevf3.enable();
		}
	}
});
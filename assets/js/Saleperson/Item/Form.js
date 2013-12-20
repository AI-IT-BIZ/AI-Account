Ext.define('Account.Saleperson.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'saleperson/save',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 130,
				//width:300,
				labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:15px;'
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

/*(1)---ComboBox-------------------------------*/
/*---ComboBox Type-------------------------------*/
		this.comboKtype = Ext.create('Ext.form.ComboBox', {
							
			fieldLabel: 'Type',
			name: 'ktype',
			width:320,
			labelWidth: 180,
			editable: false,
			//allowBlank : false,
			triggerAction : 'all',
			clearFilterOnReset: true,
		    emptyText: '-- Please select data --',
			labelStyle: 'font-weight:normal; color: #000; font-style: normal; padding-left:55px;',		    
			store: new Ext.data.JsonStore({
				proxy: {
					type: 'ajax',
					url: __site_url+'saleperson/loads_combo/ktyp/ktype/custx',  //loads_tycombo($tb,$pk,$like)
					reader: {
						type: 'json',
						root: 'rows',
						idProperty: 'ktype'
					}
				},
				fields: [
					'ktype',
					'custx'
				],
				remoteSort: true,
				sorters: 'ktype ASC'
			}),
			queryMode: 'remote',
			displayField: 'custx',
			valueField: 'ktype'
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
defaults: {anchor: '100%'},
	items:[{
			xtype: 'container',
            layout: 'hbox',
            margin: '0 0 5 0',
			items :[{
					xtype: 'textfield',
					fieldLabel: 'Sale Person Code',
					labelWidth: 130,
					name: 'salnr',
					//flex: 2,
					//anchor:'90%',
					width:200,
					//allowBlank: false
					readOnly: true,
					//disabled: true,
					},{
					xtype: 'textfield',
					fieldLabel: 'Sale Person Name',
					labelWidth: 130,
					name: 'name1',
					//flex: 2,
					//anchor:'90%',
					width:370,
					allowBlank: false
					
			}]
	}]
/*---Sale Person Data fieldset 2--------------------------*/
/*-----------------------------*/
},{
xtype: 'fieldset',
title: 'Commission',
// in this section we use the form layout that will aggregate all of the fields
// into a single table, rather than one table per field.
layout: 'anchor',
defaults: {anchor: '100%'},
collapsible: true,
        items: [{
            xtype: 'radiogroup',
            fieldLabel: 'Comission type',
            cls: 'x-check-group-alt',
            items: [
                {boxLabel: 'Levels', width:70, name: 'ctype', inputValue: 1},
                {boxLabel: 'Step', width:50,  name: 'ctype', inputValue: 2, checked: true}
            ]
        }]
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
		            name: '',
		            fieldLabel: '',
					width:250,
		            value: '<span style="color:green; padding-left:180px">From</span>'		
					},{
					xtype: 'displayfield',
		            name: '',
		            fieldLabel: '',
					width:250,
		            value: '<span style="color:green; padding-left:60px">To</span>'		
					},{
					xtype: 'displayfield',
		            name: '',
		            fieldLabel: '',
					width:50,
		            value: '<span style="color:green; padding-left:35px">%</span>',
			}]
	/*=======================*/
	},{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[{
					xtype: 'textfield',
					fieldLabel: 'Level 1',
					name: '',
					width:250,
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'textfield',
					name: '',
					width:120,
		    		margin: '0 0 0 5',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'hiddenfield',
					name: '',
					width:120,
		    		margin: '0 0 0 5',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'textfield',
					name: '',
					width:50,
		    		margin: '0 0 0 145',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
			}]
	/*=======================*/
	},{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[{
					xtype: 'textfield',
					fieldLabel: 'Level 2',
					name: '',
					width:250,
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'textfield',
					name: '',
					width:120,
		    		margin: '0 0 0 5',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'hiddenfield',
					name: '',
					width:120,
		    		margin: '0 0 0 5',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'textfield',
					name: '',
					width:50,
		    		margin: '0 0 0 145',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
			}]
	/*=======================*/
	},{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[{
					xtype: 'textfield',
					fieldLabel: 'Level 3',
					name: '',
					width:250,
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'textfield',
					name: '',
					width:120,
		    		margin: '0 0 0 5',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'hiddenfield',
					name: '',
					width:120,
		    		margin: '0 0 0 5',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
					xtype: 'textfield',
					name: '',
					width:50,
		    		margin: '0 0 0 145',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
			}]
	/*=======================*/
	},{
	
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[{
					xtype: 'displayfield',
		            name: '',
		            fieldLabel: '',
					width:250,
		            value: '<span style="color:green; padding-left:145px">Sale Goal (Bath)</span>'		
					},{
					xtype: 'displayfield',
		            name: '',
		            fieldLabel: '',
					width:100,
		            value: '<span style="color:green; padding-left:30px">Start Date</span>'		
					},{
					xtype: 'displayfield',
		            name: '',
		            fieldLabel: '',
					width:120,
		            value: '<span style="color:green; padding-left:65px">End Date</span>'	
					},{
					xtype: 'displayfield',
		            name: '',
		            fieldLabel: '',
					width:100,
		            value: '<span style="color:green; padding-left:70px">%</span>',
			}]
				
	/*=======================*/
	},{
			xtype: 'container',
		    layout: 'hbox',
		    margin: '0 0 5 0',
			items :[{
					xtype: 'textfield',
					fieldLabel: 'Special rate',
					name: 'goals',
					width:250,
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            //regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
					},{
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
					},{
					xtype: 'textfield',
					name: 'percs',
					width:50,
		    		margin: '0 0 5 20',
		            emptyText: '0',
		            maskRe: /[\d\-]/,
		            //regex: /^\d{6}$/,
		            regexText: 'Must be in the format Number'
			}]
	}]

/*---End Form--------------------------*/	
}];
/*(4)---Buttons-------------------------------*/
		this.buttons = [{
			text: 'Cancel',
			handler: function() {
				this.up('form').getForm().reset();
				this.up('window').hide();
			}
		}, {
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
		}];

		return this.callParent(arguments);
	},


/*(5)---Call Function-------------------------------*/	
	load : function(salnr){
		this.getForm().load({
			params: { salnr: salnr },
			url:__site_url+'saleperson/load'
		});
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
	}
});
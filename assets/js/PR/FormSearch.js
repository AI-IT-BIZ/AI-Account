Ext.define('Account.PR.FormSearch', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			border: false,
			bodyStyle : 'padding:5px 0px 5px 0px;',
			labelWidth : 80,
			buttonAlign : 'center'
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.searchAct = new Ext.Action({
			text: 'Search',
			iconCls: 'b-small-search',
			handler: function(){
				var formValues = _this.getValues();
				_this.fireEvent('search_click', formValues);
			}
		});
		this.resetAct = new Ext.Action({
			text: 'Reset',
			iconCls: 'b-small-cross',
			handler: function(){
				_this.reset();
				_this.fireEvent('reset_click');
			}
		});

		this.txtQuery = new Ext.form.TextField({
			fieldLabel : 'Keyword',
			name : "query",
			emptyText: 'Find from PR No., Vendor or Reference No.',
			labelAlign: 'right',
			listeners : {
				specialkey : function(o, e) {
					if (e.getKey() == e.ENTER)
						_this.searchAct.execute();
				}
			}
		});

		this.comboQStatus = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Status',
			name : 'statu',
			labelAlign: 'right',
			width: 240,
			editable: false,
			triggerAction : 'all',
			margin: '0 0 0 6',
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

		this.items = [{
			// column layout with 2 columns
			layout:'column',
			border:false,
			// defaults for columns
			defaults:{
				columnWidth:0.5,
				layout:'form',
				border:false,
				xtype:'panel',
				bodyStyle:'padding:0 18px 0 0'
			}
			,items:[{
				// left column
				// defaults for fields
				defaults:{anchor:'100%'},
				items:[this.txtQuery, {
					xtype: 'datefield',
					name: 'bldat',
					hideLabel: false,
					fieldLabel: 'Start Date',
					labelAlign: 'right',
					format:'d/m/Y',
					altFormats:'Y-m-d|d/m/Y',
					submitFormat:'Y-m-d'
				}]
			},{
				// right column
				// defaults for fields
				defaults:{anchor:'100%'},
				items:[this.comboQStatus, {
					xtype: 'datefield',
					name: 'bldat2',
					hideLabel: false,
					fieldLabel: 'End Date',
					labelAlign: 'right',
					format:'d/m/Y',
					altFormats:'Y-m-d|d/m/Y',
					submitFormat:'Y-m-d'
				}]
			}]
		}];

		this.buttons = [this.searchAct, this.resetAct];

		return this.callParent(arguments);
	},
	getValues: function(){
		return this.getForm().getValues();
	},
	reset: function(){
		this.getForm().reset();
	}
});
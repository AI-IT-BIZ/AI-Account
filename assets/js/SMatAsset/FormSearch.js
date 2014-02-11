Ext.define('Account.SMatAsset.FormSearch', {
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
			emptyText: 'Find from Mat/Service/Asset Code, Name or Type',
			labelAlign: 'right',
			listeners : {
				specialkey : function(o, e) {
					if (e.getKey() == e.ENTER)
						_this.searchAct.execute();
				}
			}
		});
		
		var statusOptions = {
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
			valueField: 'statu',
			value: (this.statu)?this.statu:undefined
		};
		if(this.status_options){
			statusOptions = Ext.apply(statusOptions, this.status_options);
		}
		this.comboQStatus = Ext.create('Ext.form.ComboBox', statusOptions);

		this.items = [{
			name: 'ftype',
			xtype: 'hiddenfield'
		},{
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
					xtype: 'textfield',
					name: 'matnr',
					hideLabel: false,
					fieldLabel: 'Material Code',
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
					xtype: 'textfield',
					name: 'matnr2',
					hideLabel: false,
					fieldLabel: 'To',
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
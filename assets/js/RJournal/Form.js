Ext.define('Account.RJournal.Form', {
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
        // INIT Journal search popup ///////////////////////////////////
        this.journalDialog = Ext.create('Account.Journal.MainWindow');
        this.templateDialog = Ext.create('Account.Journaltemp.MainWindow');
		
		this.journalDialog2 = Ext.create('Account.Journal.MainWindow');
        this.templateDialog2 = Ext.create('Account.Journaltemp.MainWindow');
		
		this.trigJournal = Ext.create('Ext.form.field.Trigger', {
			name: 'belnr',
			labelWidth: 100,
			fieldLabel: 'Journal Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigJournal2 = Ext.create('Ext.form.field.Trigger', {
			name: 'belnr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		
		this.trigTemplate = Ext.create('Ext.form.field.Trigger', {
			name: 'tranr',
			labelWidth: 100,
			fieldLabel: 'Template Code',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigTemplate2 = Ext.create('Ext.form.field.Trigger', {
			name: 'tranr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.comboType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Journal Type',
			name : 'ttype',
			labelAlign: 'letf',
			labelWidth: 100,
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
		
		this.comboType2 = Ext.create('Ext.form.ComboBox', {
			name : 'ttype2',
			labelAlign: 'letf',
			labelWidth: 100,
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

		this.items = [{
// Doc Date
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Document Date',
			name: 'bldat1',
			labelWidth: 100,
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			},{
			xtype: 'displayfield',
		    value: 'To',
		    width:40,
		    margins: '0 0 0 25'
		   },{
			xtype: 'datefield',
			name: 'bldat2',
			format:'d/m/Y',
			altFormats:'Y-m-d|d/m/Y',
			submitFormat:'Y-m-d'
			}]
			},{
// Journal Type			
	    xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.comboType,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.comboType2] 
// Journal Code			
       },{
	    xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigJournal,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigJournal2] 
// Template Code		
		},{
	    xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigTemplate,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigTemplate2]
////////////////////////////////////////////////		
		}];
		// event trigJournal///
		this.trigJournal.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'journal/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.belnr);
							
						}else{
							o.markInvalid('Could not find journal code : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		this.trigJournal2.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'journal/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.belnr);
							
						}else{
							o.markInvalid('Could not find journal code : '+o.getValue());
						}
					}
				});
			}
		}, this);


		_this.journalDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigJournal.setValue(record.data.belnr);

			grid.getSelectionModel().deselectAll();
			_this.journalDialog.hide();
		});
		
		_this.journalDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigJournal2.setValue(record.data.belnr);

			grid.getSelectionModel().deselectAll();
			_this.journalDialog2.hide();
		});

		this.trigJournal.onTriggerClick = function(){
			_this.journalDialog.show();
		};
		
		this.trigJournal2.onTriggerClick = function(){
			_this.journalDialog2.show();
		};
		
		// event trigTemplate///
		this.trigTemplate.on('keyup',function(o, e){
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
							
						}else{
							o.markInvalid('Could not find template code : '+o.getValue());
						}
					}
				});
			}
		}, this);
		
		this.trigTemplate2.on('keyup',function(o, e){
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
							
						}else{
							o.markInvalid('Could not find template code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.templateDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigTemplate.setValue(record.data.tranr);

			grid.getSelectionModel().deselectAll();
			_this.templateDialog.hide();
		});
		
		_this.templateDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigTemplate2.setValue(record.data.tranr);

			grid.getSelectionModel().deselectAll();
			_this.templateDialog2.hide();
		});

		this.trigTemplate.onTriggerClick = function(){
			_this.templateDialog.show();
		};
		
		this.trigTemplate2.onTriggerClick = function(){
			_this.templateDialog2.show();
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
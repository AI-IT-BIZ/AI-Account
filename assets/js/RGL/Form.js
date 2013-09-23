Ext.define('Account.RGL.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			//url: __site_url+'quotation/report',
			border: false,
			bodyPadding: 10,
			fieldDefaults: {
				labelAlign: 'left',
				msgTarget: 'qtip',//'side',
				labelWidth: 105
			}
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;
		// INIT GL search popup ///////////////////////////////////
		this.glDialog = Ext.create('Account.GL.MainWindow');
		this.glDialog2 = Ext.create('Account.GL.MainWindow');
		
		this.trigGL = Ext.create('Ext.form.field.Trigger', {
			name: 'saknr',
			labelWidth: 100,
			fieldLabel: 'GL No',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.trigGL2 = Ext.create('Ext.form.field.Trigger', {
			name: 'saknr2',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true
		});
		
		this.comboType = Ext.create('Ext.form.ComboBox', {
			fieldLabel: 'Journal Type',
			name : 'ttype',
			labelAlign: 'letf',
			labelWidth: 100,
			//allowBlank : false,
			//editable: false,
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
			//allowBlank : false,
			//editable: false,
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

// Project Code
        xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[{
			xtype: 'datefield',
			fieldLabel: 'Doc Date',
			labelWidth: 100,
			name: 'bldat1',
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
// Journal Type	
      },{		
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
// GL Code			
       },{
	    xtype: 'container',
                layout: 'hbox',
                margin: '0 0 5 0',
     items :[this.trigGL,
		{xtype: 'displayfield',
		  value: 'To',
		  width:40,
		  margins: '0 0 0 25'
		},
		this.trigGL2]   
		}];	
		
		// event trigGL///
		this.trigGL.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'gl/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.saknr);
							
						}else{
							o.markInvalid('Could not find gl code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.glDialog.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGL.setValue(record.data.saknr);

			grid.getSelectionModel().deselectAll();
			_this.glDialog.hide();
		});

		this.trigGL.onTriggerClick = function(){
			_this.glDialog.show();
		};	
		
		this.trigGL2.on('keyup',function(o, e){
			var v = o.getValue();
			if(Ext.isEmpty(v)) return;

			if(e.getKey()==e.ENTER){
				Ext.Ajax.request({
					url: __site_url+'gl/load',
					method: 'POST',
					params: {
						id: v
					},
					success: function(response){
						var r = Ext.decode(response.responseText);
						if(r && r.success){
							o.setValue(r.data.saknr);
							
						}else{
							o.markInvalid('Could not find gl code : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.glDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGL2.setValue(record.data.saknr);

			grid.getSelectionModel().deselectAll();
			_this.glDialog2.hide();
		});

		this.trigGL2.onTriggerClick = function(){
			_this.glDialog2.show();
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


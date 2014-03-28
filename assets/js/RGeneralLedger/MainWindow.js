Ext.define('RevRec.util.Format', {
    override: 'Ext.util.Format',
    originalNumberFormatter: Ext.util.Format.number,
    number: function(v, formatString) {
        if (v < 0) {
            //negative number: flip the sign, format then prepend '-' onto output
            return '-' + this.originalNumberFormatter(v * -1, formatString);
        } else {
            //positive number: as you were
            return this.originalNumberFormatter(v, formatString);
        }
    }
});
Ext.define('Account.RGeneralLedger.MainWindow', {
	extend	: 'Ext.window.Window',
	title: 'Report General Ledger',
	closeAction: 'hide',
	width: 320,
	height: 220,
	resizable: false,
	modal: true,
	layout:'fit',
	maximizable: false,
	loadMask: null,
	initComponent:function(config) {
		var _this = this;

		this.loadMask = new Ext.LoadMask(Ext.getBody(), {msg:"Please wait..."}),

		this.glnoDialog1 = Ext.create('Account.GL.MainWindow');

		this.trigGlno1 = Ext.create('Ext.form.field.Trigger', {
			name: 'start_saknr',
			fieldLabel: 'Start GL',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			//width:290,
		});

		// event trigGlno1//
		this.trigGlno1.on('keyup',function(o, e){

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
							_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

						}else{
							o.markInvalid('Could not find GL Account : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.glnoDialog1.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGlno1.setValue(record.data.saknr);

			grid.getSelectionModel().deselectAll();
			_this.glnoDialog1.hide();
		});

		this.trigGlno1.onTriggerClick = function(){
			_this.glnoDialog1.show();
		};
		/////
		this.glnoDialog2 = Ext.create('Account.GL.MainWindow');

		this.trigGlno2 = Ext.create('Ext.form.field.Trigger', {
			name: 'end_saknr',
			fieldLabel: 'End GL',
			triggerCls: 'x-form-search-trigger',
			enableKeyEvents: true,
			//width:290,
		});

		// event trigGlno2//
		this.trigGlno2.on('keyup',function(o, e){

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
							_this.getForm().findField('sgtxt').setValue(record.data.sgtxt);

						}else{
							o.markInvalid('Could not find GL Account : '+o.getValue());
						}
					}
				});
			}
		}, this);

		_this.glnoDialog2.grid.on('beforeitemdblclick', function(grid, record, item){
			_this.trigGlno2.setValue(record.data.saknr);

			grid.getSelectionModel().deselectAll();
			_this.glnoDialog2.hide();
		});

		this.trigGlno2.onTriggerClick = function(){
			_this.glnoDialog2.show();
		};


		var form =  Ext.create('Ext.form.Panel', {
			layout: 'form',
			bodyPadding: '15 15 15 15',
			fieldDefaults: {
				labelWidth: 70
			},
			frame: true,
			items: [{
				xtype: 'datefield',
				fieldLabel: 'Start Date',
				name: 'start_date',
				format: 'Y-m-d',
				allowBlank: false
			},{
				xtype: 'datefield',
				fieldLabel: 'End Date',
				name: 'end_date',
				format: 'Y-m-d',
				allowBlank: false
			},this.trigGlno1,this.trigGlno2],
			buttons: [{
				text: 'Report',
				handler: function(){
					form = this.up('form').getForm();
					_this.loadMask.show();
					if (form.isValid()){
						Ext.Ajax.request({
							url: __base_url + "index.php/rgeneralledger/result",
							params: form.getValues(),
							success: function(response){
								var rs = response.responseText;
								rs =  Ext.JSON.decode(rs);
								if (rs.success) {
									var result = Ext.create("Account.RGeneralLedger.Result.Grid");
									result.params = form.getValues();
									result.storeGrid.loadData(rs.datas);
									result.show();
								}
								_this.loadMask.hide();
							}
						});
					}
				}
			},{
				text: 'Cancel',
				handler: function(){
					form = this.up('form').getForm();
					form.reset();
				}
			}]
		});
		this.items = [form];
		return this.callParent(arguments);
	}
});
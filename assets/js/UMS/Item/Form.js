Ext.define('Account.UMS.Item.Form', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {

		Ext.apply(this, {
			url: __site_url+'ums/save',
			layout: 'border',
			border: false
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.grid = Ext.create('Account.UMS.Item.GridPermission', {
			region:'center',
			title: 'Permission settings'
		});

		this.gridLimit = Ext.create('Account.UMS.Item.GridLimit', {
			region:'east',
			title: 'Approve limit amount settings',
			width: 250,
			split: true
		});

		var dispEmployeeCode = Ext.create('Ext.form.field.Display', {
			fieldLabel: 'Employee',
			labelWidth: 65,
			name:'empnr',
			labelAlign:'right'
		});

		var dispEmployee = Ext.create('Ext.form.field.Display', {
			fieldLabel: 'Name',
			labelWidth: 65,
			name:'name1',
			labelAlign:'right'
		});

		var dispUsername = Ext.create('Ext.form.field.Display', {
			fieldLabel: 'Username',
			labelWidth: 65,
			name: 'uname',
			labelAlign:'right'
		});

		var mainFormPanel = {
			title: 'User description',
			xtype: 'panel',
			border: true,
			region:'west',
			split: true,
			width: 230,
			bodyPadding: '5 5 0 5',
			defaults: {
				labelAlign: 'right',
				msgTarget: 'qtip',
				labelWidth: 65,
				width: 200
			},
			items: [
				dispEmployeeCode,
				dispEmployee,
				dispUsername,
			{
				xtype: 'hiddenfield',
				name: 'uname'
			},{
				xtype: 'textfield',
				fieldLabel: 'Password',
				inputType: 'password',
				name: 'passw',
				allowBlank: false
			}]
		};

		this.items = [
			mainFormPanel,
			this.grid,
			this.gridLimit
		];

		// event
		this.grid.store.on('load', function(store, records){
			// สั่ง grid limit load หลังจากที่ grid permission load เสร็จแล้ว
			_this.loadGridLimit();
		});

		this.grid.on('cellclick', function (grid, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
			_this.filterGridLimit();
		});

		return this.callParent(arguments);
	},
	form_params: null,
	load : function(id){
		var _this=this;

		_this.form_params = { id: id };

		this.getForm().load({
			params: _this.form_params,
			url:__site_url+'ums/load',
			success: function(form, act){
				_this.fireEvent('afterLoad', form, act);
			}
		});

		// สั่ง grid permission load
		this.grid.load({
			uname: id
		});
	},
	save : function(){
		var _this=this;
		var _form_basic = this.getForm();

		// add grid data to json
		var rsItem = this.grid.getData();
		var rsLimitItem = this.gridLimit.getData();

		var form_params = Ext.apply(_this.form_params, {
			autx: Ext.encode(rsItem),
			autl: Ext.encode(rsLimitItem)
		});

		if (_form_basic.isValid()) {
			_form_basic.submit({
				clientValidation: true,
				waitMsg: 'Update user, please wait...',
				params: form_params,
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
			url:__site_url+'quotation/remove',
			success: function(res){
				_this.fireEvent('afterDelete', _this);
			}
		});
	},
	reset: function(){
		this.getForm().reset();

		// สั่ง grid permission load
		this.grid.load({
			uname: '-1'
		});
		// สั่ง grid limit load
		this.gridLimit.load({
			uname: -1
		});
	},
	filterGridLimit: function(){
		// filter grid
		var approvable = this.grid.getDocTypeApprovable();
		this.gridLimit.store.filterBy(function(r) {
			var is_match = false;
			for(var i=0;i<approvable.length;i++){
				if(r.data['docty']==approvable[i]){
					is_match = true; break;
				}
			}
			return is_match;
		});

	},
	loadGridLimit: function(){
		var _this=this;
		this.gridLimit.load({
			uname: this.form_params.id
		},
		this.filterGridLimit,
		this);
	}
});
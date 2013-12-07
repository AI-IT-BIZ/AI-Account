Ext.define('Account.Invoice.Item.PreviewWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Invoice preview',
			closeAction: 'hide',
			height: 600,
			width: 830,
			minHeight: 600,
			minWidth: 830,
			layout: 'border',
			border: false,
			resizable: true,
			modal: true,
			buttonAlign:'center'
		});

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [new Ext.Panel({
			region:'center',
			border: true,
			items:[{
				xtype: 'component',
				id: 'preview_frame',
		        autoEl: {
					tag: 'iframe',
					src: 'about:blank',
					frameBorder: 0,
					width: '100%',
					height: '100%',
					style: {
						overflow: 'auto'
					}
		     	}
			}]
        })];

        this.copies = new Ext.form.NumberField({
        	name:'copies',
        	allowBlank: false,
        	allowDecimals : false,
        	allowNegative : false,
        	fieldLabel: 'Copies',
        	labelAlign: 'right',
        	labelWidth: 60,
        	value: 1,
        	minValue: 1, maxValue:500,
        	width: 130
        });

		this.btnPrint = Ext.create('Ext.Button', {
			text: 'Print',
			handler: function() {
				var id = 'preview_frame';
				var iframe = document.frames ? document.frames[id] : document.getElementById(id);
				var ifWin = iframe.contentWindow || iframe;
				iframe.focus();
				ifWin.do_print();
			}
		});

		this.buttons = [
			this.copies,
			this.btnPrint
		];

		this.on('hide', function(){
			Ext.get('preview_frame').set({
				src:'about:blank'
			});
			this.copies.setValue(1);
		});

		this.copies.on('change', function(copies, newVal, oldVal){
			_this.showFrameLoad();
			Ext.get('preview_frame').set({
				src:_this.getFrameUrl(_this.dialogId, newVal)
			});
			_this.checkFrameReady(function(){
				_this.hideFrameLoad();
			});
		});

		return this.callParent(arguments);
	},
	dialogId: null,
	openDialog:function(id){
		var _this=this;
		if(id){
			this.dialogId = id;
			this.show(false, function(){
				Ext.get('preview_frame').set({
					src:_this.getFrameUrl(id, _this.copies.getValue())
				});
				_this.showFrameLoad();
				_this.checkFrameReady(function(){
					_this.hideFrameLoad();
				});
			});
		}
	},
	getFrameUrl: function(id, copies){
		copies = copies || 1;
		return __site_url+'form/invoice/index/'+id+'/'+copies;
	},
	checkFrameReady: function(cb){
		document.getElementById('preview_frame').onload = cb;
	},
	showFrameLoad: function(){
        Ext.MessageBox.show({
           msg: 'Populating preview...',
           progressText: 'Loading...',
           width:300,
           wait:true,
           waitConfig: {interval:200},
           animateTarget: this
       });
	},
	hideFrameLoad: function(){
		Ext.MessageBox.hide();
	}
});
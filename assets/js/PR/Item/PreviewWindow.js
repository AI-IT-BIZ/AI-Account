Ext.define('Account.PR.Item.PreviewWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Purchase requisitions preview',
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

		this.form = Ext.create('Account.PR.Item.Form',{ region:'center' });
/*
		this.items = [new Ext.Panel({
			bodyCfg: {
	        	tag: 'div',
				cls: 'x-panel-body',
				children: [{
					tag: 'iframe',
					name: 'preview_frame',
					id: 'preview_frame',
					src: 'about:blank',
					frameBorder: 0,
					width: '100%',
					height: '100%',
					style: {
						overflow: 'auto'
					}
				}]
			},
			region:'center'}
		)];
*/
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

		this.buttons = [{
			text: 'Print',
			handler: function() {
				var id = 'preview_frame';

				var iframe = document.frames ? document.frames[id] : document.getElementById(id);
				var ifWin = iframe.contentWindow || iframe;
				iframe.focus();
				ifWin.do_print();
			}
		}];

		this.on('hide', function(){
			Ext.get('preview_frame').set({
				src:'about:blank'
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
					src:__site_url+'form/pr/index/'+id
				});
			});
		}
	}
});
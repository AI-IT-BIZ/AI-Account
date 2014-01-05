Ext.define('Account.RIncome.Item.PreviewWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {

		Ext.apply(this, {
			title: 'Income Statement preview',
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

		this.on('hide', function(){
			Ext.get('preview_frame').set({
				src:'about:blank'
			});
		});


		return this.callParent(arguments);
	},
	dialogId: null,
	openDialog:function(url){
		var _this=this;
		if(url){
			this.show(false, function(){
				Ext.get('preview_frame').set({
					src:url
				});
				_this.showFrameLoad();
				_this.checkFrameReady(function(){
					_this.hideFrameLoad();
				});
			});
		}
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
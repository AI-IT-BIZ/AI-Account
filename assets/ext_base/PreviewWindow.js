Ext.define('BASE.PreviewWindow', {
	extend	: 'Ext.window.Window',

	// default attributes
	title: 'รายงาน',
	closeAction: 'hide',
	height: 600,
	width: 830,
	minHeight: 600,
	minWidth: 830,
	layout: 'border',
	border: false,
	resizable: true,
	modal: true,
	buttonAlign:'center',
	// end default

	iframe_id: null, // private
	enableCopies: true,
	constructor:function(config) {
		var _this=this;

		this.iframe_id = 'preview_frame_'+Ext.id();

		if(this.enableCopies){
			this.openDialog = function(form_values){
				if(form_values && !Ext.isEmpty(form_values)){
					_this.dialogParams = form_values;
					_this.show(false, function(){
						var frameUrl = _this.getFrameUrl(form_values, _this.copies.getValue());
						_this.setFrameSrc(frameUrl);
						_this.showFrameLoad();
						_this.checkFrameReady(function(){
							_this.hideFrameLoad();
						});
					});
				}
			};
		}else{
			this.openDialog = function(url){
				if(url){
					_this.show(false, function(){
						_this.setFrameSrc(url);
						_this.showFrameLoad();
						_this.checkFrameReady(function(){
							_this.hideFrameLoad();
						});
					});
				}
			};
		}

		return this.callParent(arguments);
	},
	initComponent : function() {
		var _this=this;

		this.items = [new Ext.Panel({
			region:'center',
			border: false,
			items:[{
				xtype: 'component',
				id: this.iframe_id,
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

		if(this.enableCopies){
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
					var id = _this.iframe_id;
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
		}

		this.on('hide', function(){
			_this.setFrameSrc('about:blank');
			if(this.enableCopies)
				this.copies.setValue(1);
		});


		if(this.enableCopies){
			this.copies.on('change', function(copies, newVal, oldVal){
				_this.showFrameLoad();
				Ext.get(_this.iframe_id).set({
					src:_this.getFrameUrl(_this.dialogParams, newVal)
				});
				_this.checkFrameReady(function(){
					_this.hideFrameLoad();
				});
			});
		}

		return this.callParent(arguments);
	},
	dialogParams: null,
	getFrameUrl: null, // must be implement if - enableCopies==true
	/*getFrameUrl: function(params, copies){
		copies = copies || 1;
		var q_str = '';
		params['copies'] = copies;
		return __site_url+'form/rsumvat/index?'+Ext.urlEncode(params);
	},*/
	setFrameSrc: function(url){
		Ext.get(this.iframe_id).set({
			src: url
		});
	},
	checkFrameReady: function(cb){
		document.getElementById(this.iframe_id).onload = cb;
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
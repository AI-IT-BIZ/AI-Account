Ext.define('Account.Configauthen.WinUserDefine', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {
	   
          
     var UserDefine = Ext.create('Account.Configauthen.UserDefine',{ region:'center' });
    
       
       	Ext.apply(this, {
		   title: 'Config Authen',
   	       closeAction: 'hide',
           height: 600,
           minHeight: 570,
           width: 800,
           minWidth: 750,
           resizable: false,
           modal: true,
           layout:'hbox',
           maximizable: false,
           items:[UserDefine],
           buttons:[]
		});
        
        /*Event******************************************/
        
        
        /******************************************/
		return this.callParent(arguments);
        
	
	}
});   
Ext.define('Account.Configauthen.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {
	   
          var nodeUserAuthen = {
				text: 'User Authen',
				leaf: true
			};
			var nodeDocLimitAmount= {
			    text: 'Document limit amount',
				leaf: true
			};

			var groupNodeAuthen = {
				text: 'ConfigAuthen',
				leaf: false,
				expanded: true,
				singleClickExpand : true,
				children: [
					nodeUserAuthen,
					nodeDocLimitAmount
				]
			};
       // Ext.create('Ext.grid.Panel',
       	var tree = Ext.create('Ext.tree.TreePanel',{
				region: 'west',
				collapsible: false,
				width: 230,
				autoScroll: true,
				split: true,
				useArrows:true,
				rootVisible: false,
				root: {
					expanded: true,
					children: [
						groupNodeAuthen
						
					]
				}
	   });
       
        var LeftPanel =  Ext.create('Ext.Panel', {
        layout: 'fit',
        //frame: true,    
        width:200,
        height: 600,
        items:[tree]
      
     }); 
     var UserDefine = Ext.create('Account.Configauthen.UserDefine',{ region:'center' });
     var PanelAuthenDoc = Ext.create('Account.Configauthen.PanelAuthenDoc',{ region:'center' });
     var RightPanel =  Ext.create('Ext.Panel', {
        layout: 'fit',
        //frame: true,    
       // width:800,
       // height: 600,
        items:[UserDefine,PanelAuthenDoc]
      
     }); 
       
       	Ext.apply(this, {
		   title: 'Config Authen',
   	       closeAction: 'hide',
           height: 600,
           minHeight: 570,
           width: 1000,
           minWidth: 750,
           resizable: false,
           modal: true,
           layout:'hbox',
           maximizable: false,
           items:[LeftPanel,RightPanel],
           buttons:[]
		});
        
        /*Event******************************************/
        
          tree.on('cellclick', function (tree, td, cellIndex, rec, tr, rowIndex, e, eOpts ) {
         
            //  alert(tr.innerHTML);
         
              
               if(tr.innerHTML.indexOf('Document limit amount') > -1)
               {
                
                    UserDefine.setVisible( false );
                    PanelAuthenDoc.setVisible( true );
                    return;
               }
               if(tr.innerHTML.indexOf('User Authen') > -1)
               {
                
                    UserDefine.setVisible( true );
                    PanelAuthenDoc.setVisible( false );
                    return;
               }
         
              
            });
        
        /******************************************/
		return this.callParent(arguments);
        
	
	}
});
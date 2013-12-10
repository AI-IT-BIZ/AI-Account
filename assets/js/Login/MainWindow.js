Ext.define('Account.Login.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {
	       /*************************************/
           
           
    var _this=this;
    
    var store_company = Ext.create('Ext.data.ArrayStore', {
        fields: [
                 { name: 'comid', type: 'string' },
                 { name: 'name1', type: 'string' }
        ], sortInfo: { field: 'name1', direction: 'ASC' }
    });
    
    var lblCompany = Ext.create('Ext.form.Label', {
        layout: 'absolute',
        x:20,
        y:20,
        text:'Company :'
        
      });
    
    var lblUserName = Ext.create('Ext.form.Label', {
        layout: 'absolute',
        x:20,
        y:55,
        text:'User   :'
        
      });
      
      var lblPassword = Ext.create('Ext.form.Label', {
        layout: 'absolute',
        x:20,
        y:90,
        text:'Password :'
      });
      
      
      
    
     var cbCompany = Ext.create('Ext.form.ComboBox', {
        rtl: false,
        x:80,
        y:15,
        width: 200,
        emptyText: 'Company',
        triggerAction: 'all',
        lazyRender: true,
        selectOnFocus: true,
        queryMode: 'local',
        displayField: 'name1',
        valueField: 'comid',
        store: store_company
    });
    
    
    var txtUserName = Ext.create('Ext.form.Text', {
       // id:'txtUserName-Login-MainWindow',
        layout: 'absolute',
        width: 200,
        x:80,
        y:50
      });
      
    var txtPassword = Ext.create('Ext.form.Text', {
      //  id:'txtPassword-Login-MainWindow',
        layout: 'absolute',
        inputType: 'password',
        x:80,
        y:85,
        width: 200
    });
    
    var lblLoginError = Ext.create('Ext.form.Label', {
        layout: 'absolute',
       style: {color: 'red' },
        x:20,
        y:145,
        hidden:true,
        text:'*Invalid UserName/Password*'
      });
    
    var btnLogin=  Ext.create('Ext.Button', {
        text: 'Login',
        x:110,
        y:120,
        width: 80,
        handler: function() {
 
                CheckLogin();
	      
        }
    });
    
     var btnReset=  Ext.create('Ext.Button', {
        text: 'Reset',
        x:200,
        y:120,
        width: 80,
        handler: function() {
           
	       GetReset();
        }
    
    });
    
    var form_login =  Ext.create('Ext.form.Panel', {
        layout: 'absolute',
        frame: true,    
        width: 320,
        height: 200,
        items:[lblCompany,cbCompany ,lblUserName , txtUserName ,lblPassword ,txtPassword , lblLoginError,btnLogin,btnReset]
      
      });
       
        
        /******************************************************************************/
        
      
        function GetReset()
        {
            cbCompany.reset();
            txtUserName.setValue('');
            txtPassword.setValue('');
            lblLoginError.setVisible(false);
        }
        function GetCompany()
        {
            Ext.Ajax.request ({
            url: __site_url +  'login/GetCompany' ,
            disableCaching: false ,
            success: function (res) {
   
                     var arrCompany = res.responseText.split('|');
                     var detail = arrCompany;
                     var data;
                     var myData = new Array();
                     var i;
                     var strTemp;
                     if (detail != '') {
                        for (i = 0; i < arrCompany.length; i++) {
                            data = new Array();
                            strTemp = arrCompany[i].split('+')
                            data[0] = strTemp[0];
                            data[1] = strTemp[1];
                            myData[i] = data;
                        }
                     }
                     else {
                            data = new Array();
                            myData = data;
                     }
                     store_company.loadData(myData);
            
                  }
            });
           
         }
         function CheckLogin()
         {
             var comid = cbCompany.getValue();
             var uname = txtUserName.getRawValue();
             var passw = txtPassword.getRawValue();
           
             Ext.Ajax.request ({
             url: __site_url +  'login/CheckLogin?uname=' + uname + '&passw=' + passw + '&comid=' + comid ,
             disableCaching: false ,
             success: function (res) {
                   GetResultLogin(res.responseText);
                }
             });
             
         }
         function GetResultLogin(strData)
         {
           
            if(strData != "")
            {
                
                 arrPermit = new Array();
                 var arrData = strData.split("|");
                 var strTemp;
                 for (i = 0; i < arrData.length; i++) 
                 {
                    strTemp =  arrData[i].split('+')
                    arrPermit[strTemp[3]] = new Array(5);
                    arrPermit[strTemp[3]] ['display'] = strTemp[4];
                    arrPermit[strTemp[3]] ['create'] = strTemp[5];
                    arrPermit[strTemp[3]] ['edit'] = strTemp[6];
                    arrPermit[strTemp[3]] ['delete'] = strTemp[7];
                    arrPermit[strTemp[3]] ['export'] = strTemp[8];
                    arrPermit[strTemp[3]] ['approve'] = strTemp[9];
                 }
                Ext.getCmp('lblUserName-default').setText('User Name : ' + strTemp[1]);
               // alert(arrPermit['PD']['approve']);
                 lblLoginError.setVisible(false);
                 _this.hide();
            }
            else{
              lblLoginError.setVisible(true);
            }
           

         }
        /*************************************/ 
        GetCompany();
        
        /*************************************/
        
        /************************************/
  		   Ext.apply(this, {
		   title: 'Login',
   	       closeAction: 'hide',
           width: 320,
           height: 220,
           resizable: false,
           modal: true,
           layout:'fit',
           maximizable: false,
           items:[form_login],
           buttons:[]
		});

		return this.callParent(arguments);
        
	
	}
});
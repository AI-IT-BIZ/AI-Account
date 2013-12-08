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
    
    var btnLogin=  Ext.create('Ext.Button', {
        text: 'Login',
        x:110,
        y:120,
        width: 80,
        handler: function() {
 
                 Login();
	      
        }
    });
    
     var btnReset=  Ext.create('Ext.Button', {
        text: 'Reset',
        x:200,
        y:120,
        width: 80,
        handler: function() {
            document.getElementById("div-rpr").style.visibility="hidden";
	      // GetReset();
        }
    
    });
    
    var form_login =  Ext.create('Ext.form.Panel', {
        layout: 'absolute',
        frame: true,    
        width: 320,
        height: 200,
        items:[lblCompany,cbCompany ,lblUserName , txtUserName ,lblPassword ,txtPassword ,btnLogin,btnReset]
      
      });
       
        
        /******************************************************************************/
        
       function AjaxCaller()
       {
         var xmlhttp=false;
         try{
             xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
         }catch(e){
             try{
                 xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
             }catch(E){
                xmlhttp = false;
             }
          }

         if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
            xmlhttp = new XMLHttpRequest();
           }
         return xmlhttp;
       }
       function callPage(url, func , param){
          ajax=AjaxCaller(); 
          ajax.open("GET", url + func + param, true); 
          ajax.onreadystatechange=function(){
          if(ajax.readyState==4){
            if(ajax.status==200){
                switch (func)
                {
                    case "GetCompany":
                          GetCompany(ajax.responseText);
                          break;
                    case "Login":
                          GetResultLogin(ajax.responseText);
                          break;
                    
                }
            }
          }
         }
         ajax.send(null);
        }
        function GetReset()
        {
            cbCompany.reset();
            txtUserName.setValue('');
            txtPassword.setValue('');
        }
        function GetCompany(strResult)
        {
           
            var arrCompany = strResult.split('|');
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
         function Login()
         {
             var comid = cbCompany.getValue();
             var uname = txtUserName.getRawValue();
             var passw = txtPassword.getRawValue();
             callPage(__site_url + "Login?func=","Login","&uname=" + uname + "&passw=" + passw + "&comid=" + comid);
         }
         function GetResultLogin(strData)
         {
            if(strData != "")
            {
                 var arrData = strData.split("|");
                 var strTemp;
                 for (i = 0; i < arrData.length; i++) 
                 {
                    strTemp =  arrData[i].split('+')
                    if(strTemp[4] == "0")
                    {
                        
                        switch(strTemp[3])
                        {
                           case "IP": document.getElementById("div-apxx").style.backgroundColor   = "#484848 ";
                                      document.getElementById("div-apxx").style.visibility = "visible";
                                      document.getElementById("div-ap").style.visibility="hidden";
                                      
                                     // var div = document.createElement('div');
                                     // div.setAttribute('class', 'box box-red'); 
                                    //  document.body.appendChild(div);
                                      break;
                        }                  
                       
                    }
                 }

                // Global_comid = arrData[0];
                // Global_uname = arrData[1];
                // Global_passw = arrData[2];
            }
            _this.hide();

         }
        /*************************************/ 
         callPage(__site_url + "Login?func=","GetCompany","");
        
        /*************************************/
        
        /************************************/
  		   Ext.apply(this, {
		   title: 'Login',
   	       closeAction: 'hide',
           width: 320,
           height: 200,
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
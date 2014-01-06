Ext.define('Account.ChartOfAccounts.MainWindow', {
	extend	: 'Ext.window.Window',
	constructor:function(config) {
	 
    var treid_edit = ""; 
       
    var store_chart_account = Ext.create('Ext.data.ArrayStore', {
        fields: [{ name: 'treid', type: 'string' },
                 { name: 'level', type: 'string' },
                 { name: 'text1', type: 'string' },
                 { name: 'leaf1', type: 'string' },
                 { name: 'child', type: 'string' },
                 { name: 'accid', type: 'string' },
                 { name: 'tname', type: 'string' },
                 { name: 'ename', type: 'string' },
                 { name: 'accty', type: 'string' },
                 { name: 'accgr', type: 'string' },
                 { name: 'deptx', type: 'string' },
                 { name: 'glgrp', type: 'string' }
        ], sortInfo: { field: 'treid', direction: 'ASC' }
    });
    
    var store_account_group = Ext.create('Ext.data.Store',{
    	fields: ['group','name'],
    	data: [
    		{"group":"1", "name":"สินทรัพย์"},
    		{"group":"2", "name":"หนี้สิน"},
    		{"group":"3", "name":"ส่วนของเจ้าของ"},
    		{"group":"4", "name":"รายได้"},
    		{"group":"5", "name":"ค่าใช้จ่าย"}
    	], 
    	sortInfo: {field: 'group', direction: 'ASC'}
    });
    
    var store_group_account = Ext.create('Ext.data.ArrayStore',{
        fields: [{ name: 'treid', type: 'string' },
                 { name: 'accid', type: 'string' }
        ], sortInfo: { field: 'accid', direction: 'ASC' }
    });
    
    var store_department = Ext.create('Ext.data.ArrayStore', {
        fields: [{ name: 'depid', type: 'string' },
                 { name: 'deptx', type: 'string' }
        ], sortInfo: { field: 'deptx', direction: 'ASC' }
    });
        
      
    var store_tree_chart = Ext.create('Ext.data.TreeStore', {
        //model: 'Post',
       // autoLoad:false,
        proxy: {
            type: 'ajax',
            reader: 'json',
            url: __site_url+ 'chartofaccounts/GetTreeChart'
        }
        //,lazyFill: true
    });
       var tree = Ext.create('Ext.tree.Panel',{
			//	region: 'west',
			  //  collapsible: true,
              
                loadMask: true,
				width: 230,
				autoScroll: true,
			//	split: true,
				useArrows:true,
				rootVisible: false,
			    store: store_tree_chart
	   });
       
       //treexx.load();
       
       var LeftPanel =  Ext.create('Ext.Panel', {
           layout: 'fit',
         //frame: true,    
           width:550,
           height: 440,
           items:[tree]
      
       }); 
       
         var loadMask = new Ext.LoadMask(LeftPanel, {msg:'Wait message', store: store_tree_chart});
       /*************************************************************/
        var txtID = Ext.create('Ext.form.Text', {
         	fieldLabel: 'GL No',
            layout: 'absolute',
            fieldStyle: 'text-align: left;',
            width: 300,
            x:50,
            y:25
      });
      
       var txtNameT = Ext.create('Ext.form.TextArea', {
         	fieldLabel: 'Name Thai',
            layout: 'absolute',
            fieldStyle: 'text-align: left;',
            width: 300,
            height:60,
            x:50,
            y:55
      });
      
       var txtNameE = Ext.create('Ext.form.TextArea', {
         	fieldLabel: 'Name Eng',
            layout: 'absolute',
            fieldStyle: 'text-align: left;',
            width: 300,
            height:60,
            x:50,
            y:125
      });
     
      
      
      var rdSmallAccount = Ext.create('Ext.form.Radio', {
        fieldLabel: 'Account Type',
          x:50,
          y:195,
          boxLabel  : 'Sub Account',
         // name      : 'size',
          checked: true,
          inputValue: '2'
      });
       var rdGroupAccount = Ext.create('Ext.form.Radio', {
          x:280,
          y:195,
          boxLabel  : 'Group Account',
         // name      : 'size',
          inputValue: '1'
      });
      
      var cbAccount = Ext.create('Ext.form.ComboBox', {
        rtl: false,
        fieldLabel: 'Account Group',
        x:50,
        y:225,
        width: 300,
        emptyText: 'Select Account Group',
        triggerAction: 'all',
        lazyRender: true,
        selectOnFocus: true, 
        store: store_account_group,
        queryMode: 'local',
        displayField: 'name',
        valueField: 'group'
      
    });
      
       var cbAccountGroup = Ext.create('Ext.form.ComboBox', {
        rtl: false,
        fieldLabel: 'Account Under',
        x:50,
        y:255,
        width: 300,
        emptyText: 'Select Account',
        triggerAction: 'all',
        lazyRender: true,
        selectOnFocus: true, 
        store: store_group_account,
        queryMode: 'local',
        displayField: 'accid',
        valueField: 'treid'
      
    });
    
     var cbDepartment = Ext.create('Ext.form.ComboBox', {
        rtl: false,
        fieldLabel: 'Department',
        x:50,
        y:285,
        width: 300,
        emptyText: 'Select Department',
        triggerAction: 'all',
        lazyRender: true,
        selectOnFocus: true, 
        store: store_department,
        queryMode: 'local',
        displayField: 'deptx',
        valueField: 'depid'
      
    });
    
     var btnSave =  Ext.create('Ext.Button', {
         text: 'Save',
         width:80,
         x:180,
         y:320,
         handler: function() {
                   
                  SaveData();
                 
        }
     }); 


    var btnCancel =  Ext.create('Ext.Button', {
         text: 'Cancel',
         width:80,
         x:270,
         y:320,
         handler: function() {
                    GetDisable();
                    GetReset();
                    btnEdit.setDisabled(true);
        }
     }); 
       
     var btnAdd =  Ext.create('Ext.Button', {
         text: 'Add',
         iconCls: 'b-small-plus',
         width:60,
         disable: !UMS.CAN.CREATE('CA'),
         handler: function() {
                   txtID.setReadOnly(false);
                   GetEnable(); 
                   btnEdit.setDisabled(true); 
                   GetReset();     
        }
     }); 
      
      var btnEdit =  Ext.create('Ext.Button', {
         text: 'Edit',
         iconCls: 'b-small-pencil',
         width:60,
         handler: function() {
                    if(txtID.getRawValue() != "")
                    {
                         GetEnable();  
                    }
                       
        }
     });
     
     var btnImport = Ext.create('Ext.Button',{
     	text: 'Import',
     	iconCls: 'b-small-import',
     	width:60,
     	disable: !UMS.CAN.CREATE('CA'),
     	handler: function() {
     		this.importDialog = Ext.create('Account.ChartOfAccounts.Import.Window');
			this.importDialog.show();
     	}
     }); 
       
        var RightPanel =  Ext.create('Ext.Panel', {
   		bodyPadding: '5 10 0 10',
        layout: 'fit', 
       	border: true,  
        width: 440,
        height: 435,
        items:[{
		         	xtype:'fieldset',
                    title: 'Account Detail',
                  //  collapsible: true,
                    defaultType: 'textfield',
                    layout: 'absolute',
                    // Vendor Code            
                    items:[txtID,txtNameT,txtNameE,rdSmallAccount,rdGroupAccount,cbAccount,cbAccountGroup,cbDepartment,btnSave,btnCancel]
		        }]
      
     });
     
       
       /************************************************************/
     function WaitBox() {
        Ext.MessageBox.show({
            msg: 'กรุณารอสักครู่.....',
            closable: false,
            width: 150
        });
    }
    function HideWaitBox() {
        Ext.MessageBox.hide();
    }
     function GetAccountChart()
     {
        Ext.Ajax.request ({
             url: __site_url +  'chartofaccounts/GetAccountChart' ,
             disableCaching: false ,
             success: function (res) {
                   
             var arrChart = res.responseText.split('|');
             var detail = arrChart;
             var data;
             var myData = new Array();
             var i;
             var strTemp;
             if (detail != '') {
                 for (i = 0; i < arrChart.length; i++) {
                     data = new Array();
                     strTemp = arrChart[i].split('+')
                     data[0] = strTemp[0];
                     data[1] = strTemp[1];
                     data[2] = strTemp[2];
                     data[3] = strTemp[3];
                     data[4] = strTemp[4];
                     data[5] = strTemp[5];
                     data[6] = strTemp[6];
                     data[7] = strTemp[7];
                     data[8] = strTemp[8];
                     data[9] = strTemp[9];
                     data[10] = strTemp[10];
                     data[11] = strTemp[11];
                     myData[i] = data;
                  }
             }
             else {
                      data = new Array();
                      myData = data;
             }
             store_chart_account.loadData(myData);                  
           }
        });
      
           
     }
     function GetGroupAccount()
     {
        Ext.Ajax.request ({
             url: __site_url +  'chartofaccounts/GetGroupAccount' ,
             disableCaching: false ,
             success: function (res) {
                   
             var arrGRACC = res.responseText.split('|');
             var detail = arrGRACC;
             var data;
             var myData = new Array();
             var i;
             var strTemp;
             if (detail != '') {
                 for (i = 0; i < arrGRACC.length; i++) {
                     data = new Array();
                     strTemp = arrGRACC[i].split('+')
                     data[0] = strTemp[0];
                     data[1] = strTemp[1];
                     myData[i] = data;
                  }
             }
             else {
                      data = new Array();
                      myData = data;
             }
             store_group_account.loadData(myData);                  
           }
        });
      
           
     }
     function GetDepartment()
     {
        Ext.Ajax.request ({
             url: __site_url +  'chartofaccounts/GetDepartment' ,
             disableCaching: false ,
             success: function (res) {
                   
             var arrDep = res.responseText.split('|');
             var detail = arrDep;
             var data;
             var myData = new Array();
             var i;
             var strTemp;
             if (detail != '') {
                 for (i = 0; i < arrDep.length; i++) {
                     data = new Array();
                     strTemp = arrDep[i].split('+')
                     data[0] = strTemp[0];
                     data[1] = strTemp[1];
                     myData[i] = data;
                  }
             }
             else {
                      data = new Array();
                      myData = data;
             }
             store_department.loadData(myData);                  
           }
        });
      
           
     }
     function SaveData()
     {
        
        if(txtID.getRawValue() == "")
        {
             Ext.MessageBox.alert('', 'please insert id');
             return;
        }
        if(cbAccountGroup.getRawValue() == "")
        {
            if(rdSmallAccount.getValue())
            {
              Ext.MessageBox.alert('', 'please select accout group');
              return;
            }
        }
        if(cbDepartment.getRawValue() == "")
        {   
                 Ext.MessageBox.alert('', 'please select department');
                 return;

        }
        if(txtNameT.getRawValue() == "")
        {
             Ext.MessageBox.alert('', 'please insert thai name');
             return;
        }
        var treid = treid_edit;
        var level = "";
        var leaf1 = "";
        var child = "";
        var accid = txtID.getRawValue();
        var tname = txtNameT.getRawValue();
        var ename = txtNameE.getRawValue();
        var accty = "";
        var accgr = cbAccountGroup.getRawValue();
        var deptx = cbDepartment.getRawValue();
        
        
        
        if(rdSmallAccount.getValue())
        {
            accty = "2";
            leaf1 = "true";
        }
        else{
            accty = "1";
            leaf1 = "false";
        }
        var index = store_chart_account.find('accid',accgr);
        if(index > -1)
        {
            rt = store_chart_account.getAt(index);
            level = parseInt(rt.get('level')) + 1 ;
            child = rt.get('treid');
        }
        else{
            if(rdGroupAccount.getValue())
            {
                level = 1;
                child = "";
            }
            else
            {
                alert('NoN');
                return;
            }
            
        }
        var strParam = "?treid=" + treid +  "&level=" + level + "&leaf1=" + leaf1  + "&child=" + child + "&accid=" + accid;
        strParam = strParam  + "&tname=" + tname + "&ename=" + ename + "&accty=" + accty + "&accgr=" + accgr;
        strParam = strParam  + "&deptx=" + deptx;
        //alert(strParam);
        Ext.Ajax.request ({
             url: __site_url +  'chartofaccounts/SaveTree' + strParam ,
             disableCaching: false ,
             success: function (res) {
                  //   alert(res.responseText);
                      store_tree_chart.load();
                      GetAccountChart();
                      GetGroupAccount();
                      GetReset();
                      GetDisable();
                      btnEdit.setDisabled(true);
                      }
                });
        
     }
     function GetReset()
     {
        txtID.setValue('');
        txtNameT.setValue('');
        txtNameE.setValue('');
        cbAccountGroup.reset();
        cbDepartment.reset();
        treid_edit = "";
     }
     function GetDisable()
     {
        txtID.setReadOnly(true);
        txtNameT.setReadOnly(true);
        txtNameE.setReadOnly(true);
        cbAccount.setReadOnly(true);
        cbAccountGroup.setReadOnly(true);
        cbDepartment.setReadOnly(true);
        rdGroupAccount.setReadOnly(true);
        rdSmallAccount.setReadOnly(true);
        btnSave.setDisabled(true);
        btnCancel.setDisabled(true);
        
       // btnEdit.setDisabled(true);
     }
     function GetEnable()
     {
        //txtID.setDisabled(false);
        txtNameT.setReadOnly(false);
        txtNameE.setReadOnly(false);
        cbAccount.setReadOnly(false);
        cbAccountGroup.setReadOnly(false);
        cbDepartment.setReadOnly(false);
        rdGroupAccount.setReadOnly(false);
        rdSmallAccount.setReadOnly(false);
        btnSave.setDisabled(false);
        btnCancel.setDisabled(false);
        
        btnEdit.setDisabled(false);
     }
      /****************************************/
      GetAccountChart();
      GetGroupAccount();
      GetDepartment();
      GetDisable();
      btnEdit.setDisabled(true);
      /****************************************/ 
       
       	Ext.apply(this, {
		   title: 'Chart Of Accounts',
   	       closeAction: 'hide',
           height: 500,
           //minHeight: 570,
           width: 1000,
           minWidth: 750,
           resizable: false,
           modal: true,
           layout:'hbox',
           maximizable: false,
           items:[LeftPanel,RightPanel],
           tbar:[btnAdd,btnEdit,btnImport],
           buttons:[]
		});
        
        /******************************************/
       // store_tree_chart.on('beforeload', function (store_tree_chart, operation, eOpts ) {
            
        //    store_tree_chart.removeAll();
        
       // });
        
         tree.on('cellclick', function (tree, td, cellIndex, rec, tr, rowIndex, e, eOpts ) {
             //alert(rec.get('text'));
            // return;
               btnEdit.setDisabled(false);
               GetDisable();
               var strText = rec.get('id');
              
               var index = store_chart_account.find('treid',strText);
               // alert(store_chart_account.getAt(0).get('treid'));
               if(index > -1)
               { 
                  rt = store_chart_account.getAt(index);
                  txtID.setValue(rt.get('accid'));
                  txtNameT.setValue(rt.get('tname'));
                  txtNameE.setValue(rt.get('ename'));
                  //cbAccount.setValue(rt.get('glgrp'));
                  cbAccountGroup.setValue(rt.get('accgr'));
                  cbDepartment.setValue(rt.get('deptx'));
                  
                  treid_edit = rt.get('treid');
                  
                  if(rt.get('accty') == "2")
                  {
                    rdSmallAccount.setValue(true);
                    rdGroupAccount.setValue(false);
                  }
                  else{
                    rdGroupAccount.setValue(true);
                    rdSmallAccount.setValue(false);
                  }
               }
              
              
         });
         
         rdSmallAccount.on('change', function (rdSmallAccount, newValue, oldValue, eOpts ) {
        
         
              if (rdSmallAccount.getValue()) {
                    rdGroupAccount.setValue(false);
                    return;
                }
              
         });
         rdGroupAccount.on('change', function (rdGroupAccount, newValue, oldValue, eOpts ) {
        
         
              if (rdGroupAccount.getValue()) {
                    rdSmallAccount.setValue(false);
                    return;
                }
              
         });
        
        
        
        /******************************************/
		return this.callParent(arguments);
        
	
	}
});
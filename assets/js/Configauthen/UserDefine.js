Ext.define('Account.Configauthen.UserDefine', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {
	   
       
       
       
       var store_edit_authen = Ext.create('Ext.data.ArrayStore', {
        fields: [{ name: 'doctx', type: 'string' },
                 { name: 'docty', type: 'string' },
                 { name: 'display', type: 'string' },
                 { name: 'create', type: 'string' },
                 { name: 'edit', type: 'string' },
                 { name: 'delete', type: 'string' },
                 { name: 'export', type: 'string' },
                 { name: 'approve', type: 'string' },
                 { name: 'uname', type: 'string' }
        ], sortInfo: { field: 'doctx', direction: 'ASC' }
    });
     
     
    var grid_edit_authen = Ext.create('Ext.grid.Panel', {
      //  height: 750,
        title:'',
        store: store_edit_authen,
        columns: [
            {id:'doctx', text: "Doc Type", align: 'left', width: 160, dataIndex: 'doctx', sortable: true },
            { text: "Display", align: 'center', width: 100,renderer:SetFieldAuthen, dataIndex: 'display', sortable: true },
            { text: "Create", align: 'center', width: 100,renderer:SetFieldAuthen, dataIndex: 'create', sortable: true },
            { text: "Edit", align: 'center', width: 100, renderer:SetFieldAuthen,  dataIndex: 'edit', sortable: true },
            { text: "Delete", align: 'center', width: 100, renderer:SetFieldAuthen,  dataIndex: 'delete', sortable: true },
            { text: "Export", align: 'center', width: 100, renderer:SetFieldAuthen,  dataIndex: 'export', sortable: true },
            { text: "Approve", align: 'center', width: 100, renderer:SetFieldAuthen,  dataIndex: 'approve', sortable: true }
        ],
        autoExpandColumn: 'doctx',
        bbar:[]
    });
    
   /****************************************************************************************/
   
     var store_employee = Ext.create('Ext.data.ArrayStore', {
        fields: [{ name: 'empnr', type: 'string' },
                 { name: 'name1', type: 'string' },
                 { name: 'email', type: 'string' },
                 { name: 'postx', type: 'string' },
                 { name: 'deptx', type: 'string' },
                 { name: 'uname', type: 'string' }, 
                 { name: 'passw', type: 'string' }      
        ], sortInfo: { field: 'name1', direction: 'ASC' }
    });
    
    
    var grid_employee = Ext.create('Ext.grid.Panel', {
      //  height: 750,
        title:'',
        store: store_employee,
        columns: [
            { text: "Code", align: 'left', width: 50, dataIndex: 'empnr', sortable: true },
            {id:'name1', text: "Name", align: 'left', width: 120, dataIndex: 'name1', sortable: true },
            { text: "Email", align: 'left', width: 160, dataIndex: 'email', sortable: true },
            { text: "Position", align: 'left', width: 120,   dataIndex: 'postx', sortable: true },
            { text: "Department", align: 'left', width: 120,   dataIndex: 'deptx', sortable: true }
        ],
        autoExpandColumn: 'name1',
        bbar:[]
    });
   /***************************************************************************************/
      
      var txtEmployee =   Ext.create('Ext.form.field.Trigger', {
          x:20,
          y:16,
          width: 200,
          fieldLabel: 'Employee Code',
          triggerCls: 'x-form-search-trigger',
          labelAlign: 'left',
          enableKeyEvents: true,
          allowBlank : false
		});
        
      var lblEmployeeName = Ext.create('Ext.form.Label', {
        x:260,
        y:20,
        margin: '0 0 0 20',
        text :""
        
    });
      
    var cbEmployee = Ext.create('Ext.form.ComboBox', {
        rtl: false,
        x:140,
        y:16,
        width: 200,
        emptyText: 'Select Employee',
        triggerAction: 'all',
        lazyRender: true,
        selectOnFocus: true, 
       // store: store_company
        queryMode: 'local',
        displayField: 'company_name',
        valueField: 'company_id',
      
    });
    
      
      
    var txtUserName = Ext.create('Ext.form.Text', {
       	fieldLabel: 'User Name',
        layout: 'absolute',
        margin: '5 0 0 0',
        fieldStyle: 'text-align: left;',
        width: 300,
        x:20,
        y:45
      });
      
      
      
      
      
      var txtPassword = Ext.create('Ext.form.Text', {
       	fieldLabel: 'Password',
        margin: '5 0 5 0',
        layout: 'absolute',
        fieldStyle: 'text-align: left;',
        width: 300,
        x:20,
        y:75
      });
    
    var form_configauthen =  Ext.create('Ext.form.Panel', {
        layout: 'absolute',
        frame: true,    
      //  height: 140,
      //  width: 200,
        items:[txtEmployee , lblEmployeeName,txtUserName,txtPassword]
       // items:[lblEmployee,cbEmployee,lblUserName,txtUserName]
      
     }); 
    
     var TopPanel =  Ext.create('Ext.Panel', {
   		bodyPadding: '5 10 0 10',
        layout: 'fit', 
       	border: true,  
        width: 790,
        height: 160,
        items:[{
		         	xtype:'fieldset',
                    title: 'User Data',
                  //  collapsible: true,
                    defaultType: 'textfield',
                    layout: 'anchor',
                    // Vendor Code            
                    items:[{
                         	xtype: 'container',
                            layout: 'hbox',
                            items: [{
                                     xtype: 'container',
                                     layout: 'anchor',
                                     items :[{
     	                                      xtype: 'container',
                                              layout: 'hbox',
                                              items :[{
                                    	                xtype: 'hidden',
			                                            name: 'id'
		                                              },txtEmployee,lblEmployeeName,
                                                      { xtype: 'displayfield',
                                    	                name: 'name1',
			                                            margins: '0 0 0 6',
			                                            width:350,
                                                        allowBlank: true
	                                    	          }]
		                                    },txtUserName ,txtPassword]
                                  },{
			                         xtype: 'container',
                                     layout: 'anchor',
                                     items :[]
		                          }]
		                 }]
		        }]
      
     }); 
     var btnSave =  Ext.create('Ext.Button', {
         text: 'Save',
         width:80,
         handler: function() {
                             var empnr = txtEmployee.getRawValue();
                             GetSaveEditApprove(empnr);
        }
     }); 


    var btnCancel =  Ext.create('Ext.Button', {
         text: 'Cancel',
         width:80,
         handler: function() {
                    
        }
     }); 
     
    var ButtomPanel =  Ext.create('Ext.Panel', {
        layout: 'fit',
        frame: true,    
        width: 790,
        height: 400,
        items:[grid_edit_authen],
        buttons:[btnSave,btnCancel]
     });  
     
     
     var win_employee_pop_up = Ext.create('Ext.Window', {
     //      id: 'win_employee_pop_up-Configauthen-MainWindow',
           title: '',
   	       closeAction: 'hide',
           height: 300,
           width: 600,
           resizable: false,
           modal: true,
           layout:'fit',
           maximizable: false,
           items:[ grid_employee ]
       });
       
     
    
/**********************************/
  
     function SetFieldAuthen(val)
     {
        if(val == 1)
        {
            return    "<img src='assets/images/icons/accept.png' />";
        }
        return    "<img src='assets/images/icons/cross.png' />";
         
     }
     function GetEmployee()
     {
        Ext.Ajax.request ({
             url: __site_url +  'configauthen/GetEmployee' ,
             disableCaching: false ,
             success: function (res) {
                   
             var arrEmp = res.responseText.split('|');
             var detail = arrEmp;
             var data;
             var myData = new Array();
             var i;
             var strTemp;
             if (detail != '') {
                 for (i = 0; i < arrEmp.length; i++) {
                     data = new Array();
                     strTemp = arrEmp[i].split('+')
                     data[0] = strTemp[0];
                     data[1] = strTemp[1];
                     data[2] = strTemp[2];
                     data[3] = strTemp[3];
                     data[4] = strTemp[4];
                     data[5] = strTemp[5];
                     data[6] = strTemp[6];
                     myData[i] = data;
                  }
             }
             else {
                      data = new Array();
                      myData = data;
             }
             store_employee.loadData(myData);                   
           }
        });
      
           
     }
     function GetUserAuthen(empnr)
     {
       Ext.Ajax.request ({
             url: __site_url +  'configauthen/GetUserAuthen?empnr=' + empnr ,
             disableCaching: false ,
             success: function (res) {
                
             var arrEmp = res.responseText.split('|');
             var detail = arrEmp;
             var data;
             var myData = new Array();
             var i;
             var strTemp;
             if (detail != '') {
                for (i = 0; i < arrEmp.length; i++) {
                  data = new Array();
                  strTemp = arrEmp[i].split('+')
                  data[0] = strTemp[0];
                  data[1] = strTemp[1];
                  data[2] = strTemp[2];
                  data[3] = strTemp[3];
                  data[4] = strTemp[4];
                  data[5] = strTemp[5];
                  data[6] = strTemp[6];
                  data[7] = strTemp[7];
                  data[8] = strTemp[8];
                  myData[i] = data;
                }
             }
             else {
                  data = new Array();
                  myData = data;
             }
             store_edit_authen.loadData(myData);
           }
       });
     }
     function GetSaveEditApprove(empnr)
     {
        var sSql = "";
        var strResult = "";
        var uname = txtUserName.getRawValue();
        var passw = txtPassword.getRawValue();
        
        for(i = 0;i< store_edit_authen.getCount() ; i++)
        {
            rt = store_edit_authen.getAt(i);
            sSql = sSql + rt.get('docty') + "+" + rt.get('display') +  rt.get('create') + rt.get('edit')  + rt.get('delete')  + rt.get('export')  + rt.get('approve')  + "|"; 
            
        }
      
        if(sSql != "")
        {
            sSql= sSql.substr(0,sSql.length -1 );
        }
        strResult = "passw=" + passw + "&uname=" + uname + "&empnr="+ empnr + "&authen=" + sSql  ;//+ sSql;
        Ext.Ajax.request ({
             url: __site_url +  'configauthen/GetSaveEditApprove?' + strResult ,
             disableCaching: false ,
             success: function (res) {
                GetUserAuthen(empnr);
             }
        });

     }
    /*Even********************************************************************/
       grid_edit_authen.on('cellclick', function (grid_edit_authen, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
        
        if(cellIndex == 1)
        {
            if(record.get('display') == "0")
            {
                 record.set('display', 1); 
            }
            else{
                record.set('display', "0"); 
            }
           return;
        }
        if(cellIndex == 2)
        {
            if(record.get('create') == "0")
            {
                 record.set('create', 1); 
            }
            else{
                record.set('create', "0"); 
            }
           return;
        }
        if(cellIndex == 3)
        {
            if(record.get('edit') == "0")
            {
                 record.set('edit', 1); 
            }
            else{
                record.set('edit', "0"); 
            }
           return;
        }
        if(cellIndex == 4)
        {
            if(record.get('delete') == "0")
            {
                 record.set('delete', 1); 
            }
            else{
                record.set('delete', "0"); 
            }
           return;
        }
        if(cellIndex == 5)
        {
            if(record.get('export') == "0")
            {
                 record.set('export', 1); 
            }
            else{
                record.set('export', "0"); 
            }
           return;
        }
        if(cellIndex == 6)
        {
            if(record.get('approve') == "0")
            {
                 record.set('approve', 1); 
            }
            else{
                record.set('approve', "0"); 
            }
           return;
        }
        
           
       });
       
       txtEmployee.onTriggerClick = function(){
            GetEmployee();
	    	win_employee_pop_up.show();
		};
        
        
       grid_employee.on('cellclick', function (grid_employee, td, cellIndex, rec, tr, rowIndex, e, eOpts ) {
           
           txtEmployee.setValue(rec.get('empnr'));
           txtUserName.setValue(rec.get('uname'));
           txtPassword.setValue(rec.get('passw'));
           lblEmployeeName.setText(rec.get('name1'));
           
           GetUserAuthen(rec.get('empnr'));
           win_employee_pop_up.hide();
       });
       
       /************************************/
     
       	Ext.apply(this, {
		  title: '',
           height: 570,
           width: 800,
           layout:'vbox',
           items:[TopPanel,ButtomPanel]
		});
        
       

		return this.callParent(arguments);
        
	
	}
});
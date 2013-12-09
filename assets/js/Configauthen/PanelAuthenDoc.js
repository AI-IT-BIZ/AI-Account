Ext.define('Account.Configauthen.PanelAuthenDoc', {
	extend	: 'Ext.form.Panel',
	constructor:function(config) {
	   
    var rec_empl = null;
    var rec_doct = null;
    var rec_limit_amount = null;
   /******************************************/
    var store_limit_amount = Ext.create('Ext.data.ArrayStore', {
        fields: [{ name: 'rowno', type: 'string' },
                 { name: 'amoid', type: 'string' },
                 { name: 'rowid', type: 'string' },
                 { name: 'grptx', type: 'string' },
                 { name: 'docty', type: 'string' },
                 { name: 'liamo', type: 'string' }
        ], sortInfo: { field: 'amoid', direction: 'ASC' }
    });
     
     var btnAddLimitPopUp =  Ext.create('Ext.Button', {
                text: 'Add',
                iconCls: 'b-small-plus',
                width: 60,
                handler: function() {
                    
                    
                    win_add_limit_amount.show();
                   // AddLimitAmount();
              }
       });
     
    var grid_limit_amount = Ext.create('Ext.grid.Panel', {
        title:'Doc Type : ',
        store: store_limit_amount,
        columns: [
            { text: "  ", align: 'center', width: 30,renderer:RenderfieldDelete, dataIndex: 'limit_amount_row_delete', sortable: true },
            { text: "  ", align: 'center', width: 30,renderer:RenderFieldDetail ,   dataIndex: 'limit_amount_row_edit', sortable: true },
            { text: "No.", align: 'center', width: 40, dataIndex: 'rowno', sortable: true },
            { text: "grptx", align: 'center', width: 220, dataIndex: 'grptx', sortable: true },
            { text: "docty", align: 'center', width: 80, dataIndex: 'docty', sortable: true },
            { text: "Limit Amount", align: 'center', width: 140, dataIndex: 'liamo', sortable: true }
        ],
        autoExpandColumn: 'budget_limit_doc_name',
        tbar:[btnAddLimitPopUp]
    });
    
    var lblLimitAmount = Ext.create('Ext.form.Label', {
        layout: 'absolute',
        x:20,
        y:20,
        text:'Limit Amount : '
      });
      
    var txtLimitAmount = Ext.create('Ext.form.Text', {
        layout: 'absolute',
        fieldStyle: 'text-align: right;',
        width: 140,
        x:110,
        y:20
      });
      
    var btnOkAddLimitAmount =  Ext.create('Ext.Button', {
        text: 'ตกลง',
        x:110,
        y:50,
        width: 80,
        handler: function() {
            var amount_param = txtLimitAmount.getRawValue();
            AddLimitAmount(amount_param);
            win_add_limit_amount.hide();
            txtLimitAmount.setValue('');
        }
    });
    
    var form_add_limit_amount =  Ext.create('Ext.form.Panel', {
        layout: 'absolute',
        frame: true,    
        height: 140,
        width: 200,
        items:[lblLimitAmount,txtLimitAmount,btnOkAddLimitAmount]
      
     }); 
    
    var win_add_limit_amount = Ext.create('Ext.Window', {
           title: '',
   	       closeAction: 'hide',
           height: 140,
           width: 300,
           resizable: false,
           modal: true,
           layout:'fit',
           maximizable: false,
           items:[ form_add_limit_amount ]
       });
    
     var TopPanel =  Ext.create('Ext.Panel', {
        layout: 'fit',
        //frame: true,    
        width: 1000,
        height: 370,
        items:[grid_limit_amount]
      
     });  
     


     
     /***************************************************************************************************/
     var store_authen_aprove = Ext.create('Ext.data.ArrayStore', {
        fields: [{ name: 'rowno', type: 'string' },
                 { name: 'levid', type: 'string' },
                 { name: 'amoid', type: 'string' },
                 { name: 'empnr', type: 'string' },
                 { name: 'name1', type: 'string' },
                 { name: 'postx', type: 'string' },
                 { name: 'deptx', type: 'string' }
        ], sortInfo: { field: 'levid', direction: 'ASC' }
     });
   var btnAddEmpPopUp =  Ext.create('Ext.Button', {
                text: 'Add',
                iconCls: 'b-small-plus',
                width: 60,
                handler: function() {
                      
                       win_add_emp_approve.show();
              }
       });
     var grid_authen_aprove = Ext.create('Ext.grid.Panel', {
        height: 200,
        title:'Doc Type:',
        store: store_authen_aprove,
        plugins: [ Ext.create('Ext.grid.plugin.CellEditing', {
              clicksToEdit: 1
           })
        ],
        columns: [
            { text: "  ", align: 'center', width: 30, renderer:RenderfieldDelete, dataIndex: 'authen_aprove_row_delete', sortable: true },
            { text: "No.", align: 'center', width: 40, dataIndex: 'rowno', sortable: false },
            {  text: "Name", align: 'center', width: 160, dataIndex: 'name1',field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
				       win_add_emp_approve.show();
				}
			}, sortable: true },
            {  text: "Postx", align: 'center', width: 160, dataIndex: 'postx', sortable: true },
            {  text: "Deptx", align: 'center', width: 160, dataIndex: 'deptx', sortable: true }
        ],
        autoExpandColumn: 'name1',
        tbar:[btnAddEmpPopUp],
        bbar:['->',{
                text: 'Save',
                hidden:true,
                width: 100,
                handler: function() {
                
              }
       },{
                text: 'Cancel',
                hidden:true,
                width: 100,
                handler: function() {
                
              }
       }]
    });
     var ButtomPanel =  Ext.create('Ext.Panel', {
        layout: 'fit',
        //frame: true,    
        width: 740,
        height: 200,
        items:[grid_authen_aprove]
      
     });  
     /*************************************************************************************/
     
     var store_doct = Ext.create('Ext.data.ArrayStore', {
        fields: [{ name: 'grptx', type: 'string' },
                 { name: 'docty', type: 'string' },
                 { name: 'doctx', type: 'string' },
                 { name: 'grpmo', type: 'string' }
        ], sortInfo: { field: 'grptx', direction: 'ASC' }
    });
     
    var grid_doct = Ext.create('Ext.grid.Panel', {
        title:'All Doc Type ',
        store: store_doct,
        columns: [
            //{ id: 'grptx', text: "grptx",hidden:true, align: 'center', width: 90, dataIndex: 'grptx', sortable: true },
            //{ id: 'docty', text: "docty" ,hidden:true, align: 'center', width: 90, dataIndex: 'docty', sortable: true },
            {  text: "Doctx", align: 'left', width: 160, dataIndex: 'doctx', sortable: true }
           // ,{ id: 'grpmo', text: "grpmo" ,hidden:true, align: 'center', width: 90, dataIndex: 'grpmo', sortable: true }

        ]
       // ,autoExpandColumn: 'doctx'
    });
    
    
     var LeftPanel =  Ext.create('Ext.Panel', {
        layout: 'fit',
        //frame: true,    
        width: 200,
        height: 600,
        items:[grid_doct]
      
     });  
      /*************************************************************************************/
     var RightPanel =  Ext.create('Ext.Panel', {
        layout: 'vbox',
        //frame: true,    
        width: 750,
        height: 600,
        items:[TopPanel,ButtomPanel]
      
     });  
    /***********************************************************/  
    var store_add_emp_approve = Ext.create('Ext.data.ArrayStore', {
        fields: [{ name: 'empnr', type: 'string' },
                 { name: 'name1', type: 'string' },
                 { name: 'postx', type: 'string' },
                 { name: 'deptx', type: 'string' }
        ], sortInfo: { field: 'name1', direction: 'ASC' }
    });
    
    var grid_add_emp_approve = Ext.create('Ext.grid.Panel', {
        store: store_add_emp_approve,
        columns: [    
            {  text: "Name", align: 'left', width: 120, dataIndex: 'name1', sortable: true } ,
            {  text: "Position", align: 'left', width: 140, dataIndex: 'postx', sortable: true }   
        ],
        tbar:[{
                text: 'Add',
                iconCls: 'b-small-plus',
                width: 60,
                handler: function() {
                    AddEmplAuth() ;
                  //  alert(rec_empl.get('empnr'));
                  win_add_emp_approve.hide();
              }
       }]
    });

    
    var win_add_emp_approve = Ext.create('Ext.Window', {
           title: '',
   	       closeAction: 'hide',
           height: 400,
           width: 300,
           resizable: false,
           modal: true,
           layout:'fit',
           maximizable: false,
           items:[ grid_add_emp_approve ]
       });
    /***********************************************************/  
  
       
       
       /*Function********************************************************************/
      
       /*แสดงเอกสารทั้งหมด*******/
       function GET_TBL_DOCT()
       {
           Ext.Ajax.request ({
             url: __site_url +  'configauthen/GET_TBL_DOCT' ,
             disableCaching: false ,
             success: function (res) {
                
                var arrDoct = res.responseText.split('|');
                var detail = arrDoct;
                var data;
                var myData = new Array();
                var i;
                var strTemp;
                if (detail != '') {
                   for (i = 0; i < arrDoct.length; i++) {
                       data = new Array();
                       strTemp = arrDoct[i].split('+')
                       data[0] = strTemp[0];
                       data[1] = strTemp[1];
                       data[2] = strTemp[2];
                       data[3] = strTemp[3];
                       myData[i] = data;
                   }
                 }
                 else {
                     data = new Array();
                     myData = data;
                 }
                 store_doct.loadData(myData);
             }
          });
         
           
       }
      
       /*เลือกพนักงานที่อยู่ในแผนก*******/
       function GET_EMPL_APPROVE(docty)
       {
          Ext.Ajax.request ({
            url: __site_url +  'configauthen/GET_EMPL_APPROVE?docty=' + docty,
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
                        myData[i] = data;
                  }
              }
              else {
                   data = new Array();
                   myData = data;
              }
              store_add_emp_approve.loadData(myData);
            }
          });
                
            
       }
        /*เลือกข้อมูลจาก tbl_amou โดยดึงข้อมูลจากประเภท docty *******/
       function GET_TBL_AMOU(docty)
       {
            
            Ext.Ajax.request ({
            url: __site_url +  'configauthen/GET_TBL_AMOU?docty=' + docty,
            disableCaching: false ,
            success: function (res) {
                
               var arrLimit = res.responseText.split('|');
               var detail = arrLimit;
               var data;
               var myData = new Array();
               var i;
               var strTemp;
               if (detail != '') {
                  for (i = 0; i < arrLimit.length; i++) {
                    data = new Array();
                    strTemp = arrLimit[i].split('+')
                    data[0] = strTemp[0];
                    data[1] = strTemp[1];
                    data[2] = strTemp[2];
                    data[3] = strTemp[3];
                    data[4] = strTemp[4];
                    data[5] = strTemp[5];
                    myData[i] = data;
                  }
              }
              else {
                    data = new Array();
                    myData = data;
              }
              store_limit_amount.loadData(myData);
             }
         });
       }
       function GET_TBL_AUAM(amoid)
       {
            Ext.Ajax.request ({
            url: __site_url +  'configauthen/GET_TBL_AUAM?amoid=' + amoid,
            disableCaching: false ,
            success: function (res) {
                 var arrAuam = res.responseText.split('|');
                 var detail = arrAuam;
                 var data;
                 var myData = new Array();
                 var i;
                 var strTemp;
                 if (detail != '') {
                    for (i = 0; i < arrAuam.length; i++) {
                       data = new Array();
                       strTemp = arrAuam[i].split('+')
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
                store_authen_aprove.loadData(myData);
              }
           });
        
       }
         /*เพิ่ม limit amount ในเอกสารที่เลือก*****/
       function AddLimitAmount(amount_param) 
       {  
        
        
          var myRowid =  store_limit_amount.getCount() + 1;
          var myAmoid = "";
          var myDocty = rec_doct.get('docty');
       
          Ext.Ajax.request ({
              url: __site_url +  'configauthen/GetSaveAmount?rowid=' + myRowid + '&amoid=' + myAmoid + '&docty=' + myDocty + '&liamo=' + amount_param,
              disableCaching: false ,
              success: function (res) {
                            GET_TBL_AMOU(myDocty);
              }
          });
                   
       }
       /*เพิ่มผู้มีสิทธิ approve ในกริด*****/
       function AddEmplAuth() 
       {
           
          var myLevid =  store_authen_aprove.getCount() + 1;
          var myAmoid = rec_limit_amount.get('amoid');
          var myEmpnr = rec_empl.get('empnr');
          Ext.Ajax.request ({
              url: __site_url +  'configauthen/GetSaveEmplAuthen?levid=' + myLevid + '&amoid=' + myAmoid + '&empnr=' + myEmpnr  ,
              disableCaching: false ,
              success: function (res) {
                           GET_TBL_AUAM(myAmoid);
              }
          });

       }
      
       function GetSaveData(strData)
       {
          var strLimitAmount = "";
          var strEmplAuthen = "";
          var strData = "";
          for(i = 0;i < store_limit_amount.getCount(); i++)
          {
               rt = store_limit_amount.getAt(i);
               strLimitAmount = strLimitAmount + rt.get('rowid') + "+" + rt.get('grptx') + "+" + rt.get('docty') + "+" + rt.get('liamo') + "|" ;
            
          }
          
          for(i = 0;i < store_authen_aprove.getCount(); i++)
          {
               rt = store_authen_aprove.getAt(i);
               strEmplAuthen = strEmplAuthen + rt.get('levid') + "+" + rt.get('amoid') + "+" + rt.get('empnr')  + "|" ;
            
          }
          strData = rec_doct.get('docty') + "#" + str

       }
       function DeleteAmount(amoid)
       {
           Ext.Ajax.request ({
              url: __site_url +  'configauthen/DeleteAmount?amoid=' + amoid  ,
              disableCaching: false ,
              success: function (res) {
                        GET_TBL_AMOU(rec_doct.get('docty'));
                       
                        store_authen_aprove.removeAll();   
              }
          });
        
       }
       function DeleteEmplAuthen(amoid,empnr)
       {
     
           Ext.Ajax.request ({
              url: __site_url +  'configauthen/DeleteEmplAuthen?amoid=' + amoid + '&empnr=' + empnr ,
              disableCaching: false ,
              success: function (res) {
                        GET_TBL_AUAM(amoid);
                             
              }
          });
        
       }
       function RenderfieldDelete(val)
       {
           return '<div  style="text-align: center"><img style="cursor:pointer"   alt="" src="assets/images/icons/bin.gif" /></div>';
       }
       function RenderFieldDetail(val)
       {
           return '<div  style="text-align: center"><img style="cursor:pointer"   alt="" src="assets/images/icons/detail.png" /></div>';
       }
       /*Initial********************************************************************/
       GET_TBL_DOCT();
       btnAddLimitPopUp.setDisabled(true);
       btnAddEmpPopUp.setDisabled(true);
       
       
       /*Event********************************************************************/
        grid_doct.on('cellclick', function (grid_doct, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
            
            btnAddLimitPopUp.setDisabled(false);
            btnAddEmpPopUp.setDisabled(true);
            rec_doct = record;
            GET_TBL_AMOU(record.get('docty'));
            store_authen_aprove.removeAll();
            GET_EMPL_APPROVE(record.get('docty'));
            grid_limit_amount.setTitle('Doc Type : ' + record.get('doctx'));
            grid_authen_aprove.setTitle('Doc Type : ');

       });
        grid_add_emp_approve.on('cellclick', function (grid_add_emp_approve, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
        
        
           rec_empl = record;
        
           
       });
       
       grid_limit_amount.on('cellclick', function (grid_limit_amount, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
        
           if(cellIndex == 0)
           {
            
              DeleteAmount(record.get('amoid'));
              grid_authen_aprove.setTitle('Doc Type:');
              btnAddEmpPopUp.setDisabled(true);
           }
           if(cellIndex == 1)
           {
              rec_limit_amount = record;
              GET_TBL_AUAM(record.get('amoid'));
              btnAddEmpPopUp.setDisabled(false);
              
              grid_authen_aprove.setTitle('Doc Type : ' + rec_doct.get('doctx') + 'Limit Amount : ' + record.get('liamo'));
              return;
           }
        
           
       });
       
       grid_authen_aprove.on('cellclick', function (grid_authen_aprove, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
        
           if(cellIndex == 0)
           {
              DeleteEmplAuthen(record.get('amoid'),record.get('empnr'));

           }

       });
    
    
    
    Ext.apply(this, {
		  title: '',
           height: 570,
           width: 800,
           layout:'hbox',
           items:[LeftPanel,RightPanel]
	});
        

    return this.callParent(arguments);
        
	
	}
});
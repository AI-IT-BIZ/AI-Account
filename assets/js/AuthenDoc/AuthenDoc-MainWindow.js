//AuthenDoc
function PageLoad()
{
    var rec_empl = null;
    var rec_doct = null;
    var rec_limit_amount = null;
   /******************************************/
    var store_limit_amount = Ext.create('Ext.data.ArrayStore', {
        storeId: 'store_limit_amount-AuthenDoc-MainWindow',
        fields: [{ name: 'amoid', type: 'string' },
                 { name: 'rowid', type: 'string' },
                 { name: 'grptx', type: 'string' },
                 { name: 'docty', type: 'string' },
                 { name: 'liamo', type: 'string' }
        ], sortInfo: { field: 'amoid', direction: 'ASC' }
    });
     
    var grid_limit_amount = Ext.create('Ext.grid.Panel', {
        id: 'grid_limit_amount-AuthenDoc-MainWindow',
        title:'Doc Type : ',
        store: store_limit_amount,
        columns: [
            { text: "  ", align: 'center', width: 30,renderer:RenderfieldDelete, dataIndex: 'limit_amount_row_delete', sortable: true },
            { text: "  ", align: 'center', width: 30,renderer:RenderFieldDetail ,   dataIndex: 'limit_amount_row_edit', sortable: true },
            { text: "�ӴѺ���", align: 'center', width: 60, dataIndex: 'rowid', sortable: true },
            { text: "grptx", align: 'center', width: 240, dataIndex: 'grptx', sortable: true },
            { text: "docty", align: 'center', width: 180, dataIndex: 'docty', sortable: true },
            { text: "Limit Amount", align: 'center', width: 180, dataIndex: 'liamo', sortable: true }
        ],
        autoExpandColumn: 'budget_limit_doc_name',
        tbar:[{
                text: 'Add',
                iconCls: 'b-small-plus',
                width: 60,
                handler: function() {
                    win_add_limit_amount.show();
                   // AddLimitAmount();
              }
       }]
    });
    
    var lblLimitAmount = Ext.create('Ext.form.Label', {
        id: 'lblLimitAmount-AuthenDoc-MainWindow',
        layout: 'absolute',
        x:20,
        y:20,
        text:'Limit Amount : '
      });
      
    var txtLimitAmount = Ext.create('Ext.form.Text', {
        id: 'txtLimitAmount-AuthenDoc-MainWindow',
        layout: 'absolute',
        fieldStyle: 'text-align: right;',
        width: 140,
        x:110,
        y:20
      });
      
    var btnOkAddLimitAmount =  Ext.create('Ext.Button', {
        id:'btnOkAddLimitAmount-AuthenDoc-MainWindow',
        text: '��ŧ',
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
        id: 'form_add_limit_amount-AuthenDoc-MainWindow',
        layout: 'absolute',
        frame: true,    
        height: 140,
        width: 200,
        items:[lblLimitAmount,txtLimitAmount,btnOkAddLimitAmount]
      
     }); 
    
    var win_add_limit_amount = Ext.create('Ext.Window', {
           id: 'win_add_limit_amount-AuthenDoc-MainWindow',
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
        id: 'TopPanel-AuthenDoc-MainWindow',
        layout: 'fit',
        //frame: true,    
        width: 1000,
        height: 370,
        items:[grid_limit_amount]
      
     });  
     


     
     /***************************************************************************************************/
     var store_authen_aprove = Ext.create('Ext.data.ArrayStore', {
        storeId: 'store_authen_aprove-AuthenDoc-MainWindow',
        fields: [{ name: 'levid', type: 'string' },
                 { name: 'amoid', type: 'string' },
                 { name: 'empnr', type: 'string' },
                 { name: 'name1', type: 'string' },
                 { name: 'postx', type: 'string' },
                 { name: 'deptx', type: 'string' }
        ], sortInfo: { field: 'levid', direction: 'ASC' }
     });
   
     var grid_authen_aprove = Ext.create('Ext.grid.Panel', {
        id: 'grid_authen_aprove-AuthenDoc-MainWindow',
        height: 200,
        store: store_authen_aprove,
        plugins: [ Ext.create('Ext.grid.plugin.CellEditing', {
              clicksToEdit: 1
           })
        ],
        columns: [
            { text: "  ", align: 'center', width: 30, renderer:RenderfieldDelete, dataIndex: 'authen_aprove_row_delete', sortable: true },
            { text: "�ӴѺ���", align: 'center', width: 60, dataIndex: 'levid', sortable: false },
            {  text: "����", align: 'center', width: 200, dataIndex: 'name1',field: {
				xtype: 'triggerfield',
				enableKeyEvents: true,
				triggerCls: 'x-form-search-trigger',
				onTriggerClick: function(){
				       win_add_emp_approve.show();
				}
			}, sortable: true },
            {  text: "���˹�", align: 'center', width: 170, dataIndex: 'postx', sortable: true },
            {  text: "˹��§ҹ", align: 'center', width: 170, dataIndex: 'deptx', sortable: true }
        ],
        autoExpandColumn: 'name1',
        tbar:[{
                text: 'Add',
                id:'btnAddEmpWindowPop-AuthenDoc-MainWindow',
                iconCls: 'b-small-plus',
                width: 60,
                handler: function() {
                       win_add_emp_approve.show();
                   // win_add_limit_amount.show();
                   // AddLimitAmount();
              }
       }],
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
        id: 'ButtomPanel-AuthenDoc-MainWindow',
        layout: 'fit',
        //frame: true,    
        width: 740,
        height: 200,
        items:[grid_authen_aprove]
      
     });  
     /*************************************************************************************/
     
     var store_doct = Ext.create('Ext.data.ArrayStore', {
        storeId: 'store_doct-AuthenDoc-MainWindow',
        fields: [{ name: 'grptx', type: 'string' },
                 { name: 'docty', type: 'string' },
                 { name: 'doctx', type: 'string' },
                 { name: 'grpmo', type: 'string' }
        ], sortInfo: { field: 'grptx', direction: 'ASC' }
    });
     
    var grid_doct = Ext.create('Ext.grid.Panel', {
        id: 'grid_doct-AuthenDoc-MainWindow',
        title:'All Doc Type ',
        store: store_doct,
        columns: [
            { id: 'grptx', text: "grptx", align: 'center', width: 90, dataIndex: 'grptx', sortable: true },
            { id: 'docty', text: "docty", align: 'center', width: 90, dataIndex: 'docty', sortable: true },
            { id: 'doctx', text: "doctx", align: 'center', width: 90, dataIndex: 'doctx', sortable: true },
            { id: 'grpmo', text: "grpmo", align: 'center', width: 90, dataIndex: 'grpmo', sortable: true }

        ],
        autoExpandColumn: 'doctx'
    });
    
    
     var LeftPanel =  Ext.create('Ext.Panel', {
        id: 'LeftPanel-AuthenDoc-MainWindow',
        layout: 'fit',
        //frame: true,    
        width: 350,
        height: 600,
        items:[grid_doct]
      
     });  
      /*************************************************************************************/
     var RightPanel =  Ext.create('Ext.Panel', {
        id: 'RightPanel-AuthenDoc-MainWindow',
        layout: 'vbox',
        //frame: true,    
        width: 750,
        height: 600,
        items:[TopPanel,ButtomPanel]
      
     });  
    /***********************************************************/  
    var store_add_emp_approve = Ext.create('Ext.data.ArrayStore', {
        storeId: 'store_add_emp_approve-AuthenDoc-MainWindow',
        fields: [{ name: 'empnr', type: 'string' },
                 { name: 'name1', type: 'string' },
                 { name: 'postx', type: 'string' },
                 { name: 'deptx', type: 'string' }
        ], sortInfo: { field: 'name1', direction: 'ASC' }
    });
    
    var grid_add_emp_approve = Ext.create('Ext.grid.Panel', {
        id: 'grid_add_emp_approve-AuthenDoc-MainWindow',
        store: store_add_emp_approve,
        columns: [    
            { id: 'name1', text: "���;�ѡ�ҹ", align: 'left', width: 120, dataIndex: 'name1', sortable: true } ,
            { id: 'postx', text: "���˹�", align: 'left', width: 140, dataIndex: 'postx', sortable: true }   
        ],
        autoExpandColumn: 'name1',
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
           id: 'win_add_emp_approve-AuthenDoc-MainWindow',
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
    var win_authen_doc = Ext.create('Ext.Window', {
           id: 'win_authen_doc-AuthenDoc-MainWindow',
           title: '',
   	       closeAction: 'hide',
           height: 600,
           minHeight: 380,
           width: 1100,
           minWidth: 500,
           resizable: true,
           modal: true,
           layout:'hbox',
           maximizable: true,
           items:[ LeftPanel,RightPanel]
       });
       
       
       /*Function********************************************************************/
       /*�ʴ��͡��÷�����*******/
       function GET_TBL_DOCT()
       {
         
            var strResult = remoteFunction("GET_TBL_DOCT","");
            var arrDoct = strResult.split('|');
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
       function GET_Initial_Grid_Approve()
       {
           //store_authen_aprove
           var data;
           var myData = new Array();
           for (i = 0; i < 1; i++) {
                  data = new Array();
               
                  data[0] = "4";
                  data[1] = "";
                  data[2] = "";
                  data[3] = "";
                  data[4] = "";
                  data[5] = "";
                  data[6] = "";
                  myData[i] = data;
           }
           store_authen_aprove.loadData(myData);
       }
       /*���͡��ѡ�ҹ��������Ἱ�*******/
       function GET_EMP($deptx)
       {
            var strResult = remoteFunction("GET_EMP",$deptx);
            var arrEmp = strResult.split('|');
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
        /*���͡�����Ũҡ tbl_amou �´֧�����Ũҡ������ docty *******/
       function GET_TBL_AMOU($docty)
       {
            var strResult = remoteFunction("GET_TBL_AMOU",$docty);
            var arrEmp = strResult.split('|');
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
                  myData[i] = data;
                  }
              }
            else {
                  data = new Array();
                  myData = data;
            }
            store_limit_amount.loadData(myData);
       }
       function GET_TBL_AUAM(amoid)
       {
            var strResult = remoteFunction("GET_TBL_AUAM",amoid);
            var arrAuam = strResult.split('|');
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
                  myData[i] = data;
                  }
              }
            else {
                  data = new Array();
                  myData = data;
            }
            store_authen_aprove.loadData(myData);
        
       }
         /*���� limit amount ��͡��÷�����͡*****/
       function AddLimitAmount(amount_param) 
       {  
          var myRowid =  store_limit_amount.getCount() + 1;
          var myAmoid = "";
          var myDocty = rec_doct.get('docty');
       
          
          var strData = myRowid + "|" + myDocty + "|" + amount_param;
          GetSaveAmount(strData);
          GET_TBL_AMOU(myDocty);
          //var rec = [{ rowid : store_limit_amount.getCount() + 1 ,amoid : rec_doct.get('amoid'), grptx: rec_doct.get('grptx'), docty: rec_doct.get('docty'), liamo: amount_param}];
         // store_limit_amount.insert(store_limit_amount.getCount(), rec);

       }
       /*����������Է�� approve 㹡�Դ*****/
       function AddEmplAuth() 
       {
           
          var myLevid =  store_authen_aprove.getCount() + 1;
          var myAmoid = rec_limit_amount.get('amoid');
          var myEmpnr = rec_empl.get('empnr');
          
          var strData = myLevid + "|" + myAmoid + "|" + myEmpnr;
       
          GetSaveEmplAuthen(strData);
          GET_TBL_AUAM(myAmoid);
        
         // var rec = [{ levid : store_authen_aprove.getCount() + 1 ,amoid : rec_limit_amount.get('amoid'),empnr : rec_empl.get('empnr'),name1 : rec_empl.get('name1'),postx : rec_empl.get('postx'),deptx : rec_empl.get('deptx')}];
        //  store_authen_aprove.insert(store_authen_aprove.getCount(), rec);
        
       
       }
       function GetSaveAmount(strData)
       {

           var strResult = remoteFunction("GetSaveAmount",strData);

       }
       function GetSaveEmplAuthen(strData)
       {

           var strResult = remoteFunction("GetSaveEmplAuthen",strData);

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
          // var strResult = remoteFunction("GetSaveEmplAuthen",strData);

       }
       function RenderfieldDelete(val)
       {
           return '<div  style="text-align: center"><img style="cursor:pointer"   alt="" src="../../images/icons/bin.gif" /></div>';
       }
       function RenderFieldDetail(val)
       {
           return '<div  style="text-align: center"><img style="cursor:pointer"   alt="" src="../../images/icons/detail.png" /></div>';
       }
       /*Initial********************************************************************/
      
       GET_TBL_DOCT();
       GET_EMP();
     //  GET_Initial_Grid_Approve();
       win_authen_doc.show();
       
       /*Event********************************************************************/
        grid_doct.on('cellclick', function (grid_doct, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
        
              // tr.style.color="red" ;
            rec_doct = record;
            GET_TBL_AMOU(record.get('docty'));
            GET_EMP(record.get('grptx'));
            store_authen_aprove.removeAll();
            
            grid_limit_amount.setTitle('Doc Type : ' + record.get('doctx'));
            Ext.getCmp('btnAddEmpWindowPop-AuthenDoc-MainWindow').setDisabled(true);
            
           // grid_doct.getView().addRowClass(rowIndex, 'select');
          //  Ext.fly(grid_doct.getView().getRow(rowIndex)).addClass('{    border:1px solid red !important; } ');
           
       });
        grid_add_emp_approve.on('cellclick', function (grid_add_emp_approve, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
        
        
           rec_empl = record;
        
           
       });
       
       grid_limit_amount.on('cellclick', function (grid_authen_aprove, td, cellIndex, record, tr, rowIndex, e, eOpts ) {
        
        
           if(cellIndex == 1)
           {
              Ext.getCmp('btnAddEmpWindowPop-AuthenDoc-MainWindow').setDisabled(false);
              rec_limit_amount = record;
              GET_TBL_AUAM(record.get('amoid'));
           }
        
           
       });
}

Ext.define('Account.RPayment.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"payment/loads_report",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.payno+o.vbelp+o.Expr3; },//'invnr'
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'payno',
			    //'vbelp',
				'bldat',
				'lifnr',
				'name1',
				'netwr',
				'statx',
				'paytx',
				
				'invnr',
				'invdt',
				
				'itamt',
				'netwr',
				'vat01',
				'wht01',
				'Expr3',
				'matnr',
				'maktx',
				'menge',
                'unitp',
                'beamt'
                
			],
			remoteSort: true,
			sorters: [{property: 'payno', direction: 'ASC'}],
		});

		this.columns = [
		    {text: "Payment No", 
		    width: 100, align: 'center', dataIndex: 'payno', sortable: true},
			{text: "Doc Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 80, align: 'center', dataIndex: 'bldat', sortable: true},
			
		    {text: "Vendor No", 
		    width: 80, align: 'center', dataIndex: 'lifnr', sortable: true},
			{text: "Vendor Name", 
			width: 200, dataIndex: 'name1', sortable: true},
			{text: "Net Amount", xtype: 'numbercolumn',
			width: 100, align: 'right', dataIndex: 'netwr', sortable: true},
			{text: "Status", 
			width: 120, dataIndex: 'statx', sortable: true},
			{text: "Paymented by", 
			width: 120, dataIndex: 'paytx', align: 'left', sortable: true},
			
			{text: "AP No", 
			width: 100, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "AP Date", 
			width: 80, dataIndex: 'invdt', align: 'center', sortable: true},
			{text: "Vat Amount", width: 80, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'vat01', sortable: true},
            {text: "WHT Amount", width: 80, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'wht01', sortable: true},
			{text: "Amount", xtype: 'numbercolumn',
			width: 100, dataIndex: 'itamt', align: 'right', sortable: true},
			//{text: "AP item",width: 100, align: 'center',
		    // dataIndex: 'Expr3', sortable: false},
			{text: "Material Code", width: 80, align: 'center', dataIndex: 'matnr', 
			sortable: true},
			{text: "Item Description", width: 60,
			dataIndex: 'maktx', sortable: true},
            {text: "Quantity", width: 60, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'menge', sortable: true},
            {text: "Unit Price", width: 60, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'unitp', sortable: true},
            {text: "Amount (Before Vat)", width: 80, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'Expr6', sortable: true}
			
		];

		this.bbar = {
			xtype: 'pagingtoolbar',
			pageSize: 10,
			store: this.store,
			displayInfo: true
		};

		return this.callParent(arguments);
	},
	load: function(options){
		this.store.load({
			params: options,
			callback: function(records, operation, success) {
				                  var paynr_temp = ""; 
                                  var paynr_temp_last = ""; 
                                  var invnr_temp = ""; 
                                  var invnr_temp_last = ""; 
                                  for(i = 0;i<this.getCount();i++)
                                  {
                                      rt = this.getAt(i);
                                      paynr_temp_last = rt.get('payno');
                                      if( paynr_temp == rt.get('payno'))
                                      {
                                         rt.set('payno','');
                                         rt.set('bldat','');
                                         rt.set('lifnr','');
                                         rt.set('name1','');
                                         rt.set('netwr','');
                                         rt.set('statx','');
                                         rt.set('paytx','');
                                         
                                      	invnr_temp_last = rt.get('invnr');
                                        if( invnr_temp == rt.get('invnr'))
                                        {
                                           	rt.set('invnr','');
                                            rt.set('invdt','');
                                            rt.set('vat01','');
                                            rt.set('wht01','');
                                            rt.set('itamt','');
                                            rt.commit();
                                        }
                                        
                                      }
                                     
                                     paynr_temp = paynr_temp_last;
                                     invnr_temp = invnr_temp_last;
           
                                  }

                              }
		});
	}
});
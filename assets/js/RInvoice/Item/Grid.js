Ext.define('Account.RInvoice.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	requires: [
        'Ext.grid.feature.Grouping'
    ],
	features: [{
            id: 'group',
            ftype: 'grouping',
            groupHeaderTpl: '{name}',
            hideGroupedHeader: true,
            enableGroupingMenu: false,
			startCollapsed: true
    }],
	initComponent : function() {

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"invoice/loads_report",
                reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.invnr+o.vbelp; },
					totalProperty: 'totalCount'
				},
				simpleSortMode: true
			},
			fields: [
			    'invnr',
				'bldat',
                'jobnr',
				'vbeln',
				'ordnr',
				'delnr',
				'kunnr',
				'name1',
				'terms',
				'duedt',
				'overd',
				'statx',
				'matnr',
				'maktx',
				'menge',
                'unitp',
                'beamt',
                'vat01',
                'netwr'
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}],
			groupField: 'invnr'
		}); 

		this.columns = [
		    {text: "Invoice No.", width: 80, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "Invoice Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 70, align: 'center', dataIndex: 'bldat', sortable: true},
			{text: "Ref. Project No.", width: 80, align: 'center', 
			dataIndex: 'jobnr', sortable: true},
		    {text: "Ref. Quotation No.", width: 80, align: 'center', 
			dataIndex: 'vbeln', sortable: true},
		    {text: "Ref. Sale Order No.",  width: 80, align: 'center', 
		    dataIndex: 'ordnr', sortable: true},
		    {text: "Ref. Delivery Order No.",  width: 80, align: 'center', 
		    dataIndex: 'delnr', sortable: true},
			{text: "Customer Code", width: 80, dataIndex: 'kunnr', sortable: true},
			{text: "Customer Name", width: 120, dataIndex: 'name1', sortable: true},
			{text: "Credit Term", width: 80, align: 'center', dataIndex: 'terms', sortable: true},
            {text: "Due Date", width: 80, dataIndex: 'duedt', sortable: true},
			{text: "Over Due", width: 60, dataIndex: 'overd', sortable: true},
			{text: "Status", width: 80, dataIndex: 'statx',
			align: 'center', sortable: true},
			{text: "Material Code", width: 80, align: 'center', dataIndex: 'matnr', sortable: true},
			{text: "Item Description", width: 60, align: 'center', 
			dataIndex: 'maktx', sortable: true},
            {text: "Quantity", width: 60, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'menge', sortable: true},
            {text: "Unit Price", width: 60, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'unitp', sortable: true},
            {text: "Amount (Before Vat)", width: 80, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'beamt', sortable: true},
            {text: "Vat Amount", width: 80, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'vat01', sortable: true},
            {text: "Amount Including Vat", width: 80, align: 'center', 
            xtype: 'numbercolumn', dataIndex: 'netwr', sortable: true}
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
          //  alert(options.doc_start_from);
		this.store.load({
			params: options,
                        callback: function(records, operation, success) {
                                  var invnr_temp = ""; 
                                  var invnr_temp_last = ""; 
                                  for(i = 0;i<this.getCount();i++)
                                  {
                                      rt = this.getAt(i);
                                      invnr_temp_last = rt.get('invnr');
                                      if( invnr_temp == rt.get('invnr'))
                                      {
                                         //rt.set('invnr','');
                                         rt.set('bldat','');
                                         rt.set('jobnr','');
                                         rt.set('vbeln','');
                                         rt.set('ordnr','');
                                         rt.set('delnr','');
                                         rt.set('kunnr','');
                                         rt.set('name1','');
                                         
                                         rt.set('terms','');
                                         rt.set('duedt','');
                                         rt.set('overd','');
                                         rt.set('statx','');
                                         rt.commit();
                                      }
                                   
                                     invnr_temp = invnr_temp_last;
           
                                  }

                              }
		});
	}
});
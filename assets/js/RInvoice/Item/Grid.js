Ext.define('Account.RInvoice.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"invoice/loads",
                                extraParams: { doc_start_from : '',
                                               doc_start_to : '',
                                               invoice_from : '',
                                               invoice_to : '',
                                               so_no_from : '',
                                               so_no_to : '',
                                               cus_code_from : '',
                                               cus_code_to : '',
                                               saleperson_from : '',
                                               saleperson_to : '',
                                               invoice_status : ''
                                             },
                                actionMethods: {
                                             read: 'POST' 
                                         },
				reader: {
					type: 'json',
					root: 'rows'
                                        //ถ้าใส่ ID แล้วจะ ตัด record ที่ invnr ซํ้า
					//,idProperty: 'invnr'
				},
				simpleSortMode: true
			},
			fields: [
			        'invnr',
				'bldat',
                                'jobk',
				'ordnr',
				'name1',
				'terms',
				'duedt',
				'Over_Due',
				'statu',
				'matnr',
				'maktx',
				'menge',
                                'unitp',
                                'beamt',
                                'vat01',
                                'total'
			],
			remoteSort: true,
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
		        {text: "Invoid No.", width: 80, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "Invoid Date", xtype: 'datecolumn', format:'d/m/Y',width: 70, align: 'center', dataIndex: 'bldat', sortable: true},
			{text: "Ref. Project No.", width: 80, align: 'center', dataIndex: 'jobk', sortable: true},
		        {text: "Ref. sale Order No.",  width: 80, align: 'center', dataIndex: 'ordnr', sortable: true},
			{text: "Customer Name", width: 120, dataIndex: 'name1', sortable: true},
			{text: "Credit Term", width: 80, align: 'center', dataIndex: 'terms', sortable: true},
                        {text: "Due Date", width: 120, dataIndex: 'duedt', sortable: true},
			{text: "Over Due", width: 60, dataIndex: 'Over_Due', sortable: true},
			{text: "Status", width: 100, dataIndex: 'statu', sortable: true},
			{text: "Material Code'", width: 80, align: 'right', dataIndex: 'matnr', sortable: true},
			{text: "Item Description", width: 60, align: 'center', dataIndex: 'maktx', sortable: true},
                        {text: "Quantity", width: 60, align: 'center', dataIndex: 'menge', sortable: true},
                        {text: "Unit Price", width: 60, align: 'center', dataIndex: 'unitp', sortable: true},
                        {text: "Amount (Before Vat", width: 60, align: 'center', dataIndex: 'beamt', sortable: true},
                        {text: "Vat Amount(7%)", width: 60, align: 'center', dataIndex: 'vat01', sortable: true},
                        {text: "Amount Including Vat", width: 80, align: 'center', dataIndex: 'total', sortable: true}
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
			params: options
		});
	}
});
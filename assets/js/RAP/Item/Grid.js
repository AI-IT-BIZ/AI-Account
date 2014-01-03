Ext.define('Account.RAP.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"ap/loads_report",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: function(o){ return o.invnr+o.vbelp; }//'invnr'
				},
				simpleSortMode: true
			},
			fields: [
			    'invnr',
				'bldat',
                //'jobnr',
				//'ordnr',
				'ebeln',
				'lifnr',
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
			sorters: [{property: 'invnr', direction: 'ASC'}]
		});

		this.columns = [
		    {text: "AP No.", width: 80, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "AP Date", xtype: 'datecolumn', format:'d/m/Y',
			width: 70, align: 'center', dataIndex: 'bldat', sortable: true},
			//{text: "Ref. Project No.", width: 80, align: 'center', 
			//dataIndex: 'jobnr', sortable: true},
		    //{text: "Ref. Quotation No.", width: 80, align: 'center', 
			//dataIndex: 'vbeln', sortable: true},
		    {text: "Ref. PO No.",  width: 80, align: 'center', dataIndex: 'ebeln', 
		    sortable: true},
			{text: "Vendor Code", width: 80, dataIndex: 'lifnr', 
			align: 'center', sortable: true},
			{text: "Vendor Name", width: 120, dataIndex: 'name1', sortable: true},
			{text: "Credit Term", width: 80, align: 'center', dataIndex: 'terms', 
			sortable: true},
            {text: "Due Date", width: 80, dataIndex: 'duedt', 
            format:'d/m/Y', sortable: true},
			{text: "Over Due", width: 60, dataIndex: 'overd', sortable: true},
			{text: "Status", width: 80, dataIndex: 'statx',
			align: 'center', align: 'center', sortable: true},
			{text: "Material Code", width: 80, align: 'center', dataIndex: 'matnr', 
			sortable: true},
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
		this.store.load({
			params: options
		});
	}
});
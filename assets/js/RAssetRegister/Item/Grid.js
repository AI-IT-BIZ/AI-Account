Ext.define('Account.RAssetRegister.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"asset/loads_report",
                reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'matnr'
				},
				simpleSortMode: true
			},
			fields: [
			    'matnr',
				'maktx',
                'mtart',
                'mtype',
				'matkl',
				'mgrpp',
				'assnr',
				'asstx',
				'serno',
				'bldat',
				'costv',
				'saknr',
				'resid',
				'lifes',
				'depre',
				'deprem',
				'deprey',
				'curdt',
                'daysc',
                'accum',
                'saknr2',
                'books'
			],
			remoteSort: true,
			sorters: [{property: 'matnr', direction: 'ASC'}],
			groupField: 'matnr'
		});
                
                

		this.columns = [
		    {text: "Fixed Asset No.", width: 80, align: 'center', 
		    dataIndex: 'matnr', sortable: true},
		    {text: "Fixed Asset Name",  width: 150, align: 'left', dataIndex: 'maktx', sortable: true},
			{text: "Asset Type", 
			width: 70, align: 'center', dataIndex: 'mtart', sortable: true},
			{text: "Asset Type Discription",  width: 100, align: 'left', 
			dataIndex: 'mtype', sortable: true},
			{text: "Asset Group", width: 70, align: 'center', 
			dataIndex: 'matkl', sortable: true},
			{text: "Asset Grp Discription",  width: 100, align: 'left', 
			dataIndex: 'mgrpp', sortable: true},
		    {text: "Under Asset No.", width: 80, align: 'center', 
			dataIndex: 'assnr', sortable: true},
		    {text: "Under Asset Name",  width: 80, align: 'left', dataIndex: 'asstx', sortable: true},
			{text: "Serial No.", width: 80, align: 'center',dataIndex: 'serno', sortable: true},
			{text: "Acquisition Date", width: 120, align: 'center', xtype: 'datecolumn', format:'d/m/Y',
			dataIndex: 'bldat', sortable: true},
			{text: "Cost Value", width: 80, align: 'right', dataIndex: 'costv', sortable: true},
            {text: "GL Account No", width: 80, align: 'center',dataIndex: 'saknr', sortable: true},
            
			{text: "Residual Value", width: 120, xtype: 'numbercolumn', align: 'right',dataIndex: 'resid', sortable: true},
			{text: "Use full life(year)", width: 90, dataIndex: 'lifes',
			align: 'center', sortable: true},
			{text: "% of Depreciation", width: 100, align: 'right', 
			dataIndex: 'depre', sortable: true},
			{text: "Monthly Depreciation", width: 100, align: 'right', 
			xtype: 'numbercolumn', dataIndex: 'deprem', sortable: true},
            {text: "Yearly Depreciation", width: 100, align: 'right', 
            xtype: 'numbercolumn', xtype: 'numbercolumn', dataIndex: 'deprey', sortable: true},
            
            {text: "The Current Date", width: 100, align: 'center', xtype: 'datecolumn', format:'d/m/Y',
            dataIndex: 'curdt', sortable: true},
            {text: "Days for Depreciation", width: 100, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'daysc', sortable: true},
            
            {text: "Accummulated Depreciation(monthly)", width: 150, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'accum', sortable: true},
            {text: "GL Account No", width: 80, align: 'center', 
            dataIndex: 'saknr2', sortable: true},
            {text: "Book Value", width: 100, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'books', sortable: true}
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
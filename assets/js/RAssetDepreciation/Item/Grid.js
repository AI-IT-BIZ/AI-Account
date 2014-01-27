Ext.define('Account.RAssetDepreciation.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"asset/loads_depreciation",
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
				'assnr',
				//'asstx',
				'serno',
				'bldat',
				'costv',
				'saknr',
				'resid',
				'lifes',
				'depre',
                'accum',
                'mon1',
                'mon2',
                'mon3',
                'mon4',
                'mon5',
                'mon6',
                'mon7',
                'mon8',
                'mon9',
                'mon10',
                'mon11',
                'mon12',
                'mon1_name',
                'mon2_name',
                'mon3_name',
                'mon4_name',
                'mon5_name',
                'mon6_name',
                'mon7_name',
                'mon8_name',
                'mon9_name',
                'mon10_name',
                'mon11_name',
                'mon12_name'
			],
			remoteSort: true,
			sorters: [{property: 'matnr', direction: 'ASC'}],
			groupField: 'matnr'
		});



		this.columns = [
		    {text: "Fixed Asset No.", width: 80, align: 'center',
		    dataIndex: 'matnr', sortable: true},
		    {text: "Fixed Asset Name",  width: 150, align: 'left', dataIndex: 'maktx', sortable: true},

		    {text: "Under Asset No.", width: 80, align: 'center',
			dataIndex: 'assnr', sortable: true},

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
			{text: "Accummulated Depreciation(monthly)", width: 150, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'accum', sortable: true},

			{text: "January", width: 100, align: 'right',
			xtype: 'numbercolumn', dataIndex: 'mon1', sortable: true},
            {text: "Fabuary", width: 100, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'mon2', sortable: true},
            {text: "March", width: 100, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'mon3', sortable: true},
            {text: "April", width: 100, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'mon4', sortable: true},
            {text: "May", width: 100, align: 'center',
            xtype: 'numbercolumn', dataIndex: 'mon5', sortable: true},
            {text: "June", width: 100, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'mon6', sortable: true},

            {text: "July", width: 100, align: 'right',
			xtype: 'numbercolumn', dataIndex: 'mon7', sortable: true},
            {text: "August", width: 100, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'mon8', sortable: true},
            {text: "September", width: 100, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'mon9', sortable: true},
            {text: "October", width: 100, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'mon10', sortable: true},
            {text: "November", width: 100, align: 'center',
            xtype: 'numbercolumn', dataIndex: 'mon11', sortable: true},
            {text: "December", width: 100, align: 'right',
            xtype: 'numbercolumn', dataIndex: 'mon12', sortable: true}
		];

		this.store.on('load', function(store, records){
			var r = null,
				columns = _this.columns;
			if(records && records.length>0){
				r = records[0];
				for(var i=0;i<columns.length;i++){
					var c = columns[i];
					if(c.dataIndex.indexOf('mon')==0){
						c.setText(r.data[c.dataIndex+'_name']);
					}
				}
			}
		});

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
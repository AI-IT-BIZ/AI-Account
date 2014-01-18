Ext.define('Account.RAssetRegister.Item.Grid', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},
	/*requires: [
        'Ext.grid.feature.Grouping'
    ],
	features: [{
            id: 'group',
            ftype: 'grouping',
            groupHeaderTpl: '{name}',
            hideGroupedHeader: true,
            enableGroupingMenu: false,
			startCollapsed: true
    }],*/
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
				'matkl',
				'assnr',
				'serno',
				'bldat',
				'costv',
				'saknr',
				'resid',
				'lifes',
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
		    {text: "Fixed Asset No.", width: 80, align: 'center', dataIndex: 'invnr', sortable: true},
			{text: "Fixed Asset Type", xtype: 'datecolumn', format:'d/m/Y',
			width: 70, align: 'left', dataIndex: 'bldat', sortable: true},
			{text: "Fixed Asset Group", width: 80, align: 'left', 
			dataIndex: 'jobnr', sortable: true},
		    {text: "Under Asset No.", width: 80, align: 'center', 
			dataIndex: 'vbeln', sortable: true},
		    {text: "Fixed Asset Name",  width: 80, align: 'left', dataIndex: 'ordnr', sortable: true},
			{text: "Serial No.", width: 80, align: 'center',dataIndex: 'kunnr', sortable: true},
			{text: "Acquisition Date", width: 120, align: 'center',dataIndex: 'name1', sortable: true},
			{text: "Cost Value", width: 80, align: 'right', dataIndex: 'terms', sortable: true},
            {text: "GL Account Code", width: 80, align: 'center',dataIndex: 'duedt', sortable: true},
			{text: "Residual Value", width: 60, align: 'right',dataIndex: 'overd', sortable: true},
			{text: "Use full life(year)", width: 80, dataIndex: 'statx',
			align: 'right', sortable: true},
			{text: "% of Depreciation", width: 80, align: 'right', dataIndex: 'matnr', sortable: true},
			{text: "Monthly Depreciation", width: 60, align: 'right', 
			dataIndex: 'maktx', sortable: true},
            {text: "Yearly Depreciation", width: 60, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'menge', sortable: true},
            {text: "The Current Date", width: 60, align: 'center', 
            xtype: 'numbercolumn', dataIndex: 'unitp', sortable: true},
            {text: "Days for Depreciation", width: 80, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'beamt', sortable: true},
            {text: "Accummulated Depreciation(monthly)", width: 80, align: 'right', 
            xtype: 'numbercolumn', dataIndex: 'vat01', sortable: true},
            {text: "GL Account Code", width: 80, align: 'center', 
            xtype: 'numbercolumn', dataIndex: 'netwr', sortable: true},
            {text: "Book Value", width: 80, align: 'right', 
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
			/*params: options,
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

                              }*/
		});
	}
});
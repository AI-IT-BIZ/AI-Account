Ext.define('RGeneralLedger', {
	extend: 'Ext.data.Model',
	fields: ['bldat','belnr','kunnr','name1','txz01','debit','credi','statu','saknr','sgtxt','balance']
});

Ext.define('Account.RGeneralLedger.Result.Grid', {
	extend	: 'Ext.window.Window',
	requires: [
		'Ext.ux.grid.FiltersFeature',
		'Ext.ux.DataTip'
	],
	title: 'Report General Ledger',
	closeAction: 'hide',
	width: 780,
	height: 500,
	resizable: false,
	modal: true,
	layout:'fit',
	maximizable: true,
	maximized: true,
	params: {},
	initComponent:function(config) {
		me = this;
		var filters = {
			ftype: 'filters',
			encode: false,
			local: true,
			filters: [{
				type: 'string',
				dataIndex: 'saknr'
			}]
		};
		this.storeGrid = Ext.create('Ext.data.ArrayStore', {
			model: 'RGeneralLedger',
			fields: [
				{name: 'bldat', type: 'date', dateFormat: 'Y-m-d'},
				{name: 'belnr'},
				{name: 'invnr'},
				{name: 'name1'},
				{name: 'saknr'},
				{name: 'sgtxt'},
				{name: 'debit', type: 'float'},
				{name: 'credi', type: 'float'},
				{name: 'statu'},
				{name: 'kunnr'},
				{name: 'txz01'},
				{name: 'balance', type: 'float'}

			],
			data: [],
			groupers: ['saknr']
		});
		this.columnsGrid = [
			{text: 'Account Code', sortable: false, dataIndex: 'saknr'},
			{text: 'Account Name', sortable: false, dataIndex: 'sgtxt'},
			{text: 'Date', sortable: false, dataIndex: 'bldat', renderer: Ext.util.Format.dateRenderer('d/m/Y')},
			{text: 'Document Number', sortable: false, dataIndex: 'belnr'},
			{text: 'Customer/ Supplier Code', sortable: false, dataIndex: 'kunnr'},
			{text: 'Customer/ Supplier Name', sortable: false, dataIndex: 'name1'},
			{text: 'Description', sortable: false, dataIndex: 'txz01'},
			{text: 'Debit', align: "right", sortable: false, dataIndex: 'debit', renderer: Ext.util.Format.numberRenderer('0,000.00'),
				summaryType: function(records){
					var i = 0,
						length = records.length,
						total = 0,
						record;
					for (i=0; i < length; ++i) {
						record = records[i];
						total += Number(record.get('debit'));
					}
					return total;
				},
				summaryRenderer: function(value,summaryData,index){
					return '<b>'+Ext.util.Format.number(value,'0,000.00')+'</b>';
				}
			},
			{text: 'Credit', align: "right", sortable: false, dataIndex: 'credi', renderer: Ext.util.Format.numberRenderer('0,000.00'),
				summaryType: function(records){
					var i = 0,
						length = records.length,
						total = 0,
						record;
					for (i=0; i < length; ++i) {
						record = records[i];
						total += Number(record.get('credi'));
					}
					return total;
				},
				summaryRenderer: function(value,summaryData,index){
					return '<b>'+Ext.util.Format.number(value,'0,000.00')+'</b>';
				}
			},
			{text: 'Balance', align: "right", sortable: false, dataIndex: 'balance', renderer: Ext.util.Format.numberRenderer('0,000.00'),
				summaryType: function(records){
					var i = 0,
						length = records.length,
						total_credi = 0,
						total_debit = 0,
						total = 0,
						record;
					for (i=0; i < length; ++i) {
						record = records[i];
						total_credi += Number(record.get('credi'));
						total_debit += Number(record.get('debit'));
					}
					total = total_debit - total_credi;
					return total;
				},
				summaryRenderer: function(value,summaryData,index){
					return '<b>'+Ext.util.Format.number(value,'0,000.00')+'</b>';
				}
			},
			{text: 'Status', sortable: false, dataIndex: 'statu'},

		];

		this.grid = Ext.create('Ext.grid.Panel',{
			store: this.storeGrid,
			columns: this.columnsGrid,
			forceFit: true,
			features: [Ext.create('Ext.ux.grid.feature.MultiGroupingSummary', {
				id: 'group',
				//groupsHeaderTpl: {
				//	project: 'Project: {name}',
				//	estimate: '{name} hours',
				//	due: 'Due: {[Ext.Date.format(values.name, "d.m.Y")]}'
				//},
				hideGroupedHeader: false,
				enableGroupingMenu: true,
				startCollapsed: true
			}), {
				ftype: 'summary',
				dock: 'bottom'
			},filters]
		});
		this.items =[this.grid];
		this.tbar = [{
			text: "Excel",
			iconCls: 'b-small-excel',
			handler: function(){
				start_date = me.params.start_date;
				end_date = me.params.end_date;
				start_saknr = me.params.start_saknr;
				end_saknr = me.params.end_saknr;
				params = "start_date="+start_date+"&end_date="+end_date;
				params = params + "&start_saknr="+start_saknr+"&end_saknr="+end_saknr;
				window.location = __base_url + 'index.php/rgeneralledger/excel?'+params ;
			}
		}];
		return this.callParent(arguments);
	}
});
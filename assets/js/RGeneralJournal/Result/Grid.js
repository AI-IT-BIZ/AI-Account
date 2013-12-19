Ext.define('RGeneralJournal', {
	extend: 'Ext.data.Model',
	fields: ['bldat','belnr','invnr','name1','saknr','sgtxt','debit','credi','statu']
});

Ext.define('Account.RGeneralJournal.Result.Grid', {
	extend	: 'Ext.window.Window',
	requires: [
		'Ext.ux.grid.FiltersFeature'
	],
	title: 'Report General Journal',
	closeAction: 'hide',
	width: 780,
	height: 500,
	resizable: false,
	modal: true,
	layout:'fit',
	maximizable: false,
	initComponent:function(config) {
		var filters = {
			ftype: 'filters',
			encode: false,
			local: true,
			filters: [{
				type: 'boolean',
				dataIndex: 'visible'
			}]
		};
		this.storeGrid = Ext.create('Ext.data.ArrayStore', {
			model: 'RGeneralJournal',
			fields: [
				{name: 'bldat', type: 'date', dateFormat: 'Y-m-d'},
				{name: 'belnr'},
				{name: 'invnr'},
				{name: 'name1'},
				{name: 'saknr'},
				{name: 'sgtxt'},
				{name: 'debit', type: 'float'},
				{name: 'credi', type: 'float'},
				{name: 'statu'}
			],
			data: [],
			groupField: 'belnr'
		});
		this.columnsGrid = [
			{text: 'Sv Date', sortable: false, dataIndex: 'bldat', renderer: Ext.util.Format.dateRenderer('d/m/Y')},
			{text: 'SV Number', sortable: false, dataIndex: 'belnr', filterable:true, filter: {type: 'string'}},
			{text: 'Ref. Doc. No.', sortable: false, dataIndex: 'invnr'},
			{text: 'Customer', sortable: false, dataIndex: 'name1'},
			{text: 'Account Code', sortable: false, dataIndex: 'saknr'},
			{text: 'Account Name', sortable: false, dataIndex: 'sgtxt'},
			{text: 'Debit', sortable: false, dataIndex: 'debit', renderer: Ext.util.Format.numberRenderer('0,000.00'),
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
			{text: 'Credit', sortable: false, dataIndex: 'credi', renderer: Ext.util.Format.numberRenderer('0,000.00'),
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
			{text: 'Status', sortable: false, dataIndex: 'statu'}
		];
		
		this.grid = Ext.create('Ext.grid.Panel',{
			store: this.storeGrid,
			columns: this.columnsGrid,
			forceFit: true,
			features: [{
				id: 'group',
				ftype: 'groupingsummary',
				groupHeaderTpl: '{name}',
				hideGroupedHeader: false,
				enableGroupingMenu: true,
				startCollapsed: true
			},filters]
		});
		this.items =[this.grid]
		this.callParent(arguments);
	}
})
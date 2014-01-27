Ext.define('RGeneralJournal', {
	extend: 'Ext.data.Model',
	fields: ['bldat','belnr','invnr','name1','saknr','sgtxt','debit','credi','statu','kunnr']
});

Ext.define('Account.RGeneralJournal.Result.Grid', {
	extend	: 'Ext.window.Window',
	requires: [
		'Ext.ux.grid.FiltersFeature',
		'Ext.ux.DataTip'
	],
	title: 'Report General Journal',
	closeAction: 'hide',
	width: 780,
	height: 500,
	resizable: false,
	modal: true,
	layout:'fit',
	maximizable: true,
	maximized: true,
	params: {},
	loadMask: null,
	initComponent:function(config) {
		this.loadMask = new Ext.LoadMask(Ext.getBody(), {msg:"Please wait..."});

		var me = this;
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
				{name: 'statu'},
				{name: 'kunnr'}
			],
			data: [],
			groupers: ['bldat', 'belnr']
		});
		this.columnsGrid = [
			{text: 'JV Date', sortable: false, dataIndex: 'bldat', renderer: Ext.util.Format.dateRenderer('d/m/Y')},
			{text: 'JV Number', sortable: false, dataIndex: 'belnr', filterable:true, filter: {type: 'string'}},
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
						total += Number(record.get('credi'));
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
			text: "Print",
			handler: function(){
				start_date = me.params.start_date;
				end_date = me.params.end_date;
				kunnr = me.params.kunnr;
				comid = 1000;
				params = "start_date="+start_date+"&end_date="+end_date+"&kunnr="+kunnr+"&comid="+comid;
				url = __base_url + 'index.php/rgeneraljournal/pdf?'+params;
				Ext.create("Ext.window.Window",{
					title: "PDF",
					width: 830,
					height: 600,
					html: "<iframe src='"+url+"' style='width:100%;height:100%'></iframe>"
				}).show();
				//window.open(__base_url + 'index.php/rgeneraljournal/pdf?'+params,'_blank');
			}
		}];
		return this.callParent(arguments);
	}
});
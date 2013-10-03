Ext.define('Account.Quotation.Item.Grid_pc', {
	extend	: 'Ext.grid.Panel',
	constructor:function(config) {
		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;
        
		this.store = new Ext.data.JsonStore({
			proxy: {
				type: 'ajax',
				url: __site_url+"quotation/loads_conp_item",
				reader: {
					type: 'json',
					root: 'rows',
					idProperty: 'conty'
				}
			},
			fields: [
				'conty',
			    'contx',
			    'vtamt',
			    'ttamt'
			],
			remoteSort: true,
			sorters: ['conty ASC']
		});

		this.columns = [{
			text: "Condition type",
			width: 200,
			dataIndex: 'contx',
			sortable: true
			},
			{text: "Amount",
			width: 100,
			xtype: 'numbercolumn',
			dataIndex: 'vtamt',
			sortable: true,
			align: 'right'/*,
			field: {
                type: 'numberfield',
                decimalPrecision: 2,
				listeners: {
					focus: function(field, e){
						var v = field.getValue();
						if(Ext.isEmpty(v) || v==0)
							field.selectText();
					}
				}
			},*/
			},
			{text: "Condition Amount",
			width: 150,
			dataIndex: 'ttamt',
			align: 'right'/*,
			renderer: function(v,p,r){
				var net = _this.netValue;
				if(net<=0)
					return 0;
                //net = isNaN(net)?0:net;
				var perc = parseFloat(r.data['perct']);
				var amt = (perc * net) / 100;
				return Ext.util.Format.usMoney(amt).replace(/\$/, '');

				}*/
			}
		];

		return this.callParent(arguments);
	},

	load: function(options){
		this.store.load({
			params: options
		});
	}
});
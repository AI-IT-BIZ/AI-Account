Ext.define('BASE.form.field.PercentOrNumber', {
	extend	: 'Ext.form.field.Text',
	constructor:function(config) {
		var _this=this;

		this.validator= function(v){
			if(!Ext.isEmpty(v)){
				var regEx = /^([0-9]*)(\.[1-9]*)?$|^([0-9]|[1-9][0-9]|100)(\.[1-9]*)?(%)$/gi;
				if(regEx.test(v))
					return true;
				else
					return 'Value can be only numbers or percent';
			}else
				return true;
		};

		return this.callParent(arguments);
	},
	calculateValue: function(totalValue){
		var v = this.getValue(),
			regEx = /%$/gi;
		if(regEx.test(v)){
			var percVal = parseFloat(v.replace(regEx, ''));
			return totalValue * percVal / 100;
		}else{
			return v;
		}
	}
});
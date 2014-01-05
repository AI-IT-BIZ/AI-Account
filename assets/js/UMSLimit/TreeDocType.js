Ext.define('Account.UMSLimit.TreeDocType', {
	extend	: 'Ext.tree.Panel',
	constructor:function(config) {

		Ext.apply(this, {
            rootVisible: true
		});

		return this.callParent(arguments);
	},

	initComponent : function() {
		var _this=this;

		this.editDocAct = new Ext.Action({
			text: 'Edit document',
			iconCls: 'b-small-page_edit'
		});

		this.addLimitAct = new Ext.Action({
			text: 'Add limit',
			iconCls: 'b-small-money_add'
		});

		this.editLimitAct = new Ext.Action({
			text: 'Edit limit',
			iconCls: 'b-small-money'
		});

		this.removeLimitAct = new Ext.Action({
			text: 'Remove limit',
			iconCls: 'b-small-money_delete'
		});

		this.addEmp = new Ext.Action({
			text: 'Add employee',
			iconCls: 'b-small-user_add'
		});

		this.removeEmp = new Ext.Action({
			text: 'Remove employee',
			iconCls: 'b-small-user_delete'
		});

		var menuDocty = new Ext.menu.Menu({
			items : [this.editDocAct, this.addLimitAct]
        });

        var menuLimit = new Ext.menu.Menu({
			items : [this.editLimitAct, this.removeLimitAct, this.addEmp]
        });

        var menuUser = new Ext.menu.Menu({
			items : [this.removeEmp]
        });

        this.docWindow = Ext.create('Account.UMSLimit.Item.DocWindow');

        this.limitWindow = Ext.create('Account.UMSLimit.Item.LimitWindow');

        this.userWindow = Ext.create('Account.UMSLimit.Item.UserWindow');

		this.store = new Ext.data.TreeStore({
			autoLoad: false,
			clearOnLoad: true,
            proxy: {
                type: 'ajax',
                url: __site_url+'umslimit/loads_tree_doctype',
                extraParams: this.extraParams,
                reader: {
					type: 'json',
					root: 'rows',
                }
            },
            root: {
                text: 'Document',
                id: 'root'//,
                //expanded: true
            }
		});

        // Util function
		$splitter = '$';

		function is_node_root($id){
			return $id=='root';
		}
		function is_node_docty($id){
			$id = $id||'';
			return $id.split($splitter).length==2;
		}
		function is_node_limam($id){
			$id = $id||'';
			return $id.split($splitter).length==3;
		}
		function is_node_empnr($id){
			$id = $id||'';
			return $id.split($splitter).length==4;
		}
		function get_id($id){
			$id = $id||'';
			$splits = $id.split($splitter);
			if($split.length>0)
				return $splits[$split.length-1];
			else
				return null;
		}
        // End util function

		this.on('itemcontextmenu', function(tree, record, item, index, e, eOpts){
			e.preventDefault();
			var id = _this.getSelectedId();
			if(Ext.isEmpty(id)) return;

			if(is_node_docty(id))
				menuDocty.showAt(e.xy);
			else if(is_node_limam(id))
				menuLimit.showAt(e.xy);
			else if(is_node_empnr(id))
				menuUser.showAt(e.xy);
		});

		// event
		this.editDocAct.setHandler(function(){
			var id = _this.getSelectedId();
			if(Ext.isEmpty(id)) return;
			_this.docWindow.openDialog('edit', {
				id: id,
				comid: _this.extraParams.comid
			});
		});

		this.addLimitAct.setHandler(function(){
			var id = _this.getSelectedId();
			if(Ext.isEmpty(id)) return;
			_this.limitWindow.openDialog('add', {
				id: id,
				comid: _this.extraParams.comid
			});
		});

		this.editLimitAct.setHandler(function(){
			var id = _this.getSelectedId();
			if(Ext.isEmpty(id)) return;
			_this.limitWindow.openDialog('edit', {
				id: id,
				comid: _this.extraParams.comid
			});
		});

		this.removeLimitAct.setHandler(function(){
			var id = _this.getSelectedId();
			if(Ext.isEmpty(id)) return;
			_this.limitWindow.openDialog('remove', {
				id: id,
				comid: _this.extraParams.comid
			});
		});

		this.addEmp.setHandler(function(){
			var id = _this.getSelectedId();
			if(Ext.isEmpty(id)) return;
			_this.userWindow.openDialog('add', {
				id: id,
				comid: _this.extraParams.comid
			});
		});

		this.removeEmp.setHandler(function(){
			var id = _this.getSelectedId();
			if(Ext.isEmpty(id)) return;
			_this.userWindow.openDialog('remove', {
				id: id,
				comid: _this.extraParams.comid
			});
		});

		this.limitWindow.form.on('afterSave', function(form, action){
			_this.limitWindow.hide();
			if(form.form_action=='edit'){
				_this.reloadParentNode();
			}else
				_this.reloadCurrentNode();
		});

		this.limitWindow.form.on('afterDelete', function(form, action){
			_this.reloadParentNode();
		});

		this.docWindow.form.on('afterSave', function(form, action){
			_this.docWindow.hide();
			_this.reloadParentNode();
		});

		this.userWindow.form.on('afterSave', function(form, action){
			_this.userWindow.hide();
			if(form.form_action=='edit'){
				_this.reloadParentNode();
			}else
				_this.reloadCurrentNode();
		});

		this.userWindow.form.on('afterDelete', function(form, action){
			_this.reloadParentNode();
		});

		return this.callParent(arguments);
	},
	extraParams: null,
	load: function(params){
		var _this=this;
		this.store.load({
			params: params,
			callback: function(){
				_this.expandAll();
			}
		});
	},
	getSelectedRecord:function(){
		var sel = this.getSelectionModel(),
			rs = sel.getSelection();
		if(Ext.isArray(rs))
			return rs[0];
		else
			return null;
	},
	getSelectedId:function(){
		var sel = this.getSelectionModel(),
			rs = sel.getSelection();
		if(Ext.isArray(rs))
			return rs[0].data.id;
		else
			return null;
	},
	reloadCurrentNode: function(){
		var _this=this;
		var r = this.getSelectedRecord();
		this.store.load({
			node: r,
			callback: function(){
				_this.expandAll();
			}
		});
	},
	reloadParentNode: function(){
		var _this=this;
		var r = this.getSelectedRecord();
		var parentNode = _this.store.getById(r.data.parentId);
		this.store.load({
			node: parentNode,
			callback: function(){
				_this.expandAll();
			}
		});
	}
});
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>AI Account</title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/ext/resources/css/ext-all-neptune.css') ?>" />
	<script type="text/javascript" src="<?= base_url('assets/ext/ext-all.js') ?>"></script>
</head>
<body>

	<script type="text/javascript">

Ext.onReady(function() {
    var cw;

    Ext.state.Manager.setProvider(Ext.create('Ext.state.CookieProvider'));

	var viewport = Ext.create('Ext.Viewport', {
        layout: {
            type: 'border',
            padding: 5
        },
        defaults: {
            split: true
        },
        items: [{
            region: 'north',
            collapsible: true,
            title: 'North',
            split: true,
            height: 100,
            minHeight: 60,
            html: 'north'
        },{
            region: 'west',
            collapsible: true,
            title: 'West',
            split: true,
            width: 250,
            minHeight: 60,
            html: 'West content'
        },{
        	region:'center',
        	title:'PR',
        	html: 'PR content'
        }]
	});


});

	</script>

<div id="container">

</div>

</body>
</html>
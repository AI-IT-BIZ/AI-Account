<?php
function endsWith($haystack, $needle)
{
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}
	return (substr($haystack, -$length) === $needle);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>AI Account</title>

	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/ext/resources/css/ext-all.css') ?>" />
	<script type="text/javascript" src="<?= base_url('assets/ext/ext-all.js') ?>"></script>
	<script type="text/javascript" src="<?= base_url('assets/ext/ux/NumericField.js') ?>"></script>
	<script type="text/javascript">
		var __base_url = '<?= base_url() ?>',
			__site_url = '<?= endsWith(site_url(), '/')?site_url().'' : site_url().'/' ?>';
	</script>
	<link rel="stylesheet" type="text/css" href="<?= base_url('assets/css/style.css') ?>" />
</head>
<body>
	<?=$view?>
</body>
</html>

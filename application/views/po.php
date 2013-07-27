<h1>HELLO</h1>
<?php foreach($my_message AS $value): ?>
<h2><?= $value['id'] ?></h2>
<h3><?= $value['code'] ?></h3>
<?php endforeach; ?>
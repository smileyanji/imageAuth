<?php
include_once '../inc/config.inc' ;
$title = 'Image Auth SDK' ;
?>
<?php include_once INC . '/header.inc' ; ?>
		<div>
			<h1>Menu-Demo</h1>
		<div>
		<div>
			<p><a href="./home.php?storageKey=<?= $storageKey ?>"> - Folder list / Image list - </a></p>
		</div>
		<div>
			<p><a href="./rule.php?storageKey=<?= $storageKey ?>"> - Encoding rule - </a></p>
		</div>
	</body>
</html>
<?php include_once INC . '/js.inc' ; ?>
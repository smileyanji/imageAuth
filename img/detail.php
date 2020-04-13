<?php
include_once '../inc/config.inc' ;
$title = 'Image detail' ;
include_once INC . '/header.inc' ;
$file = $Image -> ImageDetail ( $_GET['image_key'] ) ;
if ( isset ( $_GET['folderKey'] ) )
	$url = "./home.php?storageKey={$_GET['storageKey']}&folderKey={$_GET['folderKey']}" ;
else
	$url = "./rule_list.php?storageKey={$_GET['storageKey']}&ruleKey={$_GET['ruleKey']}" ;
?>
<div>
	<p><a href="<?= $url ?>"> - Return to list - </a></p>
</div>
<div><h2>Image detail</h2></div>
<div> <img src="<?= $file['Image']['link'] ?>" height='300px'></div>
<div>
	<table name="storagesTable" class="tb-detail">
		<tr >
			<th width="100px">Image key</th><td><?= $_GET['image_key'] ?></td>
		</tr>
		<tr>
			<th>Name</th><td><?= $file['Image']['name'] ?></td>
		</tr>
		<tr>
			<th>Size</th><td><?= $file['Image']['size'] ?></td>
		</tr>
		<tr>
			<th>Type</th><td><?= $file['Image']['extension'] ?></td>
		</tr>
		<tr>
			<th>Date insert</th><td><?= $file['Image']['date_insert'] ?></td>
		</tr>
	</table>
</div>
</body>
</html>
<?php include_once INC . '/js.inc' ; ?>

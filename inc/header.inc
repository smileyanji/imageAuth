<?php
$k = key ( $_API['storageKey'] ) ;
if ( isset ( $_GET['storageKey'] ) && $_GET['storageKey'] != '' )
	$storageKey = $_GET['storageKey'] ;
else
	$storageKey= $_API['storageKey'][$k]  ;
?>
<html>
	<head>
		<title><?= $title ?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<link href="../style.css" rel="stylesheet">
	</head>
	<body>

		<div class="div_head">
			<span>Storage :</span>
			<select name="storage">
				<?php
				foreach ( $_API['storageKey'] as $k => $v ) :
					?>
					<option value="<?= $v ?>" <?= ( $storageKey == $v ) ? 'selected' : '' ?>><?= $k ?></option>
					<?php
				endforeach ;
				?>
			</select>
		</div>
		<div>
			<p class="div_head"><a href="./index.php?storageKey=<?= $storageKey ?>"> - Menu - </a></p>
		</div>


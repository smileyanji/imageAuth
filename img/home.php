<?php
include_once '../inc/config.inc' ;
$title = 'Folder list / Image list' ;
include_once INC . '/header.inc' ;
if ( $_GET['folderKey'] )
{
	$folderKey = $_GET['folderKey'] ;
	$key = $folderKey ;
}
else
	$key = $storageKey ;
$result = $Image -> folderSelect ( $key ) ;
$file = $Image -> ImageList ( $key ) ;
$folder = $result['Folders'] ;
$files = $file['images'] ;
?>
<div>
	<p class="div_head"><a href="./home.php?storageKey=<?= $storageKey ?>"> - Home - </a></p>
</div>
<div class="div_head">
	<h1>Folder list / Image list</h1>
	<div>
		<div class="div_head"><h2>Folder list</h2>
			<table>
				<thead>
					<tr>
						<th width="35%">Folder key</th>
						<th width="25%">Folder name</th>
						<th width="25%">Date insert</th>
						<th width="15%">Option</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ( ! empty ( $folder ) )
					{
						foreach ( $folder as $k => $v )
						{
							echo "<tr>" ;
							echo "<td>{$k}</td>" ;
							echo "<td>{$v['name']}</td>" ;
							echo "<td>{$v['date_insert']}</td>" ;
							echo "<td><a href='./home.php?storageKey={$storageKey}&folderKey={$k}'>In</a></td>" ;
							echo "</tr>" ;
						}
					}
					else
						echo "<tr id='jhh'><td colspan='6'><div class='well-lg text-warning text-center'> No folders </div></td></tr>" ;
					?>
				</tbody>
			</table>
		</div>
		<div class="div_head">
			<h2>Image list</h2>
			<table>
				<thead>
					<tr>
						<th width="5%"></th>
						<th width="25%">Image key</th>
						<th width="25%">Name</th>
						<th width="10%">Size</th>
						<th width="10%">Extension</th>
						<th width="10%">Date insert</th>
						<th width="10%">Detail</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if ( ! empty ( $files ) )
					{
						foreach ( $files as $k => $v )
						{
							echo "<tr>" ;
							echo "<td><input type='checkbox' name='ckbImg' value='{$k}'></td>" ;
							echo "<td>{$k}</td>" ;
							echo "<td>{$v['name']}</td>" ;
							echo "<td>{$v['size']}</td>" ;
							echo "<td>{$v['extension']}</td>" ;
							echo "<td>{$v['date_insert']}</td>" ;
							echo "<td><a href='./detail.php?storageKey={$storageKey}&image_key={$k}&folderKey={$key}'>Detail</a></td>" ;
							echo "</tr>" ;
						}
					}
					else
						echo "<tr><td colspan='6'><div class='well-lg text-warning text-center'> No Images </div></td></tr>" ;
					?>
				</tbody>
			</table>
		</div>
		<div class="div_head"><h2>Image delete</h2></div>
		<div class="div_head">
			<form name="delete" method="post">
				<button name="imgDelete" value="click">Image delete</button>
			</form>
		</div>
		<div class="div_head"><h2>Image upload</h2></div>
		<div class="div_head">
			<input name="folder_key" type="hidden" value="<?= $key ?>" >
			<form method="post" enctype="multipart/form-data" id="form">
				<input type="file" name="image[]"><br>
				<input type="hidden" name="url" value="<?= $_API['apiDomain'] . $_API['version'] ?>images/">
				<input type="hidden" name="token" value="<?= $result[0] ?>">
				<input type="button" onclick = "uploadImg ()" value="click"><br>
			</form>
		</div>
		</body>
		</html>
<?php include_once INC . '/js.inc' ; ?>

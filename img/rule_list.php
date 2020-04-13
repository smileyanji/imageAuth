<?php
include_once '../inc/config.inc' ;
$title = 'Encoding images' ;
include_once INC . '/header.inc' ;
$file = $Image -> imageList ( $_GET['ruleKey'] ) ;
$files = $file['images'] ;
?>
<p class="div_head"><a href="./rule.php?storageKey=<?=$storageKey?>"> - Back - </a></p>
<div class="div_head"><h2>Encoding images</h2></div>
<div class="div_head">
	<table>
		<thead>
			<tr>
				<th width="20%">Image key</th>
				<th width="35%">Name</th>
				<th width="8%">Size</th>
				<th width="8%">Extension</th>
				<th width="18%">Date insert</th>
				<th width="12%">Detail</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ( ! empty ( $files ) )
			{
				foreach ( $files as $k => $v )
				{
					echo "<tr>" ;
					echo "<td>$k</td>" ;
					echo "<td>{$v['name']}</td>" ;
					echo "<td>{$v['size']}</td>" ;
					echo "<td>{$v['extension']}</td>" ;
					echo "<td>{$v['date_insert']}</td>" ;
					echo "<td><a href='./detail.php?storageKey={$storageKey}&image_key={$k}&ruleKey={$_GET['ruleKey']}'>Detail</a></td>" ;
					echo "</tr>" ;
				}
			}
			else
				echo "<tr id='jhh'><td colspan='6'><div class='well-lg text-warning text-center'>No images</div></td></tr>" ;
			?>
		</tbody>
	</table>
</div>
</body>
</html>
<?php include_once INC . '/js.inc' ; ?>
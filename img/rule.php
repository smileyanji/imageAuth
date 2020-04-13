<?php
include_once '../inc/config.inc' ;
$title = 'Encoding rule' ;
include_once INC . '/header.inc' ;
$Rule = $Image -> ruleSelect ( $storageKey ) ;
$Rules = $Rule['rules'] ;
?>
<div class="div_head"><h2>Encoding rule</h2></div>
<div class="div_head">
	<table name="storagesTable">
		<thead>
			<tr>
				<th width="7%">Rule type</th>
				<th width="3%">Quality</th>
				<th width="5%">Ttype</th>
				<th width="3%">Cut</th>
				<th width="3%">Rotate</th>
				<th width="4%">Resize</th>
				<th width="4%">Width</th>
				<th width="4%">Height</th>
				<th width="4%">Crop</th>
				<th width="5%">BbColor</th>
				<th width="3%">Upsize</th>
				<th width="26%">Watermark</th>
				<th width="5%">Filter</th>
				<th width="11%">Memo</th>
				<th width="6%">Rule detail</th>
			</tr>
		</thead>
		<tbody>
			<?php if ( empty ( $Rules ) ) { ?>
				<tr><td colspan='20'><div class='well-lg text-warning text-center'>No encoding rules</div></td></tr>
			<?php
			}else
			{
			foreach ( $Rules as $v => $k ):
			?>
				<tr>
					<td><?=$k['type']?></td>
					<td><?=$k['quality']?></td>
					<td><?=$k['ttype'] ? $k['ttype'] : '원본 유직' ?></td>
					<td><?=$k['cut']?></td>
					<td><?=$k['rotate']?></td>
					<td><?=$k['r_type'] ? $k['r_type'] : '-' ?></td>
					<td><?=$k['r_w'] ? $k['r_w'] : '-' ?></td>
					<td><?=$k['r_h'] ? $k['r_h'] : '-' ?></td>
					<td><?=$k['r_crop'] ? $k['r_crop'] : '-' ?></td>
					<td><?=$k['r_bg'] ? '#' . $k['r_bg'] : '-' ?></td>
					<td><?=$k['r_upsize']? $k['r_upsize'] : '-' ?></td>
					<td class='text-break'><?=$k['wm_path']?$k['wm_path'] . '(align:'.$k['wm_align'].';x:'.$k['wm_x'].';y:'.$k['wm_y'].')' : '-' ?></td>
					<td><?=$k['f_type'] ? $k['f_type'].'('.$k['f_val'].')': '-' ?></td>
					<td><?=$k['memo']?></td>
					<td><a href='./rule_list.php?storageKey=<?=$storageKey?>&ruleKey=<?=$v?>'>Image list</a></td>
					</tr>
				<?php
			endforeach;
			}
			?>
		</tbody>
	</table>
</div>
</body>
</html>
<?php include_once INC . '/js.inc' ; ?>
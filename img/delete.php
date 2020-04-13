<?php
/*
 * ===========================================================================
 * 이미지 삭제 API 예제
 * ===========================================================================
 *
 * 이미지 삭제 : "images delete" API통해서 이미지를 삭제합니다.
 *
 * ---------------------------------------------------------------------------
 * 작성자: 리성림 <chenglin@smileserv.com>
 * 작성일: 2020년 04월 08일
 * ===========================================================================
 */


/*
 * 프레임워크 파일을 불러옵니다.
 */
include_once '../inc/config.inc' ;

$deleteArray = $_POST['imageKeys'] ;
if ( empty ( $deleteArray ) )
	exit ( 'No image keys' ) ;
/*
 * 이미지 삭제 API : image delete
 */
$re = $Image ->  imageDelete ( json_encode ( $deleteArray ) ) ;
if ( $re )
	if ( isset ( $re -> Error ) )
		echo $re -> RequestID . ' : ' . $re -> Message ;
	else if ( isset ( $re -> Result ) )
		echo $re -> Result ;
	else
		echo 'Image delete error' ;
else
	echo 'Images delete error' ;
exit ;
?>

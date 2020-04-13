<?php
define ( 'INC' , __DIR__ ) ;
define ( 'PROJECT' , dirname ( __DIR__ ) ) ;

include_once INC . '/img.inc' ;
include_once PROJECT . '/lib/Image.php' ;

$Image = new Image ( $_API );

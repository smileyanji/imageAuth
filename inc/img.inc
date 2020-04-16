<?php
$_API = array
(

/**
 * apiDomain
 * API서버 도메인
 * 'http://' or 'https://' 부터 시작합니다.
 */
'apiDomain' => 'http://imgapi.yanji.test' ,
 /**
 * accesskeyId
 * accesskey ID
 */
'accesskeyId' => 'HWmOVQnSs1b5H8Xv05vW0Lz4dB32R6t4' ,
 /**
 * accesskeySecret
 * accesskey 비번
 */
'accesskeySecret' => password_hash ( 'Cwt135w82w50ZdhcWlq4Zxj2K3Y27xh0' , PASSWORD_DEFAULT ) ,
 /**
 * storageKey
 * 스토리지키 ( 멀티 )
 */
'storageKey' => array(
	'storage' => 'Ec1sD2wY53228sMozm4B4U0Aj6wD1876' ,
	'storage1' => 'b1U5W58yiw7on4ONwKrXU40iW618t5v6' ,
	'storage2' => 'p15Tq8L2g5xC5PRdbGX03sX8eulL65L0'
	) ,

/**
 * version
 * api 버전
 */
'version' => '/v1/' ,
) ;

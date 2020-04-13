<?php
$_API = array
(

/**
 * apiDomain
 * API서버 도메인
 * 'http://' or 'https://' 부터 시작합니다.
 */
'apiDomain' => 'Input your api domain here!' ,
 /**
 * accesskeyId
 * accesskey ID
 */
'accesskeyId' => 'Input your api accesskey ID here!' ,
 /**
 * accesskeySecret
 * accesskey 비번
 */
'accesskeySecret' => password_hash ( 'Input your api accesskey secret here!' , PASSWORD_DEFAULT ) ,
 /**
 * storageKey
 * 스토리지키 ( 멀티 )
 */
'storageKey' => array(
                    'Input your api storag name here!'=>'Input your api storag key here!',
                    'Input your api storag name here!'=>'Input your api storag key here!',
                    'Input your api storag name here!'=>'Input your api storag key here!',
	) ,

/**
 * version
 * api 버전
 */
'version' => '/Input your api version here!/' ,
) ;

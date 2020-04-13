<?php

/**
 * 이미지 인증 sdk class
 * @package lib
 * @subpackage Get
 * @author zhoushiqi <zhoushiqi@smileserv.com>
 * @since 2019년 04월 01일
 */
class Image
{
	/**
	 * @var string accesskey ID
	 */
	private static $accesskeyId ;
	/**
	 * @var string accesskey 비번
	 */
	private static $accesskeySecret ;
	/**
	 * @var string 인증토큰
	 */
	public $token ;
	/**
	 * @var string api 도멘
	 */
	private static $apiDomain ;
	/**
	 * @var string 인증토큰 용청 url
	 */
	private static $tokenUrl ;
	/**
	 * @var string 폴더 관령 api 용청 url
	 */
	private static $folderUrl ;
	/**
	 * @var string 이미지 관령 api 용청 url
	 */
	private static $imageUrl ;
	/**
	 * @var string 인코딩 rule  관령 api 용청 url
	 */
	private static $ruleUrl ;

	/**
	 * __construct
	 * @param $setting array
	 *
	 */
	public function __construct ( $setting )
	{
		self::$accesskeyId = $setting['accesskeyId'] ;
		self::$accesskeySecret = $setting['accesskeySecret'] ;
		self::$apiDomain = $setting['apiDomain'] ;
		self::$folderUrl = $setting['version'] . 'folders/' ;
		self::$imageUrl = $setting['version'] . 'images/' ;
		self::$ruleUrl = $setting['version'] . 'rules/' ;
		self::$tokenUrl = $setting['version'] . 'authorization/' ;
		$this -> countOvertime = FALSE ;
		$url = self::$tokenUrl ;
		$dat = self::getToken ( $url , 'GET' , 1 ) ;
		$array = json_decode ( $dat , true ) ;
		$this -> token = $array['Token'] ;
	}

	/**
	 * curl 방식으로 api 서버를 접근하기
	 * @param string $url api주소
	 * @param string $way HTTP ACTION ( GET , POST , PUT , DELETE )
	 * @param int $int 토큰 유효기간 초과할때 다시 토큰을 요청했는지
	 * @param string $dataUse
	 * @return object return정보
	 */
	public function getToken ( $url , $way , $int , $dataUse = NULL )
	{
		$url = self::$apiDomain . $url ;
		$curl = curl_init () ;
		curl_setopt ( $curl , CURLOPT_URL , $url ) ;
		curl_setopt ( $curl , CURLOPT_RETURNTRANSFER , true ) ;
		curl_setopt ( $curl , CURLOPT_BINARYTRANSFER , true ) ;
		if ( $way == 'POST' )
		{
			curl_setopt ( $curl , CURLOPT_POST , 1 ) ;
			curl_setopt ( $curl , CURLOPT_POSTFIELDS , $dataUse ) ;
		}
		else
			curl_setopt ( $curl , CURLOPT_CUSTOMREQUEST , $way ) ;
		curl_setopt ( $curl , CURLOPT_REFERER , $_SERVER['SERVER_NAME'] ) ;
		if ( $int == '1' )
		{
			curl_setopt ( $curl , CURLOPT_HTTPHEADER , array (
				'AccesskeyID:' . self::$accesskeyId ,
				'accesskeySecret:' . self::$accesskeySecret
			) ) ;
		}
		else
		{
			curl_setopt ( $curl , CURLOPT_HTTPHEADER , array (
				"Authorization:{$this -> token}"
			) ) ;
		}
		$dat = curl_exec ( $curl ) ;
		return $dat ;
	}

	/**
	 * folderSelect 폴더 list select
	 * @param string $folder_key
	 * @return
	 */
	public function folderSelect ( $folder_key )
	{
		$url = self::$folderUrl ;
		$url .= $folder_key ;
		$dat = self::getToken ( $url , 'GET' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		$r = array_push ( $array , $this -> token ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

	/**
	 * imageList 이미지 list select
	 * @param string $key
	 * @return
	 */
	public function imageList ( $key ) // Image search
	{
		$urlUse = self::$imageUrl . '/list/' . $key ;
		$dat = self::getToken ( $urlUse , 'GET' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

	/**
	 * imageDetail 이미지 상세 select
	 * @param string $ImageKey
	 * @return
	 */
	public function imageDetail ( $ImageKey )
	{
		$urlUse = self::$imageUrl . '/detail/' . $ImageKey ;
		$dat = self::getToken ( $urlUse , 'GET' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

	/**
	 * imageDelete 이미지 삭제
	 * @param string $ImageKeys
	 * @return
	 */
	public function imageDelete ( $ImageKeys )//$ ImageKeys is an array (["xxx","dddd"]).
	{
		$urlUse = self::$imageUrl . $ImageKeys ;
		$dat = self::getToken ( $urlUse , 'DELETE' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

	/**
	 * ruleSelect  인코딩 rule select
	 * @param string $storageKey
	 * @return
	 */
	public function ruleSelect ( $storageKey ) // Image search
	{
		$urlUse = self::$ruleUrl . $storageKey ;
		$dat = self::getToken ( $urlUse , 'GET' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

	/**
	 * 결과 처리
	 * @param array 결과정보
	 * @param string $functionName 호출function 이름
	 * @param string $param1 파라미터
	 * @param string $param2 파라미터
	 * @return array 티코드 된 결과정보
	 */
	public function returnMsg ( $response , $functionName , $param1 = '' , $param2 = '' )
	{
		if ( ! $response )
			return FALSE ;

		if ( ! isset ( $response['Result'] ) )
			return FALSE ;

		if ( $this -> overtime ( $response -> Result ) )
		{
			$param = array () ;
			if ( $param1 )
				array_push ( $param , $param1 ) ;
			if ( $param2 )
				array_push ( $param , $param2 ) ;
			/**
			 * 세 토큰로 다시 function 호출하기
			 */
			return $this -> countOvertime ? NULL : call_user_func_array ( array ( $this , $functionName ) , $param ) ;
		}
		return $response ;
	}

	/**
	 *  토큰 유효시간 초과할때 다시요청 ( 한번만 )
	 * @param string $msg API return 메시지
	 * @return bool TRUE:다시요청 완료 ; FALSE:거절 ( 이미 다시요청했음 )
	 */
	public function overtime ( $msg )
	{
		if ( $msg == 'InvalidToken.Expired' )
		{
			$reqToken = json_decode ( $this -> __construct () ) ;
			$this -> countOvertime = TRUE ;
			return TRUE ;
		}
		else
		{
			$this -> countOvertime = FALSE ;
			return FALSE ;
		}
	}

}

<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Url
 *
 * @author zhoushiqi
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
	public $key ;
	private static $TrueUrl ;
	private static $base ;
	private static $FLODERS ;
	private static $IMAGES ;
	private static $JOBS ;
	private $countOvertime ;

//Connect api
	public function __construct ( $setting )
	{
		self::$accesskeyId = $setting['accesskeyId'] ;
		self::$accesskeySecret = $setting['accesskeySecret'] ;
		self::$TrueUrl = $setting['apiDomain'] ;
		self::$FLODERS = $setting['version'] . 'folders/' ;
		self::$IMAGES = $setting['version'] . 'images/' ;
		self::$JOBS = $setting['version'] . 'rules/' ;
		self::$base = $setting['version'] . 'authorization/' ;
		$this -> countOvertime = FALSE ;
		$url = self::$base ;
		$dat = self::way ( $url , 'GET' , 1 ) ;
		$array = json_decode ( $dat , true ) ;
		$this -> key = $array['Token'] ;
	}

	public function way ( $url , $way , $int , $dataUse = NULL )
	{
		$url = self::$TrueUrl . $url ;
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
				"Authorization:{$this -> key}"
			) ) ;
		}
		$dat = curl_exec ( $curl ) ;
		return $dat ;
	}

	public function folderSelect ( $folder_key )
	{
		$url = self::$FLODERS ;
		$urll = $url . "{$folder_key}" ;
		$dat = self::way ( $urll , 'GET' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		$r = array_push ( $array , $this -> key ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

	//upload image
	public function ImageUpload ( $dataUse ) //$dataUse upload files
	{
		$urlUse = self::$IMAGES ;
		$dataUse = http_build_query ( $dataUse , null , '&' ) ;
		$dat = self::way ( $urlUse , 'POST' , 2 , $dataUse ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

//View picture details
	public function ImageList ( $key ) // Image search
	{
		$urlUse = self::$IMAGES . '/list/' . $key ;
		$dat = self::way ( $urlUse , 'GET' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

// View picture link details
	public function ImageDetail ( $ImageKey )
	{
		$urlUse = self::$IMAGES . '/detail/' . $ImageKey ;
		$dat = self::way ( $urlUse , 'GET' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

	public function ImageDelete ( $ImageKeys )//$ ImageKeys is an array (["xxx","dddd"]).
	{
		$urlUse = self::$IMAGES . $ImageKeys ;
		$dat = self::way ( $urlUse , 'DELETE' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

	public function Rule ( $storageKey ) // Image search
	{
		$urlUse = self::$JOBS . $storageKey ;
		$dat = self::way ( $urlUse , 'GET' , 2 ) ;
		$array = json_decode ( $dat , true ) ;
		return $this -> returnMsg ( $array , __FUNCTION__ ) ;
	}

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

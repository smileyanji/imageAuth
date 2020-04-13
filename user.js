( function (){
	$ ( "select[name=storage]" ).change ( function ()	{
		var storage = $ ( this ).val () ;
		window.location.replace ( "./index.php?storageKey=" + storage ) ;
	} ) ;

	$ ( "button[name=imgDelete]" ).click ( function ()	{
		var checked = $ ( "input[name=ckbImg]:checked" ) ;
		if ( checked.length < 1 )
		{
			alert ( "선택된 이미지가 없습니다." ) ;
			return ;
		}
		var imageKeys = [ ] ;
		checked.each ( function () {
			imageKeys.push ( $ ( this ).val () ) ;
		} ) ;
		$.ajax ( {
			url : "./delete.php" ,
			type : "post" ,
			data : {
				imageKeys : imageKeys
			} ,
			success : function ( data )
			{
				alert ( data ) ;
				location.href = location.href ;
			} ,
			error : function ( e )
			{
				alert("이미지 삭제중에 문제발생했습니다.");
				console.log ( e ) ;
			}
		} ) ;
	} ) ;
} ) () ;

function uploadImg ( )
{
	var formdata = new FormData ( document.getElementById ( "form" ) ) ;
	var url = $ ( "input[name='url']" ).val () ;
	var folderKey = $ ( "input[name='folder_key']" ).val () ;
	$.ajax ( {
		type : "POST" ,
		dataType : "json" ,
		url : url + folderKey ,
		data : formdata ,
		processData : false ,
		contentType : false ,
		cache : false ,
		success : function ( json )
		{
			if ( json.Result !== '' )
			{
				alert ( json.Result ) ;
				location.href = location.href ;
			}
		} ,
		error : function ( )
		{
			alert ( "fail！" ) ;
		}
	} ) ;
}

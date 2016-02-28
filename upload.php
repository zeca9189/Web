<?php

	$fileName = $_FILES["file"]["name"];
	$fileTmpLoc= $_FILES["file"]["tmp_name"];
	$fileType = $_FILES["file"]["type"];
	$fileSize = $_FILES["file"]["size"];
	$fileErrorMsg=$_FILES["file"]["error"];
	if (!$fileTmpLoc) {
		echo "error";
		exit();
	}

	//랜덤으로 숫자 생성해서 보내주기

	$rand = mt_rand(0,100000);
	
	if (move_uploaded_file($fileTmpLoc, "file/$rand"."$fileName")) {
		
		echo "$rand"."$fileName";
		
	}else{
		echo "fail";
	}
	
	//

	// $result = array('width' => $_POST['width'], 'height' => $_POST['height'], 'status' => $status);
	//이런식으로 주면 받을떄 jquery로 retunrdata.width 이런식으로 해서 받으면 됨

?>
<?php

	if(isset($_POST["fname"]) AND isset($_POST['fx']) AND isset($_POST['fy']) AND isset($_POST['imagex']) AND isset($_POST['imagey'])) {
		$fName = $_POST["fname"];
		$fX = $_POST["fX"];
		$fY = $_POST["fY"];
		$imagex = $_POST["imagex"];
		$imagey = $_POST["imagey"];

		makeimage($fName);
	}else{
		   echo "error";
	}

	// //숫자 변환 함수
	// function convertxy($fX,$fY,$imagex,$imagey){
	// 	$convert_x = 0;
	// 	$convert_y = 0;


	// }

	function makeimage($fName){
		
		//컨버트는 나중에 계산 
		$convert_x = 0;
		$convert_y = 0;
		//list($width,$height)=getimagesize('file/'.$fName);  $userimagesize[0]

		//유저이미지 나중에 jpg인지 png인지 구분필요 나중에 800 600으로 전부 수정
		if (stristr($fName,".png")) {
			$userimage = imagecreatefrompng('file/'.$fName);
		}else if (stristr($fName,".jpeg") or stristr($fName,".jpg")){
			$userimage = imagecreatefromjpeg('file/'.$fName);
		}
		
		//첫번째 마진값에 잘라낼 이미지에 구멍뚫린 태극기를 붙이는 선작업
		$m_first = imagecreatefrompng('image/filter/m_first.png');
		imagealphablending($userimage, true);
		imagesavealpha($userimage, true);
		//1이 기준 2가 움직일꺼 , x,y 좌표 이미지의 어디 부분부터 어디까지 복사 할껀지
		// imagecopy($image_1, $image_2, 타겟위치x,타겟위치y, 0,0, 300, 270);
		imagecopy($userimage, $m_first, 100, 100, 0,0, 300, 270);

		//잘라낸넘 붙일 temp
		$tempimage = imagecreatetruecolor(300, 270);
		// imagecopyresized($결과물, $복사할파일, 0, 0, 타겟x,타겟y, $newwidth, $newheight, 300, 270);
		//temp를 생성 구멍뚫린 사진을 잘라낸다.
		//타겟 xy값만 받은값으로 수정
		ImageCopyResampled($tempimage,$userimage, 0,0,100,100,300,270,300,270);
		//잘라낸 이미지를 원래 사진에 붙여넣음
		//두번째 건곤감리 합치는 필터 
		//250 165는 화면 중간 모든 숫자 고정 
		$m_second = imagecreatefrompng('image/filter/m_second.png');
		imagecopy($m_second, $tempimage, 250, 165, 0,0, 300, 270);
		
		//세번째 태극무늬필터를 투명도를 줘서 합체시킴
		//여기도 모든 숫자 고정
		$m_third = imagecreatefrompng('image/filter/m_third.png');
		imagecopymerge($m_second, $m_third, 0, 0, 0, 0, 800,600, 60);
		
		//네번쨰 로고 이미지 붙인다.
		//여기도 모든 숫자 고정
		$m_forth = imagecreatefrompng('image/filter/m_forth.png');
		imagecopy($m_second, $m_forth, 650, 500, 0, 0, 150,100);

		//파일 생성 
		imagepng($m_second, 'mergeimage/'.$fName);

	}
?>
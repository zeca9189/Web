$(document).ready(function(){
    
    $('#select').click(function(){
        var formData = new FormData();
        var selectimage = document.getElementById('file').files[0];
        formData.append("file",selectimage);
        
        $.ajax({
            url: './upload.php',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(returndata){

                var myimg = $(document.createElement('img'));
                myimg.attr('id',"loadimage");
                myimg.addClass("loadimage");
                myimg.attr('src', 'file/'+returndata);
                $(myimg).appendTo('#mainimage');

                var firstfilter = $(document.createElement('img'));
                firstfilter.attr('id',"filterimage");
                firstfilter.addClass("firstfilter");
                firstfilter.attr('src', 'image/filter/m_first.png');
                $(firstfilter).appendTo('#mainimage').draggable();
            }
          });
    });

    $('#save').click(function(){

        //이미지 다운로드 버튼 url 설정,만들어진 이미지 보여주기
        //메인이미지랑 로드이미지 크기 받아서 보내기
        var tempfname =  $("#loadimage").attr('src').split('/');
        var fName =tempfname[1];
        var tfX =  $("#filterimage").css("left").split('px');
        var tfY =  $("#filterimage").css("top").split('px');
        var timagex = $("#filterimage").css("width").split('px');
        var timagey = $("#filterimage").css("height").split('px');

        var fX = tfX[0]; 
        var fY =  tfY[0]; 
        var imagex = timagex[0]; 
        var imagey = timagey[0]; 

        $.ajax({
            url: './merge.php',
            data:{ fname: ''+fName, fx: ''+fX ,fy: ''+fY ,imagex: ''+imagex ,imagey: ''+imagey},
            type: 'POST',
            success: function(returndata){
                var mergeurl= document.getElementById("m_imageurl");
                var mergeimg= document.getElementById("m_imageimg");

                mergeurl.href="./mergeimage/"+fName;
                mergeimg.src="./mergeimage/"+fName;

                var p = $(document.createElement('p'));
                p.attr('value',''+returndata);
                $(p).appendTo('#button');

            }
        });
    });
})
<div>
    <h1>编辑页面</h1>
    <input type="text" placeholder="demo" id ="nid_id" value="<?php print $node_wrapper->nid->value();?>" hidden>
</div>


<!-- <div>
    <h1>测试的页面</h1>
    <button class="btn btn-danger">这是一个按钮 </button>
</div> -->

<form enctype="multipart/form-data" id="upForm" class="form-horizontal">
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<label class="col-sm-2 control-label">名称</label>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-md-8">
					<input type="text" name="title" id="title" class="form-control" placeholder="title" value="<?php print $node_wrapper->title->value();?>" >
				</div>
			</div>
		</div>
	</div>
	<div class="hr-line-dashed"></div>
	<div class="form-group">
		<label class="col-sm-2 control-label">描述</label>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-md-8">
					<input type="text" name="body" id="body" class="form-control" placeholder="body" value="<?php print $body;?>">
				</div>
			</div>
		</div>
	</div>
	<!-- <div class="form-group">
		<label class="col-sm-2 control-label">图片信息</label>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-md-8">
					<input type="text" name="file" id="photo" class="form-control" placeholder="photo">
				</div>
			</div>
		</div>
	</div> -->
	<div class="hr-line-dashed"></div>
	<div class="main">
		<div class="upload-content">
			<!-- <h3>上传图片</h3> -->
			<div class="content-img">
				<ul class="content-img-list">
                <?php foreach($resultarr as $k=>$m) : ?>
                    <li class="content-img-list-item oldimg">
                        <img src="<?php echo $m?>" <?php echo "class = imgclass"?> value ="<?php echo $imgnamearr[$k]?>" alt="">
                        <div class="hide">
                            <a index="0" class="delete-btn"><i class="gcl gcllajitong"></i></a>
   
                        </div>
                    </li>
                <?php endforeach;?>     
                </ul>
				<div class="file">
					<i class="gcl gcladd"></i>
					<input type="file" name="file" accept="image/png,image/gif,image/jpg,image/jpeg" id="upload" multiple>
				</div>
			</div>
			<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

    <div>
        <button class="btn btn-info col-md-2" id="btn-submit-upload" style="margin-top: 20px;">上传</button>
    </div>
<script type="text/javascript">
$(function(){

    var imgFile = []; //文件流
    var imgSrc = []; //图片路径
    var imgName = []; //图片名字

    // //回显的图片添加到files
    // var imglength = $(".content-img-list-item").length; 
    // if(imglength>=1){
      
    // }
    $(function() {
        // 鼠标经过显示删除按钮
        $('.content-img-list').on('mouseover', '.content-img-list-item', function() {
            $(this).children('div').removeClass('hide');
        });
        // 鼠标离开隐藏删除按钮
        $('.content-img-list').on('mouseleave', '.content-img-list-item', function() {
            $(this).children('div').addClass('hide');
        });
        // 单个图片删除
        $(".content-img-list").on("click", '.content-img-list-item a .gcllajitong', function() {
            var index = $(this).parent().parent().parent().index(this);
            $(this).parent().parent().parent().remove();
      
            imgSrc.splice(index, 1);
            imgFile.splice(index, 1);
            imgName.splice(index, 1);

            // console.log(imgSrc);
            // console.log(imgFile);
            // console.log(imgName);
        });


        $(".content-img-list").on("click", '.content-img-list-item a .gclfangda', function() {
            // var index = $(this).parent().parent().parent().index();
            // $(".modal-content").html("");
            // var srcimg =  $(this).parent().parent().prev().attr('src');
            // var bigimg = $(".modal-content").html();
            // $(".modal-content").html(bigimg + '<div class="show"><img src="' + srcimg + '" alt=""><div>');
            // // $(".modal-content").append(
            // //     '<div class="show"><img src="' + imgSrc[a] + '" alt=""><div>'
            // // );

        });


    });
    //图片上传
    $('#upload').on('change', function(e) {

        var imgSize = this.files[0].size;
        // if (imgSize > 1024 * 500 * 1) { //1M
        //     return alert("上传图片不能超过500KB");
        // };
        if (this.files[0].type != 'image/png' && this.files[0].type != 'image/jpeg' && this.files[0].type != 'image/gif') {
            return alert("图片上传格式不正确");
        }
        var fileList = this.files;
  
        for (var i = 0; i < fileList.length; i++) {
            var imgSrcI = getObjectURL(fileList[i]);
            imgName.push(fileList[i].name);
            imgSrc.push(imgSrcI);
            imgFile.push(fileList[i]);
        }
        imgBox = '.content-img-list';
        addNewContent(imgBox);
        this.value = null; //上传相同图片
    });

//提交请求
    $('#btn-submit-upload').on('click', function() {
        
        // FormData上传图片
        var formFile = new FormData();
        // formFile.append("type", type);
        // formFile.append("content", content);
        // formFile.append("mobile", mobile);
        // 遍历图片imgFile添加到formFile里面
        $.each(imgFile, function(i, file) {
            formFile.append('myFile[]', file);
           
        });
        var imgnames = [];
        $(".imgclass").each(function(i){
            imgnames[i]= $(this).attr("value");
        });
  
        formFile.append('imgnames',imgnames);



        var title = $("#title").val();
        var body = $("#body").val();
        var photo = $("#photo").val();
        formFile.append('title',title);
        formFile.append('body',body);
        var nid_id =$("#nid_id").val();
        // formFile.append('photo',photo);
        var ajaximg = $.ajax({
                url: 'http://192.168.0.213/demo.php',
                type: 'POST',
                data: formFile,
                //这两个设置项必填
                contentType: false,
                processData: false,
                success: function(data) {
                    
                    // alert("上传成功");
                },
                error: function() {
                    alert("图片保存失败");
                }
            })
           var ajaxurl = $.ajax({
                url: 'edit/photo/'+nid_id,
                type: 'POST',
                data: formFile,
                //这两个设置项必填
                contentType: false,
                processData: false,
                success: function(data) {
                    // console.log(data);
                    // alert("上传成功");
                },
                error: function() {
                    alert("失败");
                }
            })
            $.when(ajaxurl,ajaximg).then(function(data1,data2){
                alert("图片信息保存成功");
            });

    });

    //图片展示
    function addNewContent(obj) {
        var imglength = $(".oldimg").length;
        if(imglength>=1){
            obj = '.content-img-list-item';
            $(".clearall").remove();
            for (var a = 0; a < imgSrc.length; a++) {
            var obj = $(obj).last();
           
            $(obj).after('<li class="content-img-list-item clearall"><img src="' + imgSrc[a] + '" alt="">' +
                '<div class="hide"><a index="' + a + '" class="delete-btn"><i class="gcl gcllajitong"></i></a>' +
                '</div></li>');
            }
        }else{
            $(obj).html("");
            for (var a = 0; a < imgSrc.length; a++) {
                var oldBox = $(obj).html();
                $(obj).html(oldBox + '<li class="content-img-list-item"><img src="' + imgSrc[a] + '" alt="">' +
                    '<div class="hide"><a index="' + a + '" class="delete-btn"><i class="gcl gcllajitong"></i></a>' +
                    '</div></li>');
            }
        }
    }


    //建立可存取到file的url
    function getObjectURL(file) {
        var url = null;
        if (window.createObjectURL != undefined) { // basic
            url = window.createObjectURL(file);
        } else if (window.URL != undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file);
        } else if (window.webkitURL != undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file);
        }
        return url;
    }
    });

</script>
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
					<input type="text" name="title" id="title" class="form-control" placeholder="title">
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
					<input type="text" name="body" id="body" class="form-control" placeholder="body">
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
    <div  class="form-group">
        <label class="col-sm-2 control-label">图片</label>
        <div class="col-sm-10">
            <div class="row">
				<div class="col-md-9">

                    <div class="main">
                        <div class="upload-content">
                            <!-- <h3>上传图片</h3> -->
                            <div class="content-img">
                                <ul class="content-img-list"></ul>
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

                </div>
            </div>
        </div>
    </div>   
</form>
    <div class="form-group form_actions">
        <div class="col-sm-4 col-sm-offset-2">
            <button type="button"class="btn btn-info col-md-4" id="btn-submit-upload">提交</button>
            <!-- <button type="button" class="btn btn-primary" id="temp_storage">暂存</button> -->
        </div>
    </div>

    <!-- <div>
        <button class="btn btn-info col-md-4" id="btn-submit-upload" style="margin-top: 20px;">上传</button>
    </div> -->
<script type="text/javascript">
var imgFile = []; //文件流
var imgSrc = []; //图片路径
var imgName = []; //图片名字
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
        var index = $(this).parent().parent().parent().index();
        imgSrc.splice(index, 1);
        imgFile.splice(index, 1);
        imgName.splice(index, 1);
        var boxId = ".content-img-list";
        addNewContent(boxId);
        if (imgSrc.length < 4) { //显示上传按钮
            $('.content-img .file').show();
        }
    });


    $(".content-img-list").on("click", '.content-img-list-item a .gclfangda', function() {
        // var index = $(this).parent().parent().parent().index();
        // $(".modal-content").html("");

        // var bigimg = $(".modal-content").html();
        // $(".modal-content").html(bigimg + '<div class="show"><img src="' + imgSrc[index] + '" alt=""><div>');
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

    var imgBox = '.content-img-list';
    var fileList = this.files;
    for (var i = 0; i < fileList.length; i++) {
        var imgSrcI = getObjectURL(fileList[i]);
        imgName.push(fileList[i].name);
        imgSrc.push(imgSrcI);
        imgFile.push(fileList[i]);
    }
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
        console.log(file);
	});
	var title = $("#title").val();
	var body = $("#body").val();
	var photo = $("#photo").val();
	formFile.append('title',title);
	formFile.append('body',body);
	// formFile.append('photo',photo);
    var ajaxurl = $.ajax({
            url: 'http://192.168.0.213/demo.php',
            type: 'POST',
            data: formFile,
            //这两个设置项必填
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                // alert("上传成功");
            },
            error: function() {
                alert("图片保存失败");
            }
        })
        var ajaximg =  $.ajax({
            url: 'upload/photo',
            type: 'POST',
            data: formFile,
            //这两个设置项必填
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                // alert("上传成功");
            },
            error: function() {
                alert("图片信息保存失败");
            }
        })
        $.when(ajaxurl,ajaximg).then(function(data1,data2){
		    alert("图片信息保存成功");
	    });

});

//删除
function removeImg(obj, index) {
    imgSrc.splice(index, 1);
    imgFile.splice(index, 1);
    imgName.splice(index, 1);
    var boxId = ".content-img-list";
    addNewContent(boxId);
}

//图片展示
function addNewContent(obj) {
    // console.log(imgSrc)
    $(obj).html("");
    for (var a = 0; a < imgSrc.length; a++) {
        var oldBox = $(obj).html();
        $(obj).html(oldBox + '<li class="content-img-list-item"><img src="' + imgSrc[a] + '" alt="">' +
            '<div class="hide"><a index="' + a + '" class="delete-btn"><i class="gcl gcllajitong"></i></a>' +
            '</div></li>');
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
</script>



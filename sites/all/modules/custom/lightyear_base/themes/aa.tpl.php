<!-- <div>
    <h1>测试的页面</h1>
    <button class="btn btn-danger">这是一个按钮 </button>
</div> -->

<form enctype="multipart/form-data" id="upForm">
	<div class="row" style="margin-left: 15px;">
		<a href="javascript:;" class="file">
			选择图片
			<input name="File" onchange="update()" accept="image/png,image/gif,image/jpg,image/jpeg" id="FS" type="file" multiple>
		</a>
	</div>
</form>	
<div id="imgsuolue" class="col-md-12" style="margin-top: 30px;">
</div>

<div>
	<button class="btn btn-info col-md-12" id="button" style="margin-top: 20px;">上传</button>
</div>

<script type="text/javascript">

function update() {
　　var Fs=$("#FS")[0];
　　for (var i=0; i<Fs.files.length; i++){
		//id='"+Fs.files[i].name+"'
   　　//window.URL.createObjectURL可以用于在浏览器上预览本地图片或者视频
　　　　var div="<div id='"+i+"' style='float:left;margin-top: 15px' class='col-md-3'><button class='delete btn btn-danger col-md-3'  onclick='deleteimg("+ i +")'  >删除</button><img width='200px' height='200px' src='"+window.URL.createObjectURL(Fs.files[i])+"'/> </div>"
　　　 $("#imgsuolue").after(div);
    }
}
var formData = new FormData($('form')[0]);
var deletearr = '';
$('#button').click(function(event) {
	formData['deletefile'] = deletearr;
　　//formdata储存异步上传数据
	var lenght = $(':file')[0].files.length;
	formData.append('delete',deletearr);
	for (let i = 0; i < lenght; i++) {
		formData.append('file' + i,$(':file')[0].files[i]);
	}
	 //坑点: 无论怎么传数据,console.log(formData)都会显示为空,但其实值是存在的,f12查看Net tab可以看到数据被上传了
	 $.ajax({
	  url:'upload/photo',
	  type: 'POST',
	  data: formData,
	  //这两个设置项必填
	  contentType: false,
	  processData: false,
	  success:function(data){
	  	// console.log(data);
        // alert("上传成功");
        // window.location.href="http://localhost/lightyear";
	  }
	 })
 });

function deleteimg(i) {
	//删除预览图
	// console.log(i);
	$("#"+i).remove();
	deletearr =i + "|" + deletearr ;
	console.log(deletearr);
	
}

</script>




<style>
.file {
    position: relative;
    display: inline-block;
    background: #D0EEFF;
    border: 1px solid #99D3F5;
    border-radius: 4px;
    padding: 4px 12px;
    overflow: hidden;
    color: #1E88C7;
    text-decoration: none;
    text-indent: 0;
    line-height: 20px;
}
.file input {
    position: absolute;
    font-size: 100px;
    right: 0;
    top: 0;
    opacity: 0;
}
.file:hover {
    background: #AADFFD;
    border-color: #78C3F3;
    color: #004974;
    text-decoration: none;
}
</style>
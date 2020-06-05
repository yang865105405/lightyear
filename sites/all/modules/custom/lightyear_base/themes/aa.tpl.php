<!-- <div>
    <h1>测试的页面</h1>
    <button class="btn btn-danger">这是一个按钮 </button>
</div> -->

<form enctype="multipart/form-data" id="upForm">
		 <input type="file" name="file" multiple ><br>
		 <input type="button" id="button" value="提交">
</form>
<script type="text/javascript">

$('#button').click(function(event) {
　　//formdata储存异步上传数据
	var lenght = $(':file')[0].files.length;
	var formData = new FormData($('form')[0]);
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
</script>
<div>
    <h1>测试的页面</h1>
    <button class="btn btn-danger">这是一个按钮 </button>
</div>

<form enctype="multipart/form-data" id="upForm">
		 <input type="file" name="file" ><br><br>
		 <input type="button" id="button" value="提交">
</form>
<div class="picDis">
    <img src="" alt="">
</div>

<script type="text/javascript">

$('#button').click(function(event) {
　　//formdata储存异步上传数据
	 var formData = new FormData($('form')[0]);
	 formData.append('file',$(':file')[0].files[0]);
	 //坑点: 无论怎么传数据,console.log(formData)都会显示为空,但其实值是存在的,f12查看Net tab可以看到数据被上传了
	 $.ajax({
	  url:'http://192.168.0.213/demo.php',
	  type: 'POST',
	  data: formData,
	  //这两个设置项必填
	  contentType: false,
	  processData: false,
	  success:function(data){
	  	// console.log(data);
        alert("上传成功");
        window.location.href="http://localhost/lightyear";
	  }
	 })
 });
</script>
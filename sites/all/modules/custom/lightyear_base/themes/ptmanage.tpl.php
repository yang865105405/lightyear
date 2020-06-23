<div>
    <h1>管理页面</h1>
    <?php foreach($resultarr as $m) : ?>
     <a class="btn btn-info" href="editpt/<?php echo $m ?>">编辑:<?php echo $m ?></a>
     <a class="btn btn-danger delete_node" href="javascript:void(0)" data-nid="<?php echo $m ?>">删除</a>

    <?php endforeach;?>      
</div>

<script>
    $(function(){
       $(".delete_node").on('click',function(){
            var formdata = new FormData();
            
           var nid_id = $(this).attr("data-nid");
           formdata.append("nid",nid_id);
           $.ajax({
            url: 'delete/photo',
            type: 'POST',
            data: formdata,
            //这两个设置项必填
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                window.location.reload();
            },
            error: function() {
                alert("图片保存失败");
            }
        })
       })
    });
</script>
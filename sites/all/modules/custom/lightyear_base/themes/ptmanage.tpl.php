<div>
    <h1>管理页面</h1>
    <?php foreach($resultarr as $m) : ?>
     <a class="btn btn-info" href="editpt/<?php echo $m ?>"><?php echo $m ?></a>
    <?php endforeach;?>      
</div>
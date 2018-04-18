<?php
//接口：根据数据id打开视频播放窗口
$id = $_GET["id"];
echo '<script>window.location.href="/?_a=mediaview&_c=media&_m=index&id='.$id.'";</script>';
?>

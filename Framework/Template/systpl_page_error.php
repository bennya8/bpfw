<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv='Refresh' content='<?php echo $time; ?>;URL=<?php echo $url; ?>'>
<title>消息提示</title>
<link href="<?php echo WEBROOT; ?>/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="<?php echo WEBROOT; ?>/Public/bootstrap/js/jquery.min.js"></script>
<script src="<?php echo WEBROOT; ?>/Public/bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
body{ background-image: URL("<?php echo WEBROOT; ?>/Public/bootstrap/img/bg.png"); }
#mainframe {width: 85%; margin: 30px auto;}
#pagemsg,#pagetime {margin: 20px 0 0 0; font-size: 16px; padding:5px;}
</style>
<script type="text/javascript">
function countDown(){
	var c = document.getElementById("countDown");
	c.innerText = c.innerText - 1;
}
setInterval("countDown()",1000);
</script>
</head>
<body>
	<div class="hero-unit" id="mainframe">
		<h1>操作完成！:)</h1>
		<span id="pagemsg" class="label label-important"><?php echo $message ?></span><br/>
		<span id="pagetime" class="label label-info">将在<span id="countDown"><?php echo $time; ?></span>秒后返回</span>
	</div>
</body>
</html>
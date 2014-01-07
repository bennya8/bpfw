<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>调试信息</title>
<link href="<?php echo WEBROOT; ?>/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="<?php echo WEBROOT; ?>/Public/bootstrap/js/jquery.min.js"></script>
<script src="<?php echo WEBROOT; ?>/Public/bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
body{ background-image: URL("<?php echo WEBROOT; ?>/Public/bootstrap/img/bg.png"); }
#mainframe {width: 86%; margin: 30px auto;}
#mainframe h2{color: #555;}
#pagemsg,#pagestack {margin: 5px 5px 0 0; font-size: 16px; padding:5px; font-size: 13px;}
</style>
</head>
<body>
	<div class="hero-unit" id="mainframe">
		<h2>调试信息</h2>
		<span span id="pagemsg" class="label">错误级别：</span><span id="pagemsg" class="label label-important"><?php echo $this->getErrorType($this->getCode()); ?></span><br/>
		<span span id="pagemsg" class="label">错误信息：</span><span id="pagemsg" class="label label-important"><?php echo $this->getMessage(); ?></span><br/>
		<span span id="pagemsg" class="label">文件位置：</span><span id="pagemsg" class="label label-warning"><?php echo securePath($this->getFile()); ?></span><br/>
		<span span id="pagemsg" class="label">错误行号：</span><span id="pagemsg" class="label label-warning"><?php echo $this->getLine(); ?></span><br/>
		<?php foreach($trace as $k=>$v){ ?>
		<span id="pagestack" class="label label-info"><?php echo securePath($v); ?></span><br/>
		<?php } ?>
	</div>
</body>
</html>
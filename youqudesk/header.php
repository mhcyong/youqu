<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh-CN" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <title><?php if($this->_currentPage>1) echo '第 '.$this->_currentPage.' 页 - '; ?><?php $this->archiveTitle(array(
		'category'  =>  _t('%s '),
		'search'    =>  _t('包含关键字 %s 的内容'),
		'tag'       =>  _t('标签 %s 下的内容'),
		'author'    =>  _t('%s-主页')
	), '', ' - '); ?><?php $this->options->title(); ?></title>       
	<meta name="description" content="<?php $this->options->description(); ?>">
	<link rel="shortcut icon" href="<?php $this->options->themeUrl('assets/icon.png')?>" type="image/png">
	<link href="<?php $this->options->themeUrl('assets/style.css')?>" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/jquery.js')?>"></script>
	
	<!-- 通过自有函数输出HTML头部信息 -->
	<nocompress><?php $this->header(); ?></nocompress>
	
</head>
<body>
<!-- header -->
<?php $this->need('nav.php'); ?>
<!-- end header -->
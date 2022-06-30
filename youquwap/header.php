<!DOCTYPE html>
<html lang="zh-CN">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
	<meta content="True" name="HandheldFriendly">
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0", name="viewport">
	
    <title><?php if($this->_currentPage>1) echo '第 '.$this->_currentPage.' 页 - '; ?><?php $this->archiveTitle(array(
		'category'  =>  _t('%s '),
		'search'    =>  _t('包含关键字 %s 的内容'),
		'tag'       =>  _t('标签 %s 下的内容'),
		'author'    =>  _t('%s-主页')
	), '', ' - '); ?><?php $this->options->title(); ?><?php if ( $this->is('index') ) : ?> - <?php $this->options->description(); ?> <?php endif; ?></title>       
	<meta name="description" content="<?php $this->options->description(); ?>">
    <link rel="shortcut icon" href="<?php $this->options->themeUrl('assets/icon.png')?>" type="image/png">
	<link href="<?php $this->options->themeUrl('assets/style.css')?>" rel="stylesheet" type="text/css">
	<!-- 通过自有函数输出HTML头部信息 -->
	<nocompress><?php $this->header(); ?></nocompress>
    </head>
    <body>
	
<!-- header -->
<?php $this->need('nav.php'); ?>
<!-- end header -->

<div class="container" style="clear: both; text-align: center; color: #808080; padding: 35px 0px;">
    © <?php $this->options->title(); ?>
	<?php if($this->user->hasLogin()): //判断是否登录 ?> 
		<a href="/my.html">我的</a>
		<a href="<?php $this->options->logoutUrl(); ?>">退出</a>
	<?php endif; ?>
    <a href="#top">返回顶部</a>
</div>


</body></html>
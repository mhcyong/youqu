<a id="top" name="top"></a>
<div class="header_container">
	<div class="container">
		<div class="logo">
		<a href="/"><img src="<?php $this->options->themeUrl('assets/logo.png')?>" alt="<?php $this->options->title(); ?>" style="height:30px; width:30px; padding-top:6px;"></a>
		</div>
		<div class="nav">
			<ul>
				<li><a href="/" style="color: #fff;">首页</a></li>
				<li><a href="/popular.html" style="color: #fff;">热门</a></li>
				<?php if($this->user->hasLogin()): ?> 
				<li><a href="/newpost.html" style="color: #fff;">+ 撰写笔记</a></li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="pro">
			<?php if($this->user->hasLogin()): 
			Typecho_Widget::widget('Widget_User')->to($user);
			?> 
			<div class="login_user">
				<a href="/my.html" class="profile-links">
					<span id="profile-image">
						<?php $email=$user->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" height="22" width="22">'; ?>
					</span>
				</a>
				<span class="screen-name"><a href="/my.html"><?php echo $user->screenName;?></a></span>
				<div class="dropdown">
					<ul class="user-dropdown" style="text-align: center;">
						<li><a href="/setting.html">设置</a></li>
						<li><a href="<?php $this->options->logoutUrl(); ?>">退出</a></li>
					</ul>
				</div>
			</div>
			<?php else: ?>
			<ul class="reg_link">
				<li>
				<a href="/tepass/signup">注册</a>
				</li>
				<li>
				<a href="/tepass/signin">登录</a>
				</li>
			</ul>			
			<?php endif; ?>
		</div>
	</div>
</div>
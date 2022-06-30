 <a id="top" name="top"></a>
<div class="header">
	<div class="container">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody><tr>
				<td width="40" align="left"><a href="/">首页</a></td>
				<td width="40" align="left"><a href="/popular.html">热门</a></td>
				<?php if($this->user->hasLogin()): ?> 
				<td width="auto" align="right" style="padding-top: 2px;">
					<a href="/newpost.html">撰写笔记</a>
				</td>
				<?php else: ?>
				<td width="auto" align="right" style="padding-top: 2px;">
					<a href="/tepass/signup" class="top">注册</a>&nbsp;&nbsp;&nbsp;
					<a href="/tepass/signin" class="top">登录</a>
				</td>
				<?php endif; ?>
			</tr>
		</tbody></table>
	</div>
</div>
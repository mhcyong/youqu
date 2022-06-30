<div class="sidebar" style="display: block;">

	<?php if($this->user->hasLogin()): //判断是否登录 ?>
		<div class="box" style="">
			<div>
				<div style="float:left; margin-right: 10px;">
					<a href="/author/<?php $this->user->uid(); ?>" style="display:block;">
						<?php $email=$this->user->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" width="100px" height="100px" class="hasLogin-author" >'; ?>
					</a>
				</div>
				<div style="">
					<div style="color:#636A86">
						<?php $this->user->screenName(); ?>
						<span class="sidebar_user_online"><span class="sidebar_user_online_text">•</span><span class="online_text">在线</span></span>
					</div>
					<?php $db = Typecho_Db::get(); $rsvips=$db->fetchRow($db->select()->from('table.tepass_vips')->where('table.tepass_vips.vip_uid=?',$this->user->uid)->limit(1)); ?>
					<div style="margin-top: 10px; color: #808080; word-wrap: break-word;overflow: hidden;"><?php echo htmlspecialchars($rsvips["vip_desc"]);?></div>
				</div>
			</div>
			<div style="clear: both;"></div>
			<div style="border-top:1px solid #E2E2E2; margin-top: 20px; padding-top:10px;">
				<a style="color: #808080;" href="/notification">0 条未读提醒</a>
			</div>
		</div>
	<?php else: ?>
		<div class="box" style="">
			<div style="padding: 0px 0px 8px 20px;">
				<div style="color: #808080; margin: 10px 0px; font-size: 16px;"><b style="color: #4B8DC5;"><?php $this->options->title(); ?></b>，<?php $this->options->description(); ?>。<br>这里是一个简单、温暖的小社区。</div>
			</div>
		</div>
	<?php endif; ?>	

	<div class="box" style="margin-top: 20px;">
		<div style="color: #808080;">热门标签</div>
		<div style="margin-top: 5px;">
			<a class="item_node item_node_add" href="/tag/求助">求助</a>
			<a class="item_node item_node_add" href="/tag/音乐">音乐</a>
			<a class="item_node item_node_add" href="/tag/吐槽">吐槽</a>
			<a class="item_node item_node_add" href="/tag/电影">电影</a>
			<a class="item_node item_node_add" href="/tag/恋爱">恋爱</a>
			<a class="item_node item_node_add" href="/tag/代码">代码</a>
			<a class="item_node item_node_add" href="/tag/新人">新人</a>
			<a class="item_node item_node_add" href="/tag/工作">工作</a>
			<a class="item_node item_node_add" href="/tag/爱情">爱情</a>
			<a class="item_node item_node_add" href="/tag/心情">心情</a>
			<a class="item_node item_node_add" href="/tag/生活">生活</a>
			<a class="item_node item_node_add" href="/tag/旅行">旅行</a>
			<a class="item_node item_node_add" href="/tag/分享">分享</a>
			<a class="item_node item_node_add" href="/tag/提问">提问</a>
			<a class="item_node item_node_add" href="/tag/晚安">晚安</a>
			<a class="item_node item_node_add" href="/tag/生日">生日</a>
			<a class="item_node item_node_add" href="/tag/调查">调查</a>
			<a class="item_node item_node_add" href="/tag/星座">星座</a>
			<a class="item_node item_node_add" href="/tag/游戏">游戏</a>
			<a class="item_node item_node_add" href="/tag/有趣">有趣</a>
			<a class="item_node item_node_add" href="/tag/校园">校园</a>
			<a class="item_node item_node_add" href="/tag/减肥">减肥</a>
			<a class="item_node item_node_add" href="/tag/无聊">无聊</a>
			<a class="item_node item_node_add" href="/tag/情感">情感</a>
			<a class="item_node item_node_add" href="/tag/女生">女生</a>
			<a class="item_node item_node_add" href="/tag/感情">感情</a>
			<a class="item_node item_node_add" href="/tag/站务">站务</a>
			<a class="item_node item_node_add" href="/tag/讨论">讨论</a>
		</div>
	</div>
	
	<div class="box" style="margin-top: 20px;">
		<div style="color: #808080;">自媒体号</div>
		<div style="margin-top: 5px;text-align:center;" class="homepage-links">
			<img class="qrcode" src="/qrcode.png" alt="且散微信自媒体"><br/>	
		</div>
	</div>
	
	<div class="box" style="margin-top: 20px;">
		<div style="color: #808080;">友情链接</div>
		<div style="margin-top: 5px;" class="homepage-links">
			<a target="_blank" href="https://pangsuan.com/">胖蒜网</a>
			<a target="_blank" href="https://qiesan.com/">且散笔记</a>
		</div>
	</div>
</div>
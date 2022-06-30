<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
 $this->need('header.php');
 ?>
 
<div class="container">
    <!--主体-->
    <div class="main radius">
        <div class="topic">
            <div class="topic_header" style=" border-bottom: 1px solid #E2E2E2;">
                <h1 style="font-size: 18px; font-weight: blod">
					<?php if( count($this->tags) > 0 ): ?>
						<a class="tag tag_<?php echo get_tagid_by_cid($this->cid); ?>" href="/tag/<?php $this->tags(',', false, ''); ?>">
						<?php $this->tags(',', false, ''); ?>
						</a>
					<?php endif; ?>
                    <?php $this->title() ?>
                </h1>
            </div>
            <div style="margin-top:15px; line-height: 23px; word-wrap: break-word;">
                <?php $this->content(); ?>
				<?php echo TePass_Plugin::getTePass(); ?>
            </div>
        </div>
    </div>

    <!--侧边栏-->
	<div class="sidebar" style="display: block;">
		<div class="box" style="">
			<div style="height: 100px;">
				<div style="float:left; margin-right: 10px;">
					<a class="icon" title="" href="<?php $this->author->permalink(); ?>">
						<?php $email=$this->author->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" height="100" width="100">'; ?>
					</a>
				</div>
				<div style="">
					<div style="color:#636A86"><?php $this->author(); ?></div>
					<?php 
					$db = Typecho_Db::get();
					$rsvips=$db->fetchRow($db->select()->from('table.tepass_vips')->where('table.tepass_vips.vip_uid=?',$this->author->uid)->limit(1)); ?>
					<div style="margin-top: 10px; color: #808080; word-wrap: break-word;overflow: hidden;"><?php echo htmlspecialchars($rsvips["vip_desc"]);?></div>
				</div>
			</div>
			<div style="border-top:1px solid #E2E2E2; margin-top: 20px;">
				<div class="topic_info">
					<span><?php $this->date(); ?> 发布</span>
					<span><?php Postviews($this); ?> 次访问</span>
					<span><?php $this->commentsNum('0 条评论', '1 条评论', '%d 条评论'); ?></span>
				</div>
			</div>
		</div>
		<?php if( count($this->tags) > 0 ): ?>
			<div class="box" style="margin-top: 15px;">
				<div style="color: #808080;">
					<a class="tag tag_<?php echo get_tagid_by_cid($this->cid); ?>" href="/tag/<?php $this->tags(',', false, ''); ?>">
					<?php $this->tags(',', false, ''); ?>
					</a>相关的其他话题
					<span style="float: right; margin-right: 20px;"><a style="color: #808080" href="/tag/<?php $this->tags(',', false, ''); ?>">全部&gt;&gt;</a></span>
				</div>
				<div class="homepage-links" style="margin-top: 8px;">		
					<?php $this->related(5)->to($relatedPosts); ?>	
					<?php while ($relatedPosts->next()): ?>
					<div style="margin-top: 3px;"><a href="<?php $relatedPosts->permalink(); ?>"><?php $relatedPosts->title(); ?></a></div>
					<?php endwhile; ?>
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
			<div style="color: #808080;">链接</div>
			<div style="margin-top: 5px;" class="homepage-links">
				<a target="_blank" href="https://pangsuan.com/">胖蒜</a>
				<a target="_blank" href="https://qiesan.com/">且散笔记</a>
			</div>
		</div>
	</div>
	
	<?php $this->comments()->to($comments); ?>
	<?php if ($comments->have()): ?>
		<div class="main radius normal-replies" style="margin-top: 20px; padding-top: 10px;">
			<div class="reply_list" style="padding: 10px 16px">
				<div style="padding: 5px 0px; margin-bottom: 5px; text-align: center;"></div>
				<?php $this->need('comments.php'); ?>            
			</div>        
		</div>
	<?php endif; ?>

  
  <?php if($this->user->hasLogin()): ?>
    <div class="main radius reply_box" style="margin-top: 20px;">
		<div class="reply_box comment-item" style="border: 0px; padding: 10px 16px 10px;">
			<?php if($this->allow('comment')): ?>
			<div id="<?php $this->respondId(); ?>">
				<div class="cancel-comment-reply">
					<?php $comments->cancelReply(); ?>
				</div> 
				<form method="post" action="<?php $this->commentUrl() ?>" autocomplete="off" id="topic_reply_add">
					<textarea id="reply_content" name="text" style="height: 90px; overflow: hidden;"></textarea>
					<div class="comment-submit">	
						<input class="submit" type="submit" value="回复">
						<?php $email=$this->user->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" style="height: 32px;vertical-align: middle;border-radius: 3px 3px 3px 3px;">'; ?><?php $this->user->screenName(); ?>. <a href="<?php $this->options->logoutUrl(); ?>" title="Logout">退出 &raquo;</a>				
					</div>
				</form> 
			</div>
			<?php else: ?>
			<h3><?php _e('评论已关闭'); ?></h3>
			<?php endif; ?>
		</div>
	</div>
   <?php else : ?>
    <div class="main radius reply_box" style="margin-top: 20px;">
        <div style="padding: 10px 16px;">
            <div style="text-align: center; color: #808080; margin-top: 7px;">欢迎来到且散笔记！这里是一个简单、温暖的小社区。</div>
            <div style="text-align: center; margin: 20px 0px 5px 0px;">
                <a href="/tepass/signup">
                    <img src="<?php $this->options->themeUrl('assets/button-register.gif');?>">
                </a>
            </div>
            <div style="text-align: center;">
                <a href="/tepass/signin">已经注册? 登录</a>
            </div>
        </div>
    </div>
   <?php endif; ?>  
	
</div>

<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->


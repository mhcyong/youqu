<?php
/**
* 个人中心
*
* @package custom
*/
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

$this->need('header.php');
if(!$this->user->hasLogin()){
	header("Location: /tepass/signin"); 
}
?>
<div class="container">
    <!--主体-->
    <div class="main radius radius-both">
        <div class="home-header radius_top radius-both">
            <div style="padding: 5px; color: #808080;">
                <span>
                     <?php $this->user->screenName(); ?> 发表的话题
                </span>
            </div>
        </div>
		<?php
		$db = Typecho_Db::get();
		$result = $db->fetchAll($db->select()->from('table.contents')
			->where('status = ?','publish')
			->where('table.contents.type = ?', 'post')
			->where('authorId = ?', $this->user->uid)
			->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
			->limit(50)
			->order('cid', Typecho_Db::SORT_DESC)
		);
		if($result){
			foreach($result as $val){            
				$val = Typecho_Widget::widget('Widget_Abstract_Contents')->push($val);
				$post_title = htmlspecialchars($val['title']);
				$permalink = $val['permalink'];
		?>	
		<div class="stream-item" id="topic_<?php echo $val['cid']; ?>" tid="<?php echo $val['cid']; ?>">
			<div class="mod status-item ">
				<div class="hd">
					<a class="icon" title="" href="/author/<?php echo $val['authorId'];?>">
						<?php $email=$this->user->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">'; ?>
					</a>
				</div>
				<div class="text">
					<span><a class="web_link" href="<?php echo $permalink; ?>#r<?php echo $val['commentsNum']; ?>"><?php echo $post_title; ?></a></span>
					<span onselectstart="return false;" title="快捷回复" class="icon-comments">
						<?php get_tag_by_cid($val['cid']);?>
						<?php if($val['commentsNum'] > 0): ?>
						<span class="comments-count"><?php echo $val['commentsNum']; ?></span>
						<?php endif; ?>
					</span>
				</div>
			</div>
		</div>	  
		<?php
			}
		}
		?>	
			
		<div style="padding: 15px 8px; text-align: center;">
			<a style="text-decoration:none; color: #808080;" class="page_item" href="/?start=64">更多话题</a>
		</div>

	</div>

    <!--侧边栏-->
	<?php $this->need('sidebar.php'); ?>
	
	<div class="comment" style="margin-left: 590px; width: 370px; display: none;">
		<div class="pane-toolbar">
			<a id="comment_close" class="close" href="/">×</a>
		</div>
		<div class="comments-items" style="height: 630px;">
			<div class="loading" style="text-align: center; padding: 20px 0px; display: none;">
				<div><img src="<?php $this->options->themeUrl('assets/loading.gif')?>"></div>
				<div style="color: #808080;">加载中</div>
			</div>
			<div></div>			
			<div id="comments_from_api" style="display: block;">				
				
			</div>
			<?php 
			$user = Typecho_Widget::widget('Widget_User');
			if ($user->uid > 0) {
				?>
				<div class="comment_form">
					<?php $this->comments()->to($comments); ?>
					<?php if($this->allow('comment')): ?>
					<div id="<?php $this->respondId(); ?>" class="respond">							
						<form id="new_comment_form" method="post" action="<?php $this->commentUrl() ?>" _lpchecked="1">						
						<div id="showfacenamereplace"></div>
						<div class="new_comment">
						<textarea name="text" rows="3" class="textarea_box" style="height: auto;width: 100%;line-height: 1.8;margin: 10px 0px;" placeholder="请尽量让你的回复有点意思~"></textarea></div>
						<input type="hidden" value="" id="reply_tid" name="tid">
						<div class="comment-submit">
							<input type="submit" class="submit" value="回复">
						</div>
						</form>  
					</div>
					<?php else: ?>
					<h3><?php _e('评论已关闭'); ?></h3>
					<?php endif; ?>
					
				</div>
				<?php
			}else{
				echo '
				<form id="new_comment_form" method="post" action="<?php $this->commentUrl() ?>" _lpchecked="1">
				<div class="comment_form" style="">
					<div class="comment-box">
						<a name="reply_box" id="reply_box"></a>
						<textarea id="reply_content" name="content"></textarea>
					</div>
					<div class="comment-submit">
						请先登录！
					</div>
				</div>
				</form> ';
			}?>
		</div>
	</div>
	
</div>
<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->

<?php
$p=Typecho_Cookie::getPrefix();
$q=$p.'__typecho_notice';//读取提醒内容
$y=$p.'__typecho_notice_type';//读取提醒类型
if (isset($_COOKIE[$y]) &&($_COOKIE[$y]=='success' || $_COOKIE[$y]=='notice' || $_COOKIE[$y]=='error')){
	if (isset($_COOKIE[$q])){
	?>
	<script>
	jQuery(function () {
		jQuery.notifyBar({
			"html": "成功创建话题",
			"cls":"success"
		});
	});
	</script>
	<?php
	Typecho_Cookie::delete('__typecho_notice');//删除提醒内容cookie
	Typecho_Cookie::delete('__typecho_notice_type');//删除提醒类型cookie
	}
}
?>

<?php
/**
 * 有趣的电脑版
 *
 * @package youqudesk
 * @author 胖蒜网
 * @version 1.0.0
 * @link https://pangsuan.com
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

<div class="container">
    <!--主体-->
    <div class="main radius radius-both">
        <div class="home-header radius_top radius-both">
            <div style="padding: 5px; color: #808080;">
                <span>
                     <?php $this->options->title(); ?>，<?php $this->options->description(); ?>。
                     <!--<a style="float: right; color: red;" href="">话题回复的“喜欢”功能上线啦！</a>-->
                </span>
            </div>
        </div>

			
		<?php while($this->next()): ?>
			<div class="stream-item" id="topic_<?php $this->cid() ?>" tid="<?php $this->cid() ?>" post_uid="<?php $this->author->uid() ?>">
				<div class="mod status-item ">
					<div class="hd">
						<a class="icon" title="" href="<?php $this->author->permalink(); ?>">
							<?php $email=$this->author->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">'; ?>
						</a>
					</div>
					<div class="text">
						<span><a class="web_link" href="<?php $this->permalink() ?>#r<?php $this->commentsNum('%d'); ?>"><?php $this->title() ?></a></span>
						<span onselectstart="return false;" title="快捷回复" class="icon-comments">
							<?php if( count($this->tags) > 0 ): ?>
							<a class="tag tag_<?php echo get_tagid_by_cid($this->cid);?>" href="/tag/<?php $this->tags(',', false, ''); ?>">
							<?php $this->tags(',', false, ''); ?>
							</a>
							<?php endif; ?>
							<?php if($this->commentsNum > 0): ?>
							<span class="comments-count"><?php $this->commentsNum('%d'); ?></span>
							<?php endif; ?>
						</span>
					</div>
				</div>
			</div>		
		<?php endwhile; ?>
				
		<div style="padding: 15px 8px; text-align: center;">
			<?php $this->pageLink('上一页'); ?>
			<?php $this->pageLink('下一页','next'); ?>
		</div>

	</div>

    <!--侧边栏-->
	<div class="comment" style="margin-left: 590px; width: 370px; display: none;">
		<div class="pane-toolbar">
			<a id="comment_close" class="close" href="/">×</a>
		</div>
		<div class="comments-items" style="height: 630px;">
			<div class="loading" style="text-align: center; padding: 20px 0px; display: none;">
				<div><img src="<?php $this->options->themeUrl('assets/loading.gif')?>"></div>
				<div style="color: #808080;">加载中</div>
			</div>
			<div id="content_from_api"></div>
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
	<?php $this->need('sidebar.php'); ?>
	
</div>
<?php $this->need('footer.php'); ?>
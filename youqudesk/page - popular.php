<?php
/**
* 热门列表
*
* @package custom
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
                     <!--<a style="float: right; color: red;" href="http://youqu.de/topic/25465">话题回复的“喜欢”功能上线啦！</a>-->
                </span>
            </div>
        </div>

		<?php //推荐的这里
		$tuijian = $this->options->tuijian;
		$hang = explode(",", $tuijian);
		$n=count($hang);
		$html="";
		for($i=0;$i<$n;$i++){
			$this->widget('Widget_Archive@tuijian'.$i, 'pageSize=1&type=post', 'cid='.$hang[$i])->to($tui);
			$email=$tui->author->mail; 
			$imgUrl = getGravatar($email);
			$tuitag = get_tag_by_cid($tui->cid);
			if($tuitag){ $tuitag = '<a class="tag tag_'.get_tagid_by_cid($tui->cid).'" href="/tag/'.$tuitag.'">'.$tuitag.'</a>';}else{ $tuitag = "";}
			if($tui->commentsNum > 0){ $show_commentNum = '<span class="comments-count">'.$tui->commentsNum.'</span>';}else{ $show_commentNum = "";}
			$html=$html.'
			<div class="stream-item" id="topic_'.$tui->cid.'" tid="'.$tui->cid.'" post_uid="'.$tui->authorId.'">
				<div class="mod status-item ">
					<div class="hd">
						<a class="icon" title="" href="/author/'.$tui->authorId.'">
							<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">
						</a>
					</div>
					<div class="text">
						<span><a class="web_link" href="'.$tui->permalink.'#r'.$tui->commentsNum.'">'.$tui->title.'</a></span>
						<span onselectstart="return false;" title="快捷回复" class="icon-comments">
							'.$tuitag.$show_commentNum.'														
						</span>
					</div>
				</div>
			</div>';
		}
		echo $html;
		?>
			
	
		<?php 
		$db = Typecho_Db::get();
		$result = $db->fetchAll($db->select()->from('table.contents')
			->where('status = ?','publish')
			->where('type = ?', 'post')
			->where('created <= unix_timestamp(now())', 'post') //添加这一句避免未达到时间的文章提前曝光
			->limit(64)
			->order('views', Typecho_Db::SORT_DESC)
		);
		?>
		
		<?php if($result){
        foreach($result as $val){
			$rsuserinfo = get_userinfo_by_uid($val['authorId']);
			$tuitag = get_tag_by_cid($val['cid']);
			if($tuitag){ $tuitag = '<a class="tag tag_'.get_tagid_by_cid($val['cid']).'" href="/tag/'.$tuitag.'">'.$tuitag.'</a>';}else{ $tuitag = "";}
			?>
			<div class="stream-item" id="topic_<?php echo $val['cid'] ?>" tid="<?php echo $val['cid'] ?>" post_uid="<?php echo $val['authorId'] ?>">
				<div class="mod status-item ">
					<div class="hd">
						<a class="icon" title="<?php echo $rsuserinfo['screenName'];?>" href="/author/<?php echo $val['authorId'];?>">
							<?php $email=$rsuserinfo['mail']; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">'; ?>
						</a>
					</div>
					<div class="text">
						<span><a class="web_link" href="/note/<?php echo $val['cid'] ?>#r<?php echo $val['commentsNum']; ?>"><?php echo $val['title'] ?></a></span>
						<span onselectstart="return false;" title="快捷回复" class="icon-comments">							
							<?php echo $tuitag;?><?php if($val['commentsNum'] > 0): ?><span class="comments-count"><?php echo $val['commentsNum']; ?></span><?php endif; ?>
						</span>
					</div>
				</div>
			</div>		
		<?php      }
			} ?>
		<div style="padding: 15px 8px; text-align: center;">
            <a style="text-decoration:none; color: #808080;" class="page_item" href="/last">更多笔记</a>
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
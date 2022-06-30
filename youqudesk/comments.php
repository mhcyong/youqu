<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
 
    $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
	
?>
 
<li id="li-<?php $comments->theId(); ?>" class="reply">
    <div id="<?php $comments->theId(); ?>" class="comment-item">
        <div class="icon">
            <?php $email=$comments->mail; $imgUrl = getGravatar($email);echo '<a href="/author/'.$comments->authorId.'"><img src="'.$imgUrl.'" width="45px" height="45px"></a>'; ?>
        </div>
		<div class="content">
            <p style="" class="reply_user">
				<cite class="fn"><a href="/author/<?php echo $comments->authorId; ?>"><?php CommentAuthor($comments); ?></a> </cite>
				<span class="comment-ua"><?php getOs($comments->agent); ?>  <?php getBrowser($comments->agent); ?></span>
				<?php if($comments->levels == 0): ?>
                <span class="comment-time floor" style="float: right;">#<?php echo $comments->sequence; ?></span>
				<?php endif; ?>
                <span class="comment-time">
                    <?php $comments->reply('<span class="reply_to">回复</span>'); ?>
                    <a style="display: none;" data="<?php echo $comments->coid;?>" title="查看会话" class="talk" href="/t/<?php echo $comments->cid;?>#">查看对话</a>
                    <span class="reply_time"><?php echo time_tran(date('Y-m-d H:i:s',$comments->created)); ?></span>
                </span>
            </p> 
			<p style="margin-top: 5px; line-height: 23px;">
                <span class="comment-text">
				<p><?php $parentMail = get_comment_at($comments->coid)?><?php echo $parentMail;?></p>
				<?php $comments->content(); ?>
				</span>
            </p>
        </div>
    </div>
	<?php if ($comments->children) { ?>
		<div class="comment-children">
			<?php $comments->threadedComments($options); ?>
		</div>
	<?php } ?>
</li>
<?php } ?>


<?php $this->comments()->to($comments); ?>

<?php if ($comments->have()): ?>
<h4 class="comments-title"><span><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></span></h4>
<?php $comments->listComments(); ?>
<?php $comments->pageNav('←','→','2','...'); ?>
<?php endif; ?>

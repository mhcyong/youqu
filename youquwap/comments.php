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
 
 
 
 <div class="reply" name="<?php $comments->theId(); ?>" id="<?php $comments->theId(); ?>">
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tbody><tr>
			<td class="avatar">
				<a href="/author/<?php echo $comments->authorId;?>">
					<?php $email=$comments->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" width="45px" height="45px">'; ?>
				</a>
			</td>

			<td class="each">
				<div class="name">
					<a href="/author/<?php echo $comments->authorId;?>" class="dark"> <?php CommentAuthor($comments); ?> </a>
					<?php $comments->reply('<span class="reply_to">回复</span>'); ?>
				</div>
				<div class="r">
					<?php $parentMail = get_comment_at($comments->coid)?><?php echo $parentMail;?>
					<?php $comments->content(); ?>
				</div>
			</td>

		</tr>
	</tbody></table>
	<?php if ($comments->children) { ?>
		<div class="comment-children">
			<?php $comments->threadedComments($options); ?>
		</div>
	<?php } ?>
</div>
		
<?php } ?>


<?php $this->comments()->to($comments); ?>

<?php if ($comments->have()): ?>
<h4 class="comments-title"><span><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></span></h4>
<?php $comments->listComments(); ?>
<?php $comments->pageNav('←','→','2','...'); ?>
<?php endif; ?>

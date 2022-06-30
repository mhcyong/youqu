<?php
/**
 * 有趣的手机版
 *
 * @package youquwap
 * @author 胖蒜网
 * @version 1.0.0
 * @link https://pangsuan.com
 */
 
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>


<div class="main container">

	<?php while($this->next()): ?>
    <div class="item">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tbody><tr>
				<td class="avatar">
					<a href="<?php $this->author->permalink(); ?>">
						<?php $email=$this->author->mail; $imgUrl = getGravatar($email);echo '<img src="'.$imgUrl.'" srcset="'.$imgUrl.'" class="avatar avatar-140 photo" height="46" width="46">'; ?>
					</a>
				</td>
				<td class="title">
					<a href="<?php $this->permalink() ?>#r<?php $this->commentsNum('%d'); ?>"><?php $this->title() ?></a>
				</td>
				<td width="30" class="comments-count">
				<?php if($this->commentsNum > 0): ?>
					<a href="<?php $this->permalink() ?>#r<?php $this->commentsNum('%d'); ?>"><?php $this->commentsNum('%d'); ?></a>
				<?php endif; ?>
				</td>
			</tr>
		</tbody></table>
	</div>
	<?php endwhile; ?>

    <div style="padding: 15px 8px; text-align: center;">
		<?php $this->pageLink('上一页'); ?>
		<?php $this->pageLink('下一页','next'); ?>
	</div>

</div>


<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->
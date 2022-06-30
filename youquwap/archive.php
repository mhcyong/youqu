<?php
/**
 * 柔弱的猫手机版
 *
 * @package WeakCat
 * @author 柔弱的猫
 * @version 1.0.0
 * @link https://weakcat.com
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
					<a href="<?php $this->permalink() ?>#r<?php $this->commentsNum('%d'); ?>"><?php $this->commentsNum('%d'); ?></a>
				</td>
			</tr>
		</tbody></table>
	</div>
	<?php endwhile; ?>

    <div style="padding: 15px 8px; text-align: center;">
		<a style="text-decoration:none; color: #808080;" class="more_item" href="/?start=64">更多笔记</a>
	</div>

</div>
<!-- footer -->
<?php $this->need('footer.php'); ?>
<!-- end footer -->